<?php
namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\lpo\lpo;
use App\Models\finance\lpo\lpo_products;
use App\Models\finance\lpo\lpo_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\wingu\status;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\wingu\Email;
use App\Mail\sendLpo;
use Session;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use DB;
use Mail;

class stockcontrolController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * stock control
    *
    *
   */
   public function index(){
		//check if user is linked to a business and allow access
      $lpos	= lpo::join('fn_suppliers','fn_suppliers.supplier_code','=','fn_purchaseorders.supplier')
                  ->join('fn_purchaseorder_settings','fn_purchaseorder_settings.business_code','=','fn_purchaseorders.business_code')
                  ->join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
                  ->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
                  ->where('type','Stock control')
                  ->where('fn_purchaseorders.business_code',Auth::user()->business_code)
                  ->orderby('fn_purchaseorders.id','desc')
                  ->select('*','fn_purchaseorders.po_code as lpoCode','wp_status.name as statusName')
                  ->get();

		return view('app.finance.products.stock.index', compact('lpos'));
   }

   /**
   * order stock
   */
   public function order(){

      $check = settings::where('business_code',Auth::user()->business_code)->count();
			if($check != 1){
         Finance::lpo_setting_setup();
		}

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
      $products = product_information::where('business_code',Auth::user()->business_code)->where('type','product')->OrderBy('id','DESC')->get();
      $status	= status::all();

      return view('app.finance.products.stock.order', compact('suppliers','products','status'));
   }

   /**
    * store order
    *
   */
   public function store(Request $request)
   {
      $this->validate($request, array(
			'supplier'	=> 'required',
			'lpo_number'	=> 'required',
			'lpo_date'	=> 'required',
			'lpo_due'	=> 'required',
		));

		//store invoice
      $code = Helper::generateRandomString(20);
		$store					    = new lpo;
      $store->po_code          = $code;
		$store->supplier	       = $request->supplier;
      $store->lpo_prefix	    = Finance::lpo()->prefix;
      $store->lpo_number	    = $request->lpo_number;
		$store->reference_number = $request->reference_number;
		$store->total		       = $store->total($request->qty,$request->price);
		$store->sub_total		    = $store->total($request->qty, $request->price);
		$store->title				 = $request->title;
		$store->lpo_date	       = $request->lpo_date;
		$store->lpo_due    	    = $request->lpo_due;
		$store->customer_note    = $request->customer_note;
		$store->terms			    = $request->terms;
      $store->status		       = 10;
      $store->type             = 'Stock control';
      $store->business_code    = Auth::user()->business_code;
      $store->created_by 	    = Auth::user()->user_code;
		$store->save();

		//products
		$products				      = $request->productID;
		foreach ($products as $k => $v){
			$product 					= new lpo_products;
         $product->business_code = Auth::user()->business_code;
         $product->product_name  = Finance::product($request->productID[$k])->product_name;
			$product->lpo_code		= $code;
			$product->product_code	= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->price    		= $request->price[$k];
         $product->total         = $request->price[$k] * $request->qty[$k];
         $product->sub_total     = $request->price[$k] * $request->qty[$k];
			$product->save();
		}

		//update lpo number
		$setting = settings::where('business_code',Auth::user()->business_code)->first();
		$setting->number = $setting->number + 1;
		$setting->save();

		Session::flash('success','order has been successfully created');

      //recorord activity
		$activity     = 'Purchase order #'.$request->lpo_prefix.$request->lpo_number.' status has been updated by '.Auth::user()->name;
		$section      = 'Purchase order';
      $module       = 'Finance';
		$action       = 'update';
		$activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

		return redirect()->route('finance.product.stock.control');

	}

	/**
   * show lpo
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($code){
		$filec = 1;
		$lpo = lpo::join('wp_business','wp_business.business_code','=','fn_purchaseorders.business_code')
						->join('wp_status','wp_status.id','=','fn_purchaseorders.status')
						->where('fn_purchaseorders.po_code',$code)
						->where('fn_purchaseorders.business_code',Auth::user()->business_code)
						->select('*','fn_purchaseorders.po_code as lpoCode','wp_business.name as business_name','fn_purchaseorders.status as status','wp_status.name as status_name')
						->first();

		$products = lpo_products::where('lpo_code',$code)->where('business_code',Auth::user()->business_code)->get();

		$supplier = suppliers::join('fn_supplier_address','fn_supplier_address.supplier_code','=','fn_suppliers.supplier_code')
						->where('fn_suppliers.business_code',Auth::user()->business_code)
						->where('fn_suppliers.supplier_code',$lpo->supplier)
						->select('*','fn_suppliers.supplier_code as supplierCode')
						->first();

		$files = docs::where('file_code',$code)
                     ->where('business_code',Auth::user()->business_code)
                     ->get();

      $persons = contact_persons::where('supplier_code',$lpo->supplier)->where('business_code',Auth::user()->business_code)->get();

		$template = Wingu::template(Wingu::business()->template_code)->template_name;

		return view('app.finance.products.stock.show', compact('supplier','lpo','products','filec','files','persons','template'));
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
		$suppliers = suppliers::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('supplier_name','supplier_code');
		$lpoproducts = lpo_products::where('lpo_code',$code)->get();
		$products = product_information::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

		return view('app.finance.products.stock.edit', compact('suppliers','lpo','products','lpoproducts'));
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
		$update->supplier	 	     = $request->supplier;
      $update->lpo_prefix	     = Finance::lpo()->prefix;
      $update->lpo_number	     = $request->lpo_number;
		$update->reference_number = $request->reference_number;
		$update->lpo_date	        = $request->lpo_date;
		$update->lpo_due	        = $request->lpo_due;
		$update->title				  = $request->title;
		$update->customer_note    = $request->customer_note;
		$update->terms				  = $request->terms;
		$update->business_code 	  = Auth::user()->business_code;
		$update->updated_by 		  = Auth::user()->user_code;
		$update->save();


		//delete product
		$delete = lpo_products::where('lpo_code',$code);
		$delete->delete();

		//new products
		$products				      = $request->productID;
		foreach ($products as $k => $v)
		{
			$product 					= new lpo_products;
         $product->business_code = Auth::user()->business_code;
         $product->product_name  = Finance::product($request->productID[$k])->product_name;
			$product->lpo_code		= $code;
			$product->product_code	= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->price    		= $request->price[$k];
         $product->total         = $request->price[$k] * $request->qty[$k];
         $product->sub_total     = $request->price[$k] * $request->qty[$k];
			$product->save();
		}


      //get invoice products
		$lpoProducts = lpo_products::where('lpo_code',$code)
                     ->select(DB::raw('SUM(total) as total'),
                        DB::raw('SUM(sub_total) as sub_total'))
                     ->first();

      $update				 = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $update->total		 = $lpoProducts->total;
		$update->sub_total = $lpoProducts->sub_total;
      $update->save();

		Session::flash('success','Order has been successfully updated');

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

		return view('app.finance.products.stock.mail', compact('details','files','contacts','supplier'));
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

      //recorord activity
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
	* attachment lpo
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$lpo = lpo::where('po_code',$request->lpoCode)->where('business_code',Auth::user()->business_code)->first();

		//directory

		$directory =  base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/purchase-order/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
      $file = $request->file('file');
      $size = $file->getSize();

      //change file name
      $filename = Helper::generateRandomString().$file->getClientOriginalName();

      //move file
		$file->move($directory, $filename);

      //save the upload details into the database
      $upload = new docs;

      $upload->file_code      = $request->lpoCode;
      $upload->folder 	      = 'Finance';
      $upload->section  	   = 'Purchase order';
		$upload->name 		      = $lpo->lpo_prefix.$lpo->lpo_number;
		$upload->file_name      = $filename;
      $upload->file_size      = $size;
		$upload->attach 	      = 'No';
      $upload->file_mime      = $file->getClientMimeType();
		$upload->created_by     = Auth::user()->user_code;
		$upload->business_code  = Auth::user()->business_code;
      $upload->save();
	}

   /**
   * generate lpo pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function convert($code,$format){
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

      if($format == 'pdf'){
         $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/lpo/lpo', compact('products','details','supplier'));
         return $pdf->download($details->lpo_prefix.$details->lpo_number.'.pdf');
      }

      if($format == 'print'){
         $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/lpo/lpo', compact('products','details','supplier'));
         return $pdf->stream($details->lpo_prefix.$details->lpo_number.'.pdf');
      }
	}


   /**
   * deliverd stock
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delivered($code){
      $lpo = lpo::where('po_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $products = lpo_products::where('lpo_code',$code)->where('business_code',Auth::user()->business_code)->get();

      if ($lpo->delivered_status == "") {
         foreach ($products as $product) {
            $inventory = product_inventory::where('product_code',$product->product_code)->where('business_code',Auth::user()->business_code)->first();
            $inventory->current_stock = $inventory->current_stock + $product->quantity;
            $inventory->save();
         }
         $lpo->delivered_status = 14;
         $lpo->status = 14;
         $lpo->save();
      }

      Session::flash('success','Stock updated add marked as delivered');

      return redirect()->back();
   }

   /**
	* 	delete lpo permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete($lpo_code){
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
         $section      = 'Purchase order ';
         $action       = 'Delete';
         $activityCode = $lpo_code;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

         $lpo->delete();

			Session::flash('success','lpo has been successfully deleted');

			return redirect()->route('finance.product.stock.control');
		}else{
			Session::flash('warning','This purchase order has been linked to an expense, you will have to unlink it first then delete the purchase order');

			return redirect()->back();
		}

	}
}
