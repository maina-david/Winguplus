<?php
namespace App\Http\Controllers\app\finance\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\estimate\estimates;
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
use App\Models\wingu\file_manager as documents;
use App\Models\subscriptions\subscriptions;
use App\Models\asset\assets;
use App\Models\finance\customer\events;
use App\Models\finance\customer\notes;
use App\Models\crm\sms;
use App\Models\crm\emails;
use App\Models\jobs\jobs;
use App\Models\jobs\tasks;
use File;
use Helper;
use Session;
use Wingu;
use Auth;

class contactController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		return view('app.finance.contacts.index');
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
		$category = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id');

		return view('app.finance.contacts.create', compact('country','category'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'customer_name' => 'required',
		]);

		//check if email is unique
		if($request->email != "" ){
			$check = customers::where('email',$request->email)->where('business_code',Auth::user()->business_code)->count();
			if($check != 0){
				Session::flash('warning','The provided email is already linked to a customer, Please use a different email !');

				return redirect()->back();
			}
		}

 		$primary = new customers;
		$customerCode = Helper::generateRandomString(10);
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$customerCode.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $primary->image = $fileName;
      }
 		$primary->contact_type = $request->contact_type;
		$primary->referral = $request->referral;
      $primary->customer_code = $customerCode;
		$primary->salutation = $request->salutation;
		$primary->email = $request->email;
 		$primary->customer_name = $request->customer_name;
		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
 		$primary->category = json_encode($request->category);
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->business_code = Auth::user()->business_code;
		$primary->created_by = Auth::user()->user_code;
 		$primary->save();


 		//address
 		$address = new address;
		$address->customer_code = $customerCode;
      $address->business_code = Auth::user()->business_code;
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
 		$address->ship_street = $request->ship_street;
 		$address->ship_city = $request->ship_city;
 		$address->ship_state = $request->ship_state;
 		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_fax = $request->ship_fax;
		$address->ship_postal_address = $request->ship_postal_address;
 		$address->save();

		$contacts = count(collect($request->cn_names));

 		//contact persons
		if($contacts > 0){
	  		if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {

					$contact_persons = new contact_persons;

					$contact_persons->customer_code = $customerCode;
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

      //recorded activity
      $activities = Auth::user()->name.' Has added a new customer '.$request->customer_name;
      $module = 'Finance';
      $section = 'Customer';
      $action = 'Create';
      $activityID = $customerCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

	   Session::flash('success','Contact has been successfully Added');

	   return redirect()->route('finance.contact.index');
 	}

 	public function edit($code){
 		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');

 		$contact = customers::where('fn_customers.customer_code',$code)
                           ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->select('*','fn_customers.customer_code as customer_code')
                           ->first();

      $jointcategories = json_decode($contact->category);

 		$persons = contact_persons::where('customer_code',$code)->get();

		//category
      $category = groups::where('business_code',Auth::user()->business_code)->pluck('name','name');

 		return view('app.finance.contacts.edit', compact('contact','jointcategories','persons','country','category'));
 	}

 	public function update(Request $request, $code){
		$this->validate($request, [
			'customer_name' => 'required'
		]);

		$primary = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();

		//check email
		if($request->email != $primary->email){
			$check = customers::where('email',$request->email)->where('business_code',Auth::user()->business_code)->count();
			if($check != 0){
				Session::flash('warning','The provided email is already linked to a customer, Please use a different email !');

				return redirect()->back();
			}
		}

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$primary->customer_code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         if($primary->image != ""){
				$delete = $path.$primary->image;
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
 		$primary->currency = $request->currency;
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
 		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
      $primary->category = json_encode($request->category);
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->updated_by = Auth::user()->user_code;
 		$primary->save();

 		//address
 		$address = address::where('customer_code',$code)->first();
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;

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

      //recorded activity
      $activities = Auth::user()->name.' Has updated '.$primary->customer_name.' customer details';
      $module = 'Finance';
      $section = 'Customer';
      $action = 'Update';
      $activityID = $code;

      Wingu::activity($activities,$section,$action,$activityID,$module);

 		Session::flash('success','Contact has been successfully updated');

	   return redirect()->back();
 	}

 	public function show($customerCode){
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$customerCode)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.id as cid','fn_customers.customer_code')
					->first();

		//contacts
		$contacts = contact_persons::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->get();

		//project
		$projectCount = jobs::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->count();
		$projects = jobs::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
		$paymentsCount = invoice_payments::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->count();
		$outstanding = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('balance');
		$totalIncome = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('paid');
		$invoiceCount = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->count();

		//quotes
		$quotesCount = quotes::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->count();
		$quotes = quotes::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//creditnote
		$unusedCredits = creditnote::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->sum('balance');
		$creditnotes = creditnote::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//sms count
		$smsCount = sms::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->count();

		//mail count
		$mailCount = emails::where('client_code',$customerCode)->where('business_code',Auth::user()->business_code)->count();

		//task count
		$taskCount = tasks::join('jb_jobs','jb_jobs.job_code','=','jb_tasks.job')
								  ->where('jb_jobs.customer',$customerCode)
								  ->where('jb_jobs.business_code',Auth::user()->business_code)
								  ->count();

		//subscription
		$subscriptionsCount = subscriptions::where('business_code',Auth::user()->business_code)
									->where('customer',$customerCode)
									->count();

		//assets
		$assetsCount = assets::where('business_code',Auth::user()->business_code)->where('customer',$customerCode)->where('category','Asset')->count();

		//meeting
		$eventsCount = events::where('business_code', Auth::user()->business_code)->where('customer_code',$customerCode)->count();

		//notes
		$countNotes = notes::where('business_code',Auth::user()->business_code)->where('customer_code',$customerCode)->count();

		//documents
		$folder = 'customer/'.$customerCode.'/documents';
		$documentsCount = documents::where('file_code',$customerCode)
									->where('business_code',Auth::user()->business_code)
									->where('folder',$folder)
									->where('section','customer')
									->count();

		//documents
		$salesOrderCount = salesorders::where('business_code',Auth::user()->business_code)->where('customer_code',$customerCode)->count();

		//comments
		$commentCount = comments::where('business_code',Auth::user()->business_code)->where('customer_code',$customerCode)->count();

		//subscription
		$subscriptions = subscriptions::join('wp_business','wp_business.business_code','=','subscriptions.business_code')
									->join('subscription_settings','subscription_settings.business_code','=','wp_business.business_code')
									->join('fn_product_information','fn_product_information.business_code','=','subscriptions.plan')
									->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
									->join('wp_status','wp_status.id','=','subscriptions.status')
									->where('subscriptions.business_code',Auth::user()->business_code)
									->where('subscriptions.customer',$customerCode)
									->orderby('subscriptions.id','desc')
									->select('*','wp_status.name as statusName','subscriptions.subscription_code as subscriptionID')
									->get();

		$count = 1;

      return view('app.finance.contacts.view', compact('client','customerCode','totalIncome','unusedCredits','contacts','outstanding','projectCount','invoiceCount','quotesCount','paymentsCount','smsCount','mailCount','taskCount','subscriptionsCount','assetsCount','eventsCount','countNotes','documentsCount','salesOrderCount','commentCount','invoices','quotes','creditnotes','projects','subscriptions'));
 	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->user_code;
		$comment->customer_code = $request->customer_code;
		$comment->business_code = Auth::user()->business_code;
		$comment->save();

		Session::flash('success', 'comment added');

		return redirect()->back();
	}

	public function comment_delete($id){

		comments::where('id',$id)->where('business_code',Auth::user()->business_code)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
	}

 	public function delete_contact_person($id){

 		$contact_person = contact_persons::where('id',$id)->first();

 		$contact_person->delete();

 		return redirect()->back();
 	}


	 //delete permanently
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

		if($invoice == 0 && $creditnote == 0 && $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteInfo = customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->select('image','customer_code')->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$deleteInfo->customer_code.'/';

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

         $activities = Auth::user()->name.' Has deleted a customer';
         $module = 'Finance';
         $section = 'Customer';
         $action = 'Delete';
         $activityID = $code;

         Wingu::activity($activities,$section,$action,$activityID,$module);

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('finance.contact.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}


   public function express_store(Request $request){
      $code = Helper::generateRandomString(20);
      $primary = new customers;
      $primary->customer_code = $code;
		$primary->customer_name = $request->customer_name;
      $primary->customer_code = $request->customer_name;
		$primary->email = $request->email;
		$primary->primary_phone_number = $request->phone_number;
      $primary->business_code = Auth::user()->business_code;
      $primary->created_by = Auth::user()->user_code;
		$primary->save();

		$address = new address;
		$address->customer_code = $code;
		$address->save();

   }

   public function express_list()
   {
      $customer = customers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['customer_code', 'customer_name as text']);
      return ['results' => $customer];
   }
}
