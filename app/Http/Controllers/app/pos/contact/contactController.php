<?php
namespace App\Http\Controllers\app\pos\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\estimate\estimates;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\salesorder\salesorders;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\address;
use App\Models\wingu\country;
use App\Models\project\tasks;
use App\Models\project\project;
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
		return view('app.pos.contacts.index');
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id');
		return view('app.pos.contacts.create', compact('country','groups'));
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
		$code = Helper::generateRandomString(30);
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$code.'/images/';

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

         $primary->image = $fileName;
      }
      $primary->customer_code        = $code;
 		$primary->contact_type         = $request->contact_type;
		$primary->referral             = $request->referral;
		$primary->salutation           = $request->salutation;
		$primary->email                = $request->email;
 		$primary->customer_name        = $request->customer_name;
		$primary->email_cc             = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number   = $request->other_phone_number;
 		$primary->currency             = $request->currency;
 		$primary->payment_terms        = $request->payment_terms;
 		$primary->portal               = $request->portal;
		$primary->facebook             = $request->facebook;
		$primary->twitter              = $request->twitter;
		$primary->linkedin             = $request->linkedin;
		$primary->skypeID              = $request->skypeID;
 		$primary->website              = $request->website;
 		$primary->remarks              = $request->remarks;
 		$primary->designation          = $request->designation;
 		$primary->department           = $request->department;
      $primary->group                = json_encode($request->groups);
		$primary->business_code        = Auth::user()->business_code;
		$primary->created_by           = Auth::user()->user_code;
 		$primary->save();


 		//address
 		$address = new address;
		$address->customer_code = $code;
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

	   Session::flash('success','Contact has been successfully Added');

	   return redirect()->route('pos.contact.index');
 	}

 	public function edit($code){
 		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
 		$contact = customers::where('fn_customers.customer_code',$code)
						->join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
						->where('fn_customers.business_code',Auth::user()->business_code)
						->select('*','fn_customers.customer_code as customer_code')
						->first();

 		$contact_person = contact_persons::where('customer_code',$code)->get();

		//category
      $groups = groups::where('business_code',Auth::user()->business_code)->pluck('name','name');

      $connectedGroup = json_decode($contact->group);

 		return view('app.pos.contacts.edit', compact('country','contact','groups','connectedGroup'));
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
			}else{
            $primary->email = $request->email;
         }
		}

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$primary->customer_code.'/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = customers::where('customer_code','=',$code)->where('image','!=', "")->count();

         if ($check > 0){
				$oldimagename = customers::where('customer_code','=',$code)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
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
 		$primary->salutation = $request->salutation;
		$primary->customer_name = $request->customer_name;
 		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number   = $request->other_phone_number;
 		$primary->currency             = $request->currency;
 		$primary->payment_terms        = $request->payment_terms;
 		$primary->portal               = $request->portal;
 		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
      $primary->group                = json_encode($request->groups);
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


 		Session::flash('success','Contact has been successfully updated');

	   return redirect()->back();
 	}

 	public function show($code){
		$customer_code = $code;
 		$count = 1;
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('business','business.id','=','fn_customers.business_code')
					->join('currency','currency.id','=','business.base_currency')
					->where('fn_customers.customer_code',$code)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as cid')
					->first();

		//contacts
		$contacts = contact_persons::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->get();

		//project
		$projectCount = project::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->count();
		$projects = project::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
		$paymentsCount = invoice_payments::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->count();
		$outstanding = invoices::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->sum('balance');
		$totalIncome = invoices::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->sum('paid');
		$invoiceCount = invoices::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->count();

		//quotes
		$quotesCount = quotes::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->count();
		$quotes = quotes::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//creditnote
		$unusedCredits = creditnote::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->sum('balance');
		$creditnotes = creditnote::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//sms count
		$smsCount = sms::where('customer_code',$customer_code)->where('business_code',Auth::user()->business_code)->count();

		//mail count
		$mailCount = emails::where('clientID',$customer_code)->where('business_code',Auth::user()->business_code)->count();

		//task count
		$taskCount = tasks::join('project','project.id','=','project_tasks.projectID')
								  ->where('project.customer_code',$customer_code)
								  ->where('project.business_code',Auth::user()->business_code)
								  ->count();

		//subscription
		$subscriptionsCount = subscriptions::where('business_code',Auth::user()->business_code)
									->where('customer',$customer_code)
									->count();

		//assets
		$assetsCount = assets::where('business_code',Auth::user()->business_code)->where('customer',$customer_code)->where('category','Asset')->count();

		//meeting
		$eventsCount = events::where('business_code', Auth::user()->business_code)->where('customer_code',$customer_code)->count();

		//notes
		$countNotes = notes::where('business_code',Auth::user()->business_code)->where('customer_code',$customer_code)->count();

		//documents
		$folder = 'customer/'.$client->customer_code.'/documents';
		$documentsCount = documents::where('fileID',$customer_code)
									->where('business_code',Auth::user()->business_code)
									->where('folder',$folder)
									->where('section','customer')
									->count();

		//documents
		$salesOrderCount = salesorders::where('business_code',Auth::user()->business_code)->where('customer_code',$customer_code)->count();

		//comments
		$commentCount = comments::where('business_code',Auth::user()->business_code)->where('customer_code',$customer_code)->count();

		//subscription
		$subscriptions = subscriptions::join('business','business.id','=','subscriptions.business_code')
									->join('subscription_settings','subscription_settings.business_code','=','business.id')
									->join('product_information','product_information.id','=','subscriptions.plan')
									->join('product_price','product_price.productID','=','product_information.id')
									->join('status','status.id','=','subscriptions.status')
									->where('subscriptions.business_code',Auth::user()->business_code)
									->where('subscriptions.customer',$customer_code)
									->orderby('subscriptions.id','desc')
									->select('*','status.name as statusName','subscriptions.id as subscriptionID')
									->get();

		$count = 1;

      return view('app.pos.contacts.view', compact('client','customer_code','totalIncome','unusedCredits','contacts','outstanding','projectCount','invoiceCount','quotesCount','paymentsCount','smsCount','mailCount','taskCount','subscriptionsCount','assetsCount','eventsCount','countNotes','documentsCount','salesOrderCount','commentCount','invoices','quotes','creditnotes','projects','subscriptions','count'));
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

	public function comment_delete($code){

		$delete = comments::where('id',$code)->where('business_code',Auth::user()->business_code)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
	}

 	public function delete_contact_person($code){

 		$contact_person = contact_persons::where('id',$code)->first();

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
			$check = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->select('image','customer_code')->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			contact_persons::where('customer_code',$code)->delete();

			//delete contact
			customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->delete();

			//delete address
			address::where('customer_code',$code)->delete();

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('pos.contact.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
