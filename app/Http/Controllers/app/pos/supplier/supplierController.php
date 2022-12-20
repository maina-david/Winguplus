<?php
namespace App\Http\Controllers\app\pos\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\expense\expense;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\comments;
use App\Models\finance\suppliers\supplier_address;
use App\Models\finance\suppliers\category;
use App\Models\finance\suppliers\suppliers_categories;
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

	public function index(){
		$suppliers = suppliers::join('wp_business','wp_business.business_code','=','fn_suppliers.business_code')
                           ->where('fn_suppliers.business_code',Auth::user()->business_code)
                           ->select('*','fn_suppliers.email as supplier_email','fn_suppliers.created_at as date_added')
                           ->OrderBy('fn_suppliers.id','DESC')
                           ->get();

		return view('app.pos.suppliers.index', compact('suppliers'));
	}

   /**
   * Create supplier
   *
   * */
	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
		$groups = category::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id')->prepend('Choose category','');
		return view('app.pos.suppliers.create', compact('country','groups'));
	}


   /**
   * Store supplier
   *
   * */
	public function store(Request $request){
		$this->validate($request, [
			'supplier_name' => 'required',
         'primary_phone_number' => 'required',
		]);

		$code = Helper::generateRandomString(30);
		$supplier = new suppliers;
		$supplier->supplier_code        = $code;
      // $supplier->contract_type        = $request->contract_type;
		$supplier->salutation           = $request->salutation;
		$supplier->supplier_name        = $request->supplier_name;
		$supplier->email                = $request->email;
		$supplier->email_cc             = $request->email_cc;
		$supplier->primary_phone_number = $request->primary_phone_number;
		$supplier->other_phone_number   = $request->other_phone_number;
		$supplier->currency             = $request->currency;
		$supplier->payment_terms        = $request->payment_terms;
		$supplier->portal               = $request->portal;
		$supplier->facebook             = $request->facebook;
		$supplier->twitter              = $request->twitter;
		$supplier->website              = $request->website;
		$supplier->remarks              = $request->remarks;
		$supplier->position             = $request->position;
		$supplier->department           = $request->department;
      $supplier->category             = json_encode($request->category);
		$supplier->created_by           = Auth::user()->user_code;
      $supplier->business_code        = Auth::user()->business_code;
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Auth::user()->business_code.'/suppliers/'.$code.'/images/';

			if(!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(30). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$supplier->image = $fileName;
		}
		$supplier->save();

		//address
		$address = new supplier_address;
      $address->supplier_code       = $code;
		$address->bill_street         = $request->bill_street;
		$address->bill_city           = $request->bill_city;
		$address->bill_state          = $request->bill_state;
		$address->bill_zip_code       = $request->bill_zip_code;
		$address->bill_country        = $request->bill_country;
		$address->bill_fax            = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
      $address->business_code       = Auth::user()->business_code;
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

		Session::flash('success','Supplier has been successfully Added');

		return redirect()->route('pos.supplier.index');
	}

	public function edit($code){
		$country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose Country','');
		$supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
									->where('fn_suppliers.business_code',Auth::user()->business_code)
									->where('fn_suppliers.supplier_code',$code)
									->first();

		$persons = contact_persons::where('supplier_code',$code)->get();

		//category
      $category = category::where('business_code',Auth::user()->business_code)->pluck('name','name');

      $connectedCategory = json_decode($supplier->category);

		return view('app.pos.suppliers.edit', compact('category','connectedCategory','supplier','country','persons'));
	}

   /**
   * Update supplier
   * @param string code required
   * */
	public function update(Request $request, $code){
		$this->validate($request, [
         'supplier_name' => 'required',
			'primary_phone_number' => 'required',
		]);

		$primary = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$primary->referral             = $request->referral;
      //$primary->contract_type        = $request->contract_type;
		$primary->salutation           = $request->salutation;
		$primary->supplier_name        = $request->supplier_name;
		$primary->email                = $request->email;
		$primary->email_cc             = $request->email_cc;
		$primary->primary_phone_number = $request->primary_phone_number;
		$primary->other_phone_number   = $request->other_phone_number;
		$primary->currency             = $request->currency;
		$primary->payment_terms        = $request->payment_terms;
		$primary->portal               = $request->portal;
		$primary->facebook             = $request->facebook;
		$primary->twitter              = $request->twitter;
		$primary->website              = $request->website;
		$primary->remarks              = $request->remarks;
		$primary->position             = $request->position;
      $primary->referral             = $request->referral;
		$primary->department           = $request->department;
      $primary->category             = json_encode($request->category);
		$primary->updated_by           = Auth::user()->user_code;

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Auth::user()->business_code.'/suppliers/'.$code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			if($primary->image){
				$delete = $path.$primary->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(30). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$primary->image = $fileName;
		}
		$primary->save();

		//address
		$address = supplier_address::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->first();
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

	public function show($id){
		$clientID = $id;
		$count = 1;
		$client = suppliers::join('supplier_address','supplier_address.supplierID','=','fn_suppliers.id')->where('fn_suppliers.id',$id)->select('*','fn_suppliers.id as cid')->first();

		//comments
		$comments = comments::where('clientID',$id)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('client_id',$clientID)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

		return view('app.pos.suppliers.view', compact('client','clientID','comments','invoices'));
	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
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

	//delete permanently
	public function delete($code){

		//check if linked to lpo
		$lpo = lpo::where('supplier',$code)->where('business_code',Auth::user()->business_code)->count();

		//check if linked to products
		$products = product_information::where('supplier',$code)->where('business_code',Auth::user()->business_code)->count();

		//check if linked to products
		$expense = expense::where('supplier',$code)->where('business_code',Auth::user()->business_code)->count();

		if($lpo == 0 && $products == 0 && $expense == 0){

			$supplier = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->first();

			//delete image
			$check = suppliers::where('supplier_code',$code)->where('image','!=', "")->where('business_code',Auth::user()->business_code)->count();

			if ($check > 0){
				$oldImageName = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->select('image')->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/suppliers/'.$code.'/images/';

				$delete = $path.$oldImageName->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			contact_persons::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->delete();

			//delete address
			supplier_address::where('supplier_code',$code)->delete();

         $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> '.$supplier->supplier_name.' suppliers information';
         $module       = 'Point Of Sale';
         $section      = 'Supplier';
         $action       = 'Delete';
         $activityCode = $code;

         //delete contact
			$supplier->delete();

         Wingu::activity($activity,$module,$section,$action,$activityCode);

			Session::flash('success','supplier was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this supplier. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}

}
