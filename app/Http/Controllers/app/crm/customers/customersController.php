<?php

namespace App\Http\Controllers\app\crm\customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\salesorder\salesorders;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\address;
use App\Models\wingu\country;
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\customer\groups;
use App\Models\finance\customer\customer_group;
use App\Models\wingu\file_manager as documents;
use App\Models\subscriptions\subscriptions;
use App\Models\asset\assets;
use App\Models\finance\customer\events;
use App\Models\finance\customer\notes;
use App\Models\crm\sms;
use App\Models\crm\emails;
use App\Models\jobs\jobs;
use App\Models\jobs\tasks;
use Session;
use Helper;
use Wingu;
use Auth;
use File;
use DB;

class customersController extends Controller
{
   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $customers = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->select('*','fn_customers.created_at as date_added','fn_customers.email as customer_email')
                           ->OrderBy('fn_customers.id','DESC')
                           ->get();

      return view('app.crm.customers.index', compact('customers'));
   }

   /**
   * customer details
   *
   * @return \Illuminate\Http\Response
   */
   public function show($code){
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$code)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as customerCode')
					->first();

		//contacts
		$contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

		//project
		$projectCount = jobs::where('customer',$code)->where('business_code',Auth::user()->business_code)->count();
		$projects = jobs::where('customer',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
		$paymentsCount = invoice_payments::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->count();
		$outstanding = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->sum('balance');
		$totalIncome = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->sum('paid');
		$invoiceCount = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->count();

		//quotes
		$quotesCount = quotes::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->count();
		$quotes = quotes::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//credit note
		$unusedCredits = creditnote::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->sum('balance');
		$creditnotes = creditnote::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//sms count
		$smsCount = sms::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->count();

		//mail count
		$mailCount = emails::where('client_code',$code)->where('business_code',Auth::user()->business_code)->count();

		//task count
		$taskCount = tasks::join('jb_jobs','jb_jobs.job_code','=','jb_tasks.job')
								  ->where('jb_jobs.customer',$code)
								  ->where('jb_jobs.business_code',Auth::user()->business_code)
								  ->count();

		//subscription
		$subscriptionsCount = subscriptions::where('business_code',Auth::user()->business_code)
									->where('customer',$code)
									->count();

		//assets
		$assetsCount = assets::where('business_code',Auth::user()->business_code)->where('customer',$code)->where('category','Asset')->count();

		//meeting
		$eventsCount = events::where('business_code', Auth::user()->business_code)->where('customer_code',$code)->count();

		//notes
		$countNotes = notes::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//documents
		$folder = 'customer/'.$client->customerCode;

		$documentsCount = documents::where('file_code',$code)
									->where('business_code',Auth::user()->business_code)
									->count();

		//documents
		$salesOrderCount = salesorders::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//comments
		$commentCount = comments::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//subscription
		$subscriptions = subscriptions::join('wp_business','wp_business.business_code','=','subscriptions.business_code')
									->join('subscription_settings','subscription_settings.business_code','=','wp_business.business_code')
									->join('fn_product_information','fn_product_information.product_code','=','subscriptions.plan')
									->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
									->join('wp_status','wp_status.id','=','subscriptions.status')
									->where('subscriptions.business_code',Auth::user()->business_code)
									->where('subscriptions.customer',$code)
									->orderby('subscriptions.id','desc')
									->select('*','wp_status.name as statusName','subscriptions.id as subscriptionID')
									->get();

      return view('app.crm.customers.view', compact('client','code','totalIncome','unusedCredits','contacts','outstanding','projectCount','invoiceCount','quotesCount','paymentsCount','smsCount','mailCount','taskCount','subscriptionsCount','assetsCount','eventsCount','countNotes','documentsCount','salesOrderCount','commentCount','invoices','quotes','creditnotes','projects','subscriptions'));
   }

   public function note_store(Request $request){

      $note = new note;

      $note->note = $request->note;
      $note->customer_code = $request->customer_code;
      $note->user_id = Auth::user()->user_code;
      $note->save();

      session::flash('Success','Note Successfully added');

      return redirect()->back();
   }

   /**
   * Add Customer
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','name');
      return view('app.crm.customers.create', compact('country','groups'));
	}

   //save contact
   public function contact_store(Request $request){
		$this->validate($request, array(
			'contact_type' => 'required',
         'customer_name' => 'required',
		));

      $code = Helper::generateRandomString(30);

		$contact = new customers;
      $contact->customer_code = $code;
		$contact->contact_type = $request->contact_type;
		$contact->salutation = $request->salutation;
		$contact->customer_name = $request->customer_name;
		$contact->email = $request->email;
		$contact->website = $request->website;
		$contact->other_phone_number = $request->other_phone_number;
		$contact->primary_phone_number = $request->primary_phone_number;
      $contact->designation = $request->designation;
 		$contact->department = $request->department;
		$contact->remarks = $request->remarks;
      $contact->facebook = $request->facebook;
      $contact->twitter = $request->twitter;
      $contact->linkedin = $request->linkedin;
      $contact->skypeID = $request->skypeID;
		$contact->referral = $request->referral;
      $contact->group = json_encode($request->groups);
      $contact->created_by = Auth::user()->user_code;
      $contact->business_code = Auth::user()->business_code;

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $contact->image = $fileName;
      }

		$contact->save();

		//address
		$address = new address;

		$address->customer_code  = $code;
		$address->bill_street    = $request->bill_street;
		$address->bill_city      = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;

		$address->ship_attention = $request->ship_attention;
		$address->ship_street = $request->ship_street;
		$address->ship_city = $request->ship_city;
		$address->ship_state = $request->ship_state;
		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_fax = $request->ship_fax;
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
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];
					$contact_persons->business_code = Auth::user()->business_code;
					$contact_persons->save();
				}
	 		}
		}

		session::flash('Success','Contact Successfully Added');

		return redirect()->route('crm.customers.index');
	}

   //edit
	public function edit($code){
      $country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');

 		$contact = customers::where('fn_customers.customer_code',$code)
                           ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->select('*','fn_customers.customer_code as customer_code')
                           ->first();

 		$persons = contact_persons::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->get();

		//category
      $category = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','name');

      $selectedCategory = json_decode($contact->group);

		return view('app.crm.customers.edit', compact('contact','country','persons','selectedCategory','category'));
	}

   /**
   * Update Customer
   *
   * @return \Illuminate\Http\Response
   */
   public function contact_update(Request $request,$code){

		$this->validate($request, array(
			'contact_type' => 'required',
         'customer_name' => 'required',
		));

		$update = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();

		if(!empty($request->image)){

			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$update->customer_code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         if($update->image){
				$delete = $path.$update->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
         }

         $file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $update->image = $fileName;
      }

		$update->contact_type = $request->contact_type;
		$update->email = $request->email;
 		$update->salutation = $request->salutation;
		$update->customer_name = $request->customer_name;
 		$update->email_cc = $request->email_cc;
 		$update->primary_phone_number = $request->primary_phone_number;
 		$update->other_phone_number = $request->other_phone_number;
 		$update->payment_terms = $request->payment_terms;
 		$update->portal = $request->portal;
 		$update->facebook = $request->facebook;
		$update->twitter = $request->twitter;
		$update->linkedin = $request->linkedin;
		$update->skypeID = $request->skypeID;
 		$update->website = $request->website;
 		$update->remarks = $request->remarks;
 		$update->designation = $request->designation;
 		$update->department = $request->department;
      $update->group = json_encode($request->groups);
		$update->updated_by = Auth::user()->user_code;
 		$update->save();

 		//address
 		$address = address::where('customer_code',$code)->first();
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
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];
					$contact_persons->business_code = Auth::user()->business_code;
					$contact_persons->save();
				}
			}
		}


 		Session::flash('success','Contact has been successfully updated');

	   return redirect()->back();
	}

	public function delete($id){
		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->count();

		//credit note
		$creditnote = creditnote::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->count();

		//quotes
		$quotes = quotes::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->count();

		//project
		$project = project::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->count();

		//subscription

		if($invoice == 0 && $creditnote == 0 && $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('id','=',$id)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('id','=',$id)->where('business_code',Auth::user()->business_code)->select('image','contact_email')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/clients/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customer_code',$id)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$deleteclient = customers::where('id','=',$id)->where('business_code',Auth::user()->business_code)->first();
			$deleteclient->delete();

			//delete address
			$address = address::where('customer_code',$id)->first();
			$address->delete();

			//delete company group
			$check_group = customer_group::where('customer_code',$id)->count();
			if($check_group > 0){
				$groups = customer_group::where('customer_code',$id)->get();
				foreach($groups as $group){
					$deleteGroup = customer_group::find($group->id);
					$deleteGroup->delete();
				}
			}

			//delete smses
			sms::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->delete();

			//delete notes
			notes::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->delete();

			//delete  events
			events::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->delete();

			//delete comments
			comments::where('business_code',Auth::user()->business_code)->where('customer_code',$id)->delete();

			//delete assets
			assets::where('business_code',Auth::user()->business_code)->where('customer',$id)->get();

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('crm.customers.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
