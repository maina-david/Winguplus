<?php
namespace App\Http\Controllers\app\finance\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\expense\expense;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\comments;
use App\Models\finance\suppliers\supplier_address;
use App\Models\finance\suppliers\category;
use App\Models\wingu\country;
use App\Models\finance\lpo\lpo;
use App\Models\finance\invoice\invoices;
use File;
use Helper;
use Session;
use Wingu;
use Auth;

class supplierController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

   //supplier index
	public function index(){
		return view('app.finance.suppliers.index');
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = category::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id');
		return view('app.finance.suppliers.create', compact('country','groups'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'email' => 'required',
			'primary_phone_number' => 'required',
		]);

		$supplierCode = Helper::generateRandomString(20);
		$supplier = new suppliers;
      $supplier->contact_type = $request->contact_type;
		$supplier->referral = $request->referral;
		$supplier->salutation = $request->salutation;
		$supplier->email = $request->email;
		$supplier->supplier_name = $request->supplier_name;
		$supplier->email_cc = $request->email_cc;
		$supplier->primary_phone_number = $request->primary_phone_number;
		$supplier->other_phone_number = $request->other_phone_number;
		$supplier->currency = $request->currency;
		$supplier->payment_terms = $request->payment_terms;
		$supplier->portal = $request->portal;
		$supplier->supplier_code = $supplierCode;
		$supplier->facebook = $request->facebook;
		$supplier->twitter = $request->twitter;
		$supplier->website = $request->website;
		$supplier->remarks = $request->remarks;
		$supplier->position = $request->position;
      $supplier->category = json_encode($request->category);
		$supplier->department = $request->department;
      $supplier->bank_name = $request->bank_name;
      $supplier->bank_branch = $request->bank_branch;
      $supplier->bank_account = $request->bank_account;
      $supplier->mpesa_business_name = $request->mpesa_business_name;
      $supplier->mpesa_pay_bill_number = $request->mpesa_pay_bill_number;
      $supplier->mpesa_account_number = $request->mpesa_account_number;
      $supplier->business_code = Auth::user()->business_code;
		$supplier->created_by = Auth::user()->user_code;
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/suppliers/'.$supplierCode.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$supplier->image = $fileName;
		}
		$supplier->save();


		//address
		$address = new supplier_address;
		$address->supplier_code = $supplierCode;;
		$address->bill_street = $request->bill_street;
		$address->bill_city = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
		$address->business_code = Auth::user()->business_code;
		$address->save();

		$contacts = count(collect($request->cn_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->supplier_code = $supplierCode;;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->position = $request->cn_desgination[$i];
					$contact_persons->business_code = Auth::user()->business_code;
					$contact_persons->save();
				}
			}
		}

		Session::flash('success','Supplier has been successfully Added');

		return redirect()->route('finance.supplier.index');
	}

	public function edit($code){
		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');

		$supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
						->where('fn_suppliers.business_code',Auth::user()->business_code)
						->where('fn_suppliers.supplier_code',$code)
						->select('*','fn_suppliers.supplier_code as supplierCode')
						->first();

		$persons = contact_persons::where('supplier_code',$code)->get();


		//category
      $category = category::where('business_code',Auth::user()->business_code)->pluck('name','name');

      //joint category
      $jointCategory = json_decode($supplier->category);

		return view('app.finance.suppliers.edit', compact('category','supplier','country','persons','jointCategory'));
	}

	public function update(Request $request, $code){
		$this->validate($request, [
			'email' => 'required',
			'primary_phone_number' => 'required',
		]);

		$supplier = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$supplier->referral = $request->referral;
      $supplier->contact_type = $request->contact_type;
		$supplier->salutation = $request->salutation;
		$supplier->supplier_name = $request->supplier_name;
		$supplier->email = $request->email;
		$supplier->email_cc = $request->email_cc;
		$supplier->primary_phone_number = $request->primary_phone_number;
		$supplier->other_phone_number = $request->other_phone_number;
		$supplier->currency = $request->currency;
		$supplier->payment_terms = $request->payment_terms;
		$supplier->portal = $request->portal;
		$supplier->facebook = $request->facebook;
		$supplier->twitter = $request->twitter;
		$supplier->website = $request->website;
		$supplier->remarks = $request->remarks;
		$supplier->position = $request->position;
      $supplier->category = json_encode($request->category);
		$supplier->department = $request->department;
		$supplier->updated_by = Auth::user()->user_code;
      $supplier->bank_name = $request->bank_name;
      $supplier->bank_branch = $request->bank_branch;
      $supplier->bank_account = $request->bank_account;
      $supplier->mpesa_business_name = $request->mpesa_business_name;
      $supplier->mpesa_pay_bill_number = $request->mpesa_pay_bill_number;
      $supplier->mpesa_account_number = $request->mpesa_account_number;

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Auth::user()->business_code.'/suppliers/'.$code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			if($supplier->image != ""){
				$delete = $path.$supplier->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$supplier->image = $fileName;
		}
		$supplier->save();

		//address
		$address = supplier_address::where('supplier_code',$code)->first();
		$address->bill_street = $request->bill_street;
		$address->bill_city = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
		$address->save();


		$contacts = count(collect($request->cn_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->supplier_code = $code;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->position = $request->cn_desgination[$i];
					$contact_persons->business_code = Auth::user()->business_code;
					$contact_persons->save();
				}
			}
		}

		Session::flash('success','Supplier has been successfully updated');

		return redirect()->back();
	}

	public function show($code){
		$client = suppliers::join('supplier_address','supplier_address.supplier_code','=','suppliers.id')
                        ->where('suppliers.id',$code)
                        ->select('*','suppliers.id as cid')
                        ->first();

		//comments
		$comments = comments::where('clientID',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('client_id',$clientID)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		return view('app.finance.suppliers.view', compact('client','clientID','comments','invoices'));
	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->user_code;
		$comment->clientID = $request->clientID;
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

		$contact_person = contact_persons::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

		$contact_person->delete();

		Session::flash('success','Contact person deleted');

		return redirect()->back();
	}

	public function update_quick_edit(Request $request){

		$supplier = suppliers::where('id',$id)->first();
		$supplier->company_name = $request->company_name;
		$supplier->salutation = $request->salutation;
		$supplier->first_name = $request->first_name;
		$supplier->last_name = $request->last_name;
		$supplier->contact_display_name = $request->contact_display_name;
		$supplier->email = $request->email;
		$supplier->work_phone = $request->work_phone;
		$supplier->mobile_phone = $request->mobile_phone;
		$supplier->currency = $request->currency;
		$supplier->paymentTerms = $request->payment_terms;
		$supplier->portal = $request->portal;
		$supplier->facebook = $request->facebook;
		$supplier->twitter = $request->twitter;
		$supplier->website = $request->website;
		$supplier->remarks = $request->remarks;
		$supplier->position = $request->position;
		$supplier->department = $request->department;
		$supplier->save();

		return responce()->json($supplier);

		}



		//trash status update

		public function trash($id){

		$contact = suppliers::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
		$contact->trash = 'Yes';
		$contact->save();

		Session::flash('success','Contact successfully moved to trash');

		return redirect()->back();
	}

	//delete permanently
	public function delete($id){

		//check if linked to lpo
		$lpo = lpo::where('supplier_code',$id)->where('business_code',Auth::user()->business_code)->count();

		//check if linked to products
		$products = product_information::where('supplier_code',$id)->where('business_code',Auth::user()->business_code)->count();

		//check if linked to products
		$expense = expense::where('supplier_code',$id)->where('business_code',Auth::user()->business_code)->count();

		if($lpo == 0 && $products == 0 && $expense == 0){

			$supplier = suppliers::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

			//delete image
			$check = suppliers::where('id',$id)->where('image','!=', "")->where('business_code',Auth::user()->business_code)->count();

			if ($check > 0){
				$oldimagename = suppliers::where('id',$id)->where('business_code',Auth::user()->business_code)->select('image')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/suppliers/'.$supplier->supplierCode.'/images/';

				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('supplier_code',$id)->where('business_code',Auth::user()->business_code)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$supplier->delete();

			//delete address
			$address = supplier_address::where('supplier_code',$id)->first();
			$address->delete();

			Session::flash('success','supplier was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this supplier. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}

	public function express_save(Request $request){
      $code  = Helper::generateRandomString(20);
      $suppliers = new suppliers;
      $suppliers->supplier_name = $request->name;
      $suppliers->supplier_code = $code;
      $suppliers->created_by = Auth::user()->user_code;
      $suppliers->business_code = Auth::user()->business_code;
		$suppliers->save();

		$address = new supplier_address;
		$address->supplier_code = $code;
		$address->save();

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Added</b> an new supplier '.$request->name.'</a>';
		$module       = 'Finance';
		$section      = 'Supplier';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);
   }

   public function express_list(Request $request)
   {
      $accounts = suppliers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'supplier_name as text']);
      return ['results' => $accounts];
   }
}
