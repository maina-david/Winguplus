<?php
namespace App\Http\Controllers\app\subscriptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\currency;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\address;
use App\Models\wingu\languages;
use App\Models\wingu\country;
use App\Models\finance\payments\payment_terms;
use App\Models\finance\invoice\invoices;
use App\Models\finance\estimate\estimates;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\quotes\quotes;
use App\Models\finance\customer\groups;
use App\Models\project\project;
use App\Models\finance\customer\customer_group;
use File;
use Input;
use Helper;
use Session;
use Wingu;
use DB;
use Auth;

class customerController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$contacts = customers::join('business','business.id','=','customers.businessID')
						->where('customers.businessID',Auth::user()->businessID)
						->select('*','customers.id as customerID','customers.created_at as date_added')
						->OrderBy('customers.id','DESC')
						->get();
		$count = 1;

		return view('app.subscriptions.customer.index', compact('contacts','count'));
	}

	public function create(){
		$currency = currency::OrderBy('id','DESC')->pluck('currency_name','id')->prepend('Choose currency','');
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = groups::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->pluck('name','id');
		return view('app.subscriptions.customer.create', compact('currency','country','groups'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'email' => 'required',
			'customer_name' => 'required',
			'primary_phone_number' => 'required',
		]);

		//Check if email is already in use in the account
		$check_mail = customers::where('businessID',Auth::user()->businessID)->where('email',$request->email)->count();

		if($check_mail != 0){
			Session::flash('error','The email that you have provided is already linked to a customer in your account');

			return redirect()->back();
		} 

 		$primary = new customers;
		$code = Helper::generateRandomString(10);
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$code.'/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = Input::file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $upload_success = $file->move($path, $fileName);

         $primary->image = $fileName;
      }

		$primary->contact_type = $request->contact_type;  
		$primary->category = 'Subscriber';
		$primary->referral = $request->referral;
		$primary->reference_number = Helper::generateRandomString(10);
		$primary->salutation = $request->salutation;
		$primary->email = $request->email;
 		$primary->customer_name = $request->customer_name;
		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
		$primary->customer_code = $code;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->businessID = Auth::user()->businessID;
		$primary->created_by = Auth::user()->id;

 		$primary->save();


 		//address
 		$address = new address;
		$address->customerID = $primary->id;
		$address->bill_attention = $request->bill_attention;
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;

 		$address->ship_attention = $request->ship_attention;
 		$address->ship_street = $request->ship_street;
 		$address->ship_city = $request->ship_city;
 		$address->ship_state = $request->ship_state;
 		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_fax = $request->ship_fax;
		$address->ship_postal_address = $request->ship_postal_address;
 		$address->save();

	   Session::flash('success','Contact has been successfully Added');

	   return redirect()->route('subscription.customer.index');
 	}

 	public function edit($id){
		$currency = currency::OrderBy('id','DESC')->pluck('currency_name','id')->prepend('Choose currency','');
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$contact = customers::where('customers.id',$id)
						->join('customer_address','customer_address.customerID','=','customers.id')
						->where('businessID',Auth::user()->businessID)
						->select('*','customers.id as customerID')
						->first();
		$count = 1;

		return view('app.subscriptions.customer.edit', compact('contact','count','currency','country'));
 	}

 	public function update(Request $request, $id){
		$this->validate($request, [
			'customer_name' => 'required',
			'email' => 'required',
			'primary_phone_number' => 'required',
		]);

		$primary = customers::where('id',$id)->where('businessID',Auth::user()->businessID)->first();


		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$primary->customer_code.'/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = customers::where('id','=',$id)->where('image','!=', "")->count();

         if ($check > 0){
				$oldimagename = customers::where('id','=',$id)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
         }

         $file = Input::file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $upload_success = $file->move($path, $fileName);

         $primary->image = $fileName;
      }

		$primary->contact_type = $request->contact_type;
		$primary->email = $request->email;
		$primary->referral = $request->referral;
 		$primary->salutation = $request->salutation;
		$primary->customer_name = $request->customer_name;
 		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
 		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->updated_by = Auth::user()->id;
 		$primary->save();

 		//address
 		$address = address::where('customerID',$id)->first();
 		$address->bill_attention = $request->bill_attention;
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;

 		$address->ship_attention = $request->ship_attention;
 		$address->ship_street = $request->ship_street;
 		$address->ship_city = $request->ship_city;
 		$address->ship_state = $request->ship_state;
 		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_postal_address = $request->ship_postal_address;
 		$address->ship_fax = $request->ship_fax;
 		$address->save();

 		Session::flash('success','Contact has been successfully updated');

	   return redirect()->back();
 	}

 	public function show($id){
		$customerID = $id;
 		$count = 1;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					 ->where('customers.id',$id)
					 ->where('customers.businessID',Auth::user()->businessID)
					 ->select('*','customers.id as cid')
					 ->first();

		//comments
		$comments = comments::where('customerID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//creditnote
		$creditnotes = creditnote::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//contacts
		$contacts = contact_persons::where('customerID',$customerID)->get();

		//sales
		$monthlySales = DB::table('invoices')
							->where('businessID',Auth::user()->businessID)
							->where('customerID',$id)
                     ->select(
                        DB::raw("created_at as month"),
                        DB::raw("SUM(paid) as sales"))
                    ->orderBy("created_at")
                    ->groupBy(DB::raw("month(created_at)"))
                    ->get();

                    //return $monthlySales;

      $result[] = ['Month','sale'];
      foreach ($monthlySales as $key => $value) {
         $result[++$key] = [ date('M', strtotime($value->month)), $value->sales];
      }

      $sales =  json_encode($result);

 		return view('app.subscriptions.customer.view', compact('client','customerID','comments','invoices','estimates','creditnotes','contacts','sales'));
 	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
		$comment->customerID = $request->customerID;
		$comment->businessID = Auth::user()->businessID;
		$comment->save();

		Session::flash('success', 'comment added');

		return redirect()->back();
	}

	public function comment_delete($id){

		$delete = comments::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
	}

 	public function delete_contact_person($id){

 		$contact_person = contact_persons::where('id',$id)->first();

 		$contact_person->delete();

 		return redirect()->back();
 	}

 	public function update_quick_edit(){

 		$primary = customers::where('id',$id)->first();
 		$primary->company_name = $request->company_name;
 		$primary->salutation = $request->salutation;
 		$primary->first_name = $request->first_name;
 		$primary->last_name = $request->last_name;
 		$primary->contact_display_name = $request->contact_display_name;
 		$primary->contact_email = $request->contact_email;
 		$primary->work_phone = $request->work_phone;
 		$primary->mobile_phone = $request->mobile_phone;
 		$primary->currency = $request->currency;
 		$primary->facebook = $request->facebook;
 		$primary->twitter = $request->twitter;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
 		$primary->save();

 		return responce()->json($primary);

	 }


	
	 //delete permanently
	public function delete($id){

		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//credit note
		$creditnote = creditnote::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//quotes
		$quotes = quotes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//project
		$project = project::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		if($invoice == 0 && $creditnote == 0  && $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image','contact_email')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/clients/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customerID',$id)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$deleteclient = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->first();
			$deleteclient->delete();

			//delete address
			$address = address::where('customerID',$id)->first();
			$address->delete();

			//delete company group
			$check_group = customer_group::where('customerID',$id)->count();
			if($check_group > 0){
				$groups = customer_group::where('customerID',$id)->get();
				foreach($groups as $group){
					$deleteGroup = customer_group::find($group->id);
					$deleteGroup->delete();
				}
			}

			Session::flash('success','Contact was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
