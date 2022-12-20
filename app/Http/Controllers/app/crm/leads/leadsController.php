<?php
namespace App\Http\Controllers\app\crm\leads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\address;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\crm\leads\status;
use App\Models\crm\leads\sources;
use App\Models\crm\leads\notes;
use App\Models\wingu\languages;
use App\Models\wingu\country;
use App\Models\wingu\industry;
use App\Models\finance\invoice\invoices;
use App\Models\finance\estimate\estimates;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\quotes\quotes;
use App\Models\finance\customer\groups;
use App\Models\jobs\jobs;
use App\Models\project\project;
use App\Models\wingu\wp_user;
use Auth;
use Wingu;
use Session;
use Helper;

class leadsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('app.crm.leads.index');
   }

   /**
   * Display leads on canvas view.
   *
   * @return \Illuminate\Http\Response
   */
   public function canvas(){
      return view('app.crm.leads.canvas');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $country = country::pluck('name','name')->prepend('Choose country', '');
      $languages = languages::pluck('name','id')->prepend('Choose language', '');
      $employees = wp_user::where('business_code',Auth::user()->business_code)->select('name as names','user_code')->pluck('names','user_code')->prepend('Choose users','');
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','status_code')->prepend('Choose status', '');
      $sources = sources::where('business_code',Auth::user()->business_code)->pluck('name','source_code')->prepend('Choose source', '');
      $industry = industry::pluck('name','id')->prepend('Choose industry');

      return view('app.crm.leads.create', compact('country','languages','employees','status','sources','industry'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'phone_number' => 'required',
         'leads_name' => 'required',
      ]);

      $code = Helper::generateRandomString(30);
      $leads = new customers;
      $leads->customer_code =  $code;
      $leads->title = $request->title;
      $leads->contact_type = $request->lead_type;
      $leads->category = 'Lead';
      $leads->salutation = $request->salutation;
      $leads->customer_name = $request->leads_name;
      $leads->email = $request->email;
      $leads->primary_phone_number = $request->phone_number;
      $leads->other_phone_number = $request->other_phone_number;
      $leads->designation = $request->designation;
      $leads->website = $request->website;
      $leads->status = $request->status;
      $leads->source = $request->source;
      $leads->remarks = $request->description;
      $leads->assigned = $request->assigned;
      $leads->industry = json_encode($request->industry);
      $leads->business_code = Auth::user()->business_code;
      $leads->save();

      //billing
      $address = new address;
      $address->customer_code = $code;
      $address->bill_city = $request->city;
      $address->bill_country  = $request->country;
      $address->bill_postal_address = $request->postal_address;
      $address->bill_state = $request->state;
      $address->bill_street = $request->location;
      $address->bill_zip_code = $request->zip_code;

      //shipping
      $address->ship_street = $request->location;
      $address->ship_city = $request->city;
      $address->ship_state = $request->state;
      $address->ship_zip_code = $request->zip_code;
      $address->ship_country = $request->country;
      $address->business_code = Auth::user()->business_code;
      $address->save();

      $contacts = count(collect($request->cn_names));
      //contact persons
		if($contacts > 0){
         if(isset($_POST['cn_names'])){
            for($i=0; $i < count($request->cn_names); $i++ ) {
               $contact_persons = new contact_persons;
               $contact_persons->customer_code = $code;
               $contact_persons->salutation = $request->cn_salutation[$i];
               $contact_persons->names = $request->cn_names[$i];
               $contact_persons->contact_email = $request->email_address[$i];
               $contact_persons->phone_number = $request->cp_phone_number[$i];
               $contact_persons->designation = $request->cn_desgination[$i];
               $contact_persons->business_code = Auth::user()->business_code;
               $contact_persons->save();
            }
         }
      }

      Session::flash('success','Lead added successfully');

      return redirect()->route('crm.leads.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($code)
   {
      $country = country::pluck('name','name')->prepend('Choose country', '');
      $employees = wp_user::where('business_code',Auth::user()->business_code)->select('name as names','id')->pluck('names','id')->prepend('Choose users');
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','status_code')->prepend('Choose status', '');
      $sources = sources::where('business_code',Auth::user()->business_code)->pluck('name','source_code')->prepend('Choose source', '');
      $industry = industry::pluck('name','name')->prepend('Choose industry');
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->first();
      $address = address::where('customer_code',$code)->first();
      $persons = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();
      $count = 1;

      return view('app.crm.leads.show', compact('lead','code','country','employees','status','sources','industry','persons','count','address'));
   }

   /**
    * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
      $edit = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->where('fn_customers.business_code',Auth::user()->business_code)
                        ->where('fn_customers.customer_code',$code)
                        ->select('*','bill_country as country','primary_phone_number as phone_number','bill_postal_address as postal_address','bill_city as city'
                        ,'bill_state as state','bill_zip_code as zip_code','bill_street as location','contact_type as lead_type','customer_name as leads_name','designation as position','remarks as description')
                        ->first();
      $country = country::pluck('name','name')->prepend('Choose country', '');
      $employees = wp_user::where('business_code',Auth::user()->business_code)->select('name as names','user_code')->pluck('names','user_code')->prepend('Choose users','');
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','status_code')->prepend('Choose status', '');
      $sources = sources::where('business_code',Auth::user()->business_code)->pluck('name','source_code')->prepend('Choose source', '');
      $industry = industry::pluck('name','name')->prepend('Choose industry');
      $persons = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      return view('app.crm.leads.edit', compact('country','employees','status','sources','industry','edit','persons'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code)
   {
      $this->validate($request, [
         'phone_number' => 'required',
         'leads_name' => 'required',
      ]);

      $leads = customers::where('business_code',Auth::user()->business_code)->where('category','Lead')->where('customer_code',$code)->first();
      $leads->title                = $request->title;
      $leads->contact_type         = $request->lead_type;
      $leads->salutation           = $request->salutation;
      $leads->customer_name        = $request->leads_name;
      $leads->email                = $request->email;
      $leads->primary_phone_number = $request->phone_number;
      $leads->other_phone_number = $request->other_phone_number;
      $leads->designation          = $request->designation;
      $leads->website              = $request->website;
      $leads->status               = $request->status;
      $leads->source               = $request->source;
      $leads->remarks              = $request->description;
      $leads->updated_by = Auth::user()->user_code;
      $leads->assigned = $request->assigned;
      $leads->business_code = Auth::user()->business_code;
      $leads->industry = json_encode($request->industry);
      $leads->save();

      //billing
      $address = address::where('customer_code',$code)->first();
      $address->bill_city = $request->city;
      $address->bill_country  = $request->country;
      $address->bill_postal_address = $request->postal_address;
      $address->bill_state = $request->state;
      $address->bill_street = $request->location;
      $address->bill_zip_code = $request->zip_code;

      //shipping
      $address->ship_attention = $request->leads_name;
      $address->ship_street = $request->location;
      $address->ship_city = $request->city;
      $address->ship_state = $request->state;
      $address->ship_zip_code = $request->zip_code;
      $address->ship_country = $request->country;
      $address->business_code = Auth::user()->business_code;
      $address->save();


      $contacts = count(collect($request->cn_names));

      //contact persons
      if($contacts > 0){
         if(isset($_POST['cn_names'])){
            for($i=0; $i < count($request->cn_names); $i++ ) {
               $contact_persons = new contact_persons;
               $contact_persons->customer_code = $code;
               $contact_persons->salutation = $request->cn_salutation[$i];
               $contact_persons->names = $request->cn_names[$i];
               $contact_persons->contact_email = $request->email_address[$i];
               $contact_persons->phone_number = $request->cp_phone_number[$i];
               $contact_persons->designation = $request->cn_desgination[$i];
               $contact_persons->business_code = Auth::user()->business_code;
               $contact_persons->save();
            }
         }
      }

      Session::flash('success','Lead update successfully');

      return redirect()->back();
   }

   public function delete_contact_person($id){

      contact_persons::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();

      Session::flash('success','Contact person deleted successfully');

      return redirect()->back();
   }

   public function convert($code){
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->first();

      $lead->category = NULL;
      $lead->updated_by = Auth::user()->user_code;
      $lead->save();

      Session::flash('success','Lead successfully converted');

      return redirect()->route('crm.customers.index');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($code){

		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('business_code',Auth::user()->business_code)->where('customer',$code)->count();

		//credit note
		$creditnote = creditnote::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//quotes
		$quotes = quotes::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//project
		$project = jobs::where('business_code',Auth::user()->business_code)->where('customer',$code)->count();

		if($invoice == 0 && $creditnote == 0 &&  $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteInfo = customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->select('image','contact_email')->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/clients/'.$code.'/images/';

				$delete = $path.$deleteInfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customer_code',$code)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->delete();

			//delete address
			address::where('customer_code',$code)->delete();

			Session::flash('success','Contact was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
