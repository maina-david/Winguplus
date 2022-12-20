<?php
namespace App\Http\Controllers\app\salesflow\customer;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\groups;
use App\Http\Controllers\Controller;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\customer\address;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\jobs\jobs;
use Illuminate\Http\Request;
use App\Models\wingu\country;
use File;
use Helper;
use Session;
use Auth;
use Wingu;

class customerController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		return view('app.salesflow.customers.index');
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
		$groups = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','name');

		return view('app.salesflow.customers.create', compact('country','groups'));
	}

	public function store(Request $request){

		$this->validate($request, [
			'customer_name' => 'required',
		]);

      $customer = new customers;
      $customerCode = Helper::generateRandomString(10);
      $customer->contact_type = $request->contact_type;
      $customer->referral = $request->referral;
      $customer->customer_code = $customerCode;
      $customer->salutation = $request->salutation;
      $customer->email = $request->email;
      $customer->customer_name = $request->customer_name;
      $customer->email_cc = $request->email_cc;
      $customer->primary_phone_number = $request->primary_phone_number;
      $customer->other_phone_number = $request->other_phone_number;
      $customer->category = json_encode($request->category);
      $customer->website = $request->website;
      $customer->remarks = $request->remarks;

      $customer->vat_number = $request->vat_number;
      $customer->delivery_time = $request->delivery_time;
      $customer->route = $request->route;
      $customer->zone = $request->zone;
      $customer->region = $request->region;
      $customer->territory = $request->territory;
      $customer->country = $request->country;
      $customer->location = $request->location;
      $customer->latitude = $request->latitude;
      $customer->longitude = $request->longitude;

		$customer->business_code = Auth::user()->business_code;
		$customer->created_by = Auth::user()->user_code;
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

         $customer->image = $fileName;
      }
 		$customer->save();

      //address
 		$address = new address;
      $address->customer_code = $customerCode;
      $address->business_code = Auth::user()->business_code;
      $address->save();

      $contacts = count(collect($request->cn_names));

      //contact persons
		if($contacts > 0){
         if(isset($_POST['cn_names'])){
            for($i=0; $i < count($request->cn_names); $i++ ) {

               $contact_persons = new contact_persons();

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
      $module = 'Sales Flow';
      $section = 'Customer';
      $action = 'Create';
      $activityID = $customerCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      Session::flash('success','Customer has been successfully Added');


	   return redirect()->route('salesflow.customer.index');
 	}

 	public function edit($code){
      $country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
		$groups = groups::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','name');
 		$customer = customers::where('customer_code',$code)->first();
		$persons = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

 		return view('app.salesflow.customers.edit', compact('customer','country','groups','persons'));
 	}

 	public function update(Request $request, $code){
		$this->validate($request, [
			'customer_name' => 'required'
		]);

		$customer = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $customer->contact_type = $request->contact_type;
      $customer->referral = $request->referral;
      $customer->salutation = $request->salutation;
      $customer->email = $request->email;
      $customer->customer_name = $request->customer_name;
      $customer->email_cc = $request->email_cc;
      $customer->primary_phone_number = $request->primary_phone_number;
      $customer->other_phone_number = $request->other_phone_number;
      $customer->category = json_encode($request->category);
      $customer->website = $request->website;
      $customer->remarks = $request->remarks;
      $customer->vat_number = $request->vat_number;
      $customer->delivery_time = $request->delivery_time;
      $customer->route = $request->route;
      $customer->zone = $request->zone;
      $customer->region = $request->region;
      $customer->territory = $request->territory;
      $customer->country = $request->country;
      $customer->location = $request->location;
      $customer->latitude = $request->latitude;
      $customer->longitude = $request->longitude;
		$customer->business_code = Auth::user()->business_code;
		$customer->created_by = Auth::user()->user_code;
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$code.'/';

			if(!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         if($customer->image != ""){
				$delete = $path.$customer->image;
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

         $customer->image = $fileName;
      }
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
 		$customer->save();

      //recorded activity
      $activities = '<b>'.Auth::user()->name.'</b> Has <b>updated</b><i> '.$request->customer_name.'</i> details';
      $module = 'Sales Flow';
      $section = 'Customer';
      $action = 'Create';
      $activityID = $code;

      Wingu::activity($activities,$section,$action,$activityID,$module);

 		Session::flash('success','Customer updated successfully');

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
			$check = customers::where('customer_code','=',$code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('customer_code','=',$code)->select('image','customer_code')->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
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
			customers::where('customer_code',$code)->delete();

			//delete address
			address::where('customer_code',$code)->delete();

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('salesflow.customer.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
