<?php

namespace App\Http\Controllers\app\finance\lpo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\lpo\lpo;
use App\Models\finance\lpo\lpo_products;
use App\Models\finance\lpo\lpo_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\finance\expense\expense;
use App\Models\wingu\status;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\crm\emails;
use App\Mail\sendLpo;
use App\Models\finance\expense\expense_category;
use Session;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;
use DB;

class lpoController extends Controller
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
		$lpos	= lpo::join('fn_suppliers','fn_suppliers.supplier_code','=','fn_purchaseorders.supplier')
							->join('fn_purchaseorder_settings','fn_purchaseorder_settings.business_code','=','fn_purchaseorders.business_code')
							->join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
							->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
							->where('fn_purchaseorders.business_code',Auth::user()->business_code)
							->orderby('fn_purchaseorders.id','desc')
							->select('*','fn_purchaseorders.po_code as lpo_code','wp_status.name as statusName','fn_purchaseorders.title as lpo_title')
							->get();

			return view('app.finance.purchaseorders.index', compact('lpos'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		$check = settings::where('business_code',Auth::user()->business_code)->count();
			if($check != 1){
			Finance::lpo_setting_setup();
		}

		$taxes = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

		$suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

		$products = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
												->where('fn_product_information.business_code',Auth::user()->business_code)
												->where('fn_product_information.type','product')
												->where('default_inventory','Yes')
												->orWhere('fn_product_information.type','service')
												->OrderBy('fn_product_information.id','DESC')
												->select('*','fn_product_information.id as productID')
												->get();
      $status	= status::all();

      //$expenseCategories = expense_category::where('business_code',Auth::user()->business_code)->pluck('')

		return view('app.finance.purchaseorders.create', compact('suppliers','products','status','taxes'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, array(
			'supplier'	=> 'required',
			'lpo_number'	=> 'required',
			'lpo_date'	=> 'required',
			'lpo_due'	=> 'required',
		));

		//store purchase order
		$code = Helper::generateRandomString(30);

		$store					     = new lpo;
		$store->created_by		  = Auth::user()->user_code;
		$store->supplier	 	     = $request->supplier;
		$store->lpo_number        = $request->lpo_number;
		$store->reference_number  = $request->reference_number;
		$store->title				  = $request->title;
		$store->expense_category  = expense_category::where('business_code',Auth::user()->business_code)
                                                ->where('id',$request->expense_category)
                                                ->first()
                                                ->category_code;
		$store->lpo_date	        = $request->lpo_date;
		$store->lpo_due	        = $request->lpo_due;
		$store->customer_note	  = $request->customer_note;
		$store->terms				  = $request->terms;
		$store->status		        = 10;
		$store->po_code           = $code;
		$store->business_code 	  = Auth::user()->business_code;
		$store->save();

		//products
		$products				     = $request->product_code;

		foreach ($products as $k => $v){

			$amount = $request->price[$k] * $request->qty[$k];

			$rate = $request->tax[$k]/100;

			$tax_value = $amount * $rate;
			$totalAmount = $amount + $tax_value;

			$product 					= new lpo_products;
			$product->lpo_code      = $code;
			$product->product_code  = $request->product_code[$k];
			$product->quantity		= $request->qty[$k];
			$product->tax_rate	   = $request->tax[$k];
			$product->tax_value		= $tax_value;
			$product->total         = $totalAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->business_code = Auth::user()->business_code;
			$product->save();
		}

		//get invoice products
		$lpoProducts = lpo_products::where('lpo_code',$code)
								->select(DB::raw('SUM(total) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as tax_value'))
								->first();

		//update invoice
		$lpo = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$lpo->total		   = $lpoProducts->total;
		$lpo->sub_total	= $lpoProducts->sub_total;
		$lpo->tax_value	= $lpoProducts->tax_value;
		$lpo->save();

		//lpo setting
		$settings         = settings::where('business_code',Auth::user()->business_code)->first();
		$lpoNumber 	      = $settings->number + 1;
		$settings->number	= $lpoNumber;
		$settings->save();

		//recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Added</b> a new purchase order #'.$request->title.'</a>';
      $module       = 'Finance';
		$section      = 'Purchase Order';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','Purchase Order has been successfully created');

		return redirect()->route('finance.lpo.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {

		$lpo = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();

		$suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

		$taxes = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

      $poProducts = lpo_products::join('fn_product_information','fn_product_information.product_code','=','fn_purchaseorder_products.product_code')
                                 ->where('fn_product_information.business_code',Auth::user()->business_code)
                                 ->where('lpo_code',$code)
                                 ->get();

		$products = product_information::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();


      $expenseCategories = expense_category::where('business_code',Auth::user()->business_code)->pluck('name','category_code')->prepend('choose','');

		if($lpo->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $lpo->sub_total * ($lpo->tax / 100);
		}

		return view('app.finance.purchaseorders.edit', compact('suppliers','taxed','lpo','products','products','taxes','poProducts','expenseCategories'));
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
      $this->validate($request, array(
			'supplier'	=> 'required',
			'lpo_number'	=> 'required',
			'lpo_date'	=> 'required',
			'lpo_due'	=> 'required',
		));

		$update					 	  = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$update->updated_by		  = Auth::user()->user_code;
		$update->supplier	 	     = $request->supplier;
		$update->lpo_number       = $request->lpo_number;
		$update->expense_category = $request->expense_category;
		$update->reference_number = $request->reference_number;
		$update->title				  = $request->title;
		$update->lpo_date	        = $request->lpo_date;
		$update->lpo_due	        = $request->lpo_due;
		$update->customer_note	  = $request->customer_note;
		$update->terms				  = $request->terms;
		$update->business_code 	  = Auth::user()->business_code;
		$update->save();


		//delete product
		lpo_products::where('lpo_code', $code)->where('business_code',Auth::user()->business_code)->delete();

		//products
		$products				     = $request->product_code;

		foreach ($products as $k => $v){

			$amount = $request->price[$k] * $request->qty[$k];

			$rate = $request->tax[$k]/100;

			$tax_value = $amount * $rate;
			$totalAmount = $amount + $tax_value;

			$product 					= new lpo_products;
			$product->lpo_code      = $code;
			$product->product_code  = $request->product_code[$k];
			$product->quantity		= $request->qty[$k];
			$product->tax_rate	   = $request->tax[$k];
			$product->tax_value		= $tax_value;
			$product->total         = $totalAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->business_code = Auth::user()->business_code;
			$product->save();
		}

		//get invoice products
		$lpoProducts = lpo_products::where('lpo_code',$code)
								->select(DB::raw('SUM(total) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as tax_value'))
								->first();

		//update invoice
		$lpo = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$lpo->total		   = $lpoProducts->total;
		$lpo->sub_total	= $lpoProducts->sub_total;
		$lpo->tax_value	= $lpoProducts->tax_value;
		$lpo->save();


		//recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>update</b> purchase order '.$request->title.' #'.$update->lpo_prefix.$update->lpo_number.'</a>';
		$module       = 'Finance';
		$section      = 'Purchase Order';
      $action       = 'Edit';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','Purchase Order has been successfully created');

		return redirect()->back();
	}

	/**
   * show lpo
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($code){
		$lpo = lpo::join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
						->join('fn_purchaseorder_settings','fn_purchaseorder_settings.business_code','=','wp_business.business_code')
						->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
						->where('fn_purchaseorders.po_code',$code)
						->where('fn_purchaseorders.business_code',Auth::user()->business_code)
						->select('*','fn_purchaseorders.po_code as lpo_code','wp_business.name as businessName','wp_business.business_code as business_code','wp_status.name as status_name')
						->first();

      $products = lpo_products::join('fn_product_information','fn_product_information.product_code','=','fn_purchaseorder_products.product_code')
                  ->where('fn_product_information.business_code',Auth::user()->business_code)
                  ->where('lpo_code',$code)
                  ->get();

		$supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
						->where('fn_suppliers.business_code',Auth::user()->business_code)
						->where('fn_suppliers.supplier_code',$lpo->supplier)
						->select('*','fn_suppliers.supplier_code as supplier')
						->first();

		$files = docs::where('file_code',$code)->where('folder','Purchase orders')->where('business_code',Auth::user()->business_code)->get();

		$persons = contact_persons::where('supplier_code',$supplier->supplier)->where('business_code',Auth::user()->business_code)->get();

		$template = Wingu::template()->template_name;

		return view('app.finance.purchaseorders.show', compact('supplier','lpo','products','files','persons','template'));
	}



	/**
	* print lpo
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($code){

		$details = lpo::join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
                     ->join('fn_purchaseorder_settings','fn_purchaseorder_settings.business_code','=','wp_business.business_code')
                     ->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
                     ->where('fn_purchaseorders.po_code',$code)
                     ->where('fn_purchaseorders.business_code',Auth::user()->business_code)
                     ->select('*','fn_purchaseorders.po_code as lpo_code','wp_business.name as businessName','wp_business.business_code as business_code','wp_status.name as status_name')
                     ->first();

		$supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
						->where('fn_suppliers.business_code',Auth::user()->business_code)
						->where('fn_suppliers.supplier_code',$details->supplier)
						->select('*','fn_suppliers.supplier_code as supplier')
						->first();

      $products = lpo_products::join('fn_product_information','fn_product_information.product_code','=','fn_purchaseorder_products.product_code')
                  ->where('fn_product_information.business_code',Auth::user()->business_code)
                  ->where('lpo_code',$code)
                  ->get();

		$pdf = PDF::loadView('templates/'.Wingu::template()->template_name.'/lpo/lpo', compact('products','details','supplier'));

		return $pdf->stream(Finance::lpo()->prefix.$details->lpo_number.'.pdf');
	}

	/**
	* attachment lpo
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$lpo = lpo::where('id',$request->lpo_code)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/lpo/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
      $file = $request->file('file');
      $size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString(30).$file->getClientOriginalName();

      //move file
		$file->move($directory, $filename);

      //save the upload details into the database
      $upload = new docs;

      $upload->fileID      = $request->lpo_code;
		$upload->folder 	   = 'Finance';
		$upload->section 	   = 'Purchase orders';
		$upload->name 		   = Finance::lpo()->prefix.$lpo->lpo_number;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->user_code;
		$upload->business_code  = Auth::user()->business_code;
      $upload->save();
	}


	/**
	* update file status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/

	public function update_file_status($status,$file){
		$file = docs::find($file);
		$file->status = $status;
		$file->save();
	}


	/**
	* 	delete file
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_file($id){

		$file = docs::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/lpo/';

		$delete = $directory.$file->file_name;
		if (File::exists($delete)) {
			unlink($delete);
		}

		$file->delete();

		Session::flash('success','File Deleted');

		return redirect()->back();
	}


   /**
	* 	show mailing section
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($code){
		$details = lpo::join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
						->join('fn_purchaseorder_settings','fn_purchaseorder_settings.business_code','=','wp_business.business_code')
						->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
						->where('fn_purchaseorders.po_code',$code)
						->where('fn_purchaseorders.business_code',Auth::user()->business_code)
						->select('*','fn_purchaseorders.po_code as lpoCode','wp_business.name as business_name','fn_purchaseorders.status as status','wp_status.name as status_name')
						->first();

      $supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
						->where('fn_suppliers.business_code',Auth::user()->business_code)
						->where('fn_suppliers.supplier_code',$details->supplier)
						->select('*','fn_suppliers.supplier_code as supplierCode')
						->first();

      $products = lpo_products::where('lpo_code',$code)->where('business_code',Auth::user()->business_code)->get();

		$files = docs::where('file_code',$code)
                  ->where('business_code',Auth::user()->business_code)
                  ->get();

      $contacts = contact_persons::where('supplier_code',$details->supplier)->where('business_code',Auth::user()->business_code)->get();

		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/purchase-order/';

      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/lpo/lpo', compact('products','details','supplier'));

      $pdf->save($directory.$details->prefix.$details->lpo_number.'.pdf');

		return view('app.finance.purchaseorders.mail', compact('details','files','contacts','supplier'));
	}

	/**
	* 	send lpo via email
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function send(Request $request){
		$this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
		]);

		//lpo information
		$lpo = lpo::where('po_code',$request->lpoCode)->where('business_code',Auth::user()->business_code)->first();

		//client info
		$supplier = suppliers::where('fn_suppliers.supplier_code',$lpo->supplier)
							->where('business_code',Auth::user()->business_code)
							->first();

		$checkatt = count(collect($request->attach_files));
		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('folder','Finance')->where('file_code',$lpo->po_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($filechange as $fc) {
				$null = docs::where('id',$fc->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {
				$sendfile = docs::where('id',$request->attach_files[$i])->where('business_code',Auth::user()->business_code)->first();
				$sendfile->attach = "Yes";
				$sendfile->save();
			}
		}else{
			$chage = docs::where('folder','lpo')->where('file_code',$lpo->po_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
      $mailCode = Helper::generateRandomString(20);


      $message = $request->message.'<br><img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1"><img src="'.url('/').'/track/purchaseorder/'.$request->lpoCode.'" width="1" height="1">';

		$emails = new Email;
      $emails->mail_code           = $mailCode;
		$emails->message             = $message;
      $emails->business_code       = Auth::user()->business_code;
		$emails->supplier            = $supplier->supplier_code;
      $emails->purchase_order_code = $request->lpoCode;
		$emails->subject             = $request->subject;
		$emails->mail_from           = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = json_encode($request->get('files'));
		}
		$emails->category  = 'Purchase order Document';
		$emails->status    = 'Sent';
		$emails->ip 		 =  request()->ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'Purcase Order';
		$emails->mail_to   = $request->send_to;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
      $emails->created_by   = Auth::user()->user_code;
		$emails->save();

		//update lpo
		$lpo->status = 6;
		$lpo->save();

		//send email
		$subject = $request->subject;
		$content = $request->message;
		$from = $request->email_from;
		$to = $request->send_to;
		$mailCode = $emails->mail_code;
		$doctype = 'LPO';
		$docID = $lpo->po_code; //lpo ID

		$attachment = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/purchase-order/'.$lpo->lpo_prefix.$lpo->lpo_number.'.pdf';

		Mail::to($to)->send(new sendLpo($content,$subject,$from,$mailCode,$docID,$doctype,$attachment));

      //record activity
		$activity     = 'Purchase order #'.$lpo->lpo_prefix.$lpo->lpo_number.' has been sent to the supplier by '.Auth::user()->name;
		$section      = 'Purchase order';
      $module       = 'Finance';
		$action       = 'sent';
		$activityCode = $mailCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','lpo Sent to supplier successfully');

		return redirect()->back();

	}

	/**
	* 	change lpo status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($lpo_code,$status){
		$lpo = lpo::where('po_code',$lpo_code)->where('business_code',Auth::user()->business_code)->first();
		$lpo->status = $status;
		$lpo->save();

		//recorord activity
		$activity = 'Purchase order #'.Finance::lpo()->prefix.$lpo->lpo_number.' status has been updated by '.Auth::user()->name;
		$section = 'Purchase order';
      $module = 'Finance';
		$action = 'update';
		$activityCode = $lpo_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','lpo status successfully changed');
		return redirect()->back();
	}

	/**
	* 	change lpo status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function convert_to_invoice($lpo_code){
		$lpo = lpo::find($lpo_code);

		//create invoice
		$invoice = new lpo;
		$invoice->admin_id = $lpo->admin_id;
		$invoice->vendorID = $lpo->vendorID;
		$invoice->currencyID = $lpo->currencyID;
		$invoice->invoice_number = Finance::invoice_settings()->invoice_number + 1;
		$invoice->sub_total = $lpo->sub_total;
		$invoice->total = $lpo->total;
		$invoice->discount = $lpo->discount;
		$invoice->discount_type = $lpo->discount_type;
		$invoice->invoice_date = $lpo->lpo_date;
		$invoice->invoice_due = $lpo->lpo_due;
		$invoice->tax = $lpo->tax;
		$invoice->status = 2;
		$invoice->business_code = $lpo->business_code;
		$invoice->invoice_type = 'Random';
		$invoice->save();


		//create products
		$estprod = lpo_products::where('lpo_code',$lpo_code)->get();
		foreach($estprod as $product){
			$invoprod = new lpo_products;
			$invoprod->invoiceID = $invoice->id;
			$invoprod->product_name = $product->product_name;
			$invoprod->quantity = $product->quantity;
			$invoprod->price = $product->price;
			$invoprod->save();
		}

		//link lpo to invoice
		$lpo->invoice_link = $invoice->id;
		$lpo->status = 13;
		$lpo->save();

		//update invoice number settings
		$invoice_settings = settings::where('business_code',Auth::user()->business_code)->first();
		$invoice_settings->invoice_number = $invoice_settings->invoice_number + 1;
		$invoice_settings->save();


		//record activity
		$activities = 'Purchase orders #'.Finance::lpo()->prefix.$lpo->lpo_number.' had been converted to a bill by '.Auth::user()->name;
		$section = 'Purchase orders';
		$type = 'Convert';
		$adminID = Auth::user()->user_code;
		$activityID = $lpo_code;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','lpo has been successfully converted');

		return redirect()->back();
	}

	/**
	* 	delete lpo permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_lpo($lpo_code){
		$lpo = lpo::where('po_code',$lpo_code)->where('business_code',Auth::user()->business_code)->first();

		if(!$lpo->expense_code){
			//delete all files linked to the lpo
			$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/lpo/';

			$check_files = docs::where('file_code',$lpo_code)->count();

			if($check_files > 0){
				$files = docs::where('file_code',$lpo_code)->where('business_code',Auth::user()->business_code)->get();
				foreach($files as $file){
					$doc = docs::where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete lpo products
			lpo_products::where('lpo_code',$lpo_code)->delete();

			//delete lpo plus attachment
			if($lpo->attachment != ""){
				$delete = $directory.$lpo->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

         //recorded activity
         $activity     = 'Purchase order #'.$lpo->lpo_prefix.$lpo->lpo_number.' had been deleted by '.Auth::user()->name;
         $module       = 'Finance';
         $section      = 'Expense';
         $action       = 'Create';
         $activityCode = $lpo_code;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

         $lpo->delete();

			Session::flash('success','lpo has been successfully deleted');

			return redirect()->route('finance.lpo.index');
		}else{
			Session::flash('warning','This purchase order has been linked to an expense, you will have to unlink it first then delete the purchase order');

			return redirect()->back();
		}

	}

	public function convert($code){
		$lpo = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $code = Helper::generateRandomString(20);
		$expense = new expense;
      $expense->expense_code      =  $code;
      $expense->expense_date      =  date('Y-m-d');
      $expense->expense_name      =  $lpo->title;
      $expense->category          =  $lpo->expense_category;
      $expense->amount            =  $lpo->total ;
		$expense->supplier          =  $lpo->supplier;
		$expense->status            =  2;
      $expense->expense_type      =  'expense';
      $expense->created_by        =  Auth::user()->user_code;
      $expense->business_code     =  Auth::user()->business_code;
		$expense->save();

		//update po
		$lpo->expense_code  = $code;
		$lpo->save();

      //recorded activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Added</b> an new expense '.$lpo->title.'</a>';
      $module       = 'Finance';
      $section      = 'Expense';
      $action       = 'Create';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','expense added successfully');

		return redirect()->route('finance.expense.index');
	}
}
