<?php

namespace App\Http\Controllers\app\finance\quotes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\quotes\quotes;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\quotes\quote_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\quotes\quote_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\crm\emails;
use App\Mail\sendQuotes;
use App\Models\wingu\Email;
use Session;
use File;
use Helper;
use Finance;
use DB;
use Wingu;
use Auth;
use PDF;
use Mail;

class quotesController extends Controller
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
		$quotes	= quotes::join('wp_business','wp_business.business_code','=','fn_quotes.business_code')
						->join('fn_quote_settings','fn_quote_settings.business_code','=','wp_business.business_code')
						->join('fn_customers','fn_customers.customer_code','=','fn_quotes.customer_code')
						->join('wp_status','wp_status.id','=','fn_quotes.status')
						->where('fn_quotes.business_code',Auth::user()->business_code)
						->select('*','fn_quotes.quote_code as quoteCode','fn_quotes.created_at as quote_date','fn_quotes.reference_number as reff','fn_quotes.status as qstatus','wp_business.currency as currency')
						->orderby('fn_quotes.id','desc')
						->get();

			return view('app.finance.quotes.index', compact('quotes'));
	}

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		//check if account has settings
		$check = settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::quote_setting_setup();
		}

      $customers = customers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('customer_name','customer_code')
                           ->prepend('Choose customer','');

      $products = product_information::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

      $taxes = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

      return view('app.finance.quotes.create', compact('customers','taxes','products'));
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
			'customer'	=> 'required',
			'quote_number'	=> 'required',
			'quote_date'	=> 'required',
			'quote_due'	=> 'required',
		));

		//store invoice
		$code = Helper::generateRandomString(16);
		$store					    = new quotes;
		$store->created_by		 = Auth::user()->user_code;
		$store->customer_code	 = $request->customer;
		$store->quote_number	    = $request->quote_number;
      $store->subject	    	 = $request->subject;
      $store->quote_code 	    = $code;
		$store->description	    = $request->description;
		$store->reference_number = $request->reference_number;
		$store->quote_date	    = $request->quote_date;
		$store->quote_due			= $request->quote_due;
		$store->customer_note	= $request->customer_note;
		$store->tax_config		= $request->tax_config;
		$store->terms				= $request->terms;
		$store->status			   = 10;
		$store->business_code 	= Auth::user()->business_code;
		$store->save();


		//products
		$products				= $request->productID;
		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$tax_value = $amount * $rate;

			$totalAmount = $amount + $tax_value;

			$product 					= new quote_products;
			$product->quote_code		= $code;
         $product->business_code = Auth::user()->business_code;
			$product->product_code	= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->tax_rate		= $request->tax[$k];
			$product->tax_value		= $tax_value;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->save();
		}

		//get invoice products
		$quoteProducts = quote_products::where('quote_code',$code)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount ) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as tax_value'))
								->first();

		//update invoice
		$quote = quotes::where('quote_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$quote->main_amount = $quoteProducts->mainAmount;
		$quote->discount    = $quoteProducts->discount;
		$quote->total		  = $quoteProducts->total;
		$quote->sub_total	  = $quoteProducts->sub_total;
		$quote->tax_value	  = $quoteProducts->tax_value;
		$quote->save();

		//update quotes number
		$setting = settings::where('business_code',Auth::user()->business_code)->first();
		$setting->number = $setting->number + 1;
		$setting->save();

		Session::flash('success','quotes has been successfully created');

		return redirect()->route('finance.quotes.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {

		$quote = quotes::where('quote_code',$code)->where('business_code',Auth::user()->business_code)->select('*','customer_code as customer')->first();

		$customers = customers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('customer_name','customer_code')
                           ->prepend('Choose customer','');

		$taxes = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
      $quoteProducts = quote_products::where('quote_code',$code)->get();
      $products = product_information::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

		if($quote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $quote->sub_total * ($quote->tax / 100);
		}

		return view('app.finance.quotes.edit', compact('customers','taxed','quote','products','quoteProducts','taxes'));
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
			'customer'	=> 'required',
			'quote_number'	=> 'required',
			'quote_date'	=> 'required',
			'quote_due'	=> 'required',
		));

		$update	= quotes::where('quote_code',$code)->where('business_code',Auth::user()->business_code)->first();

		//delete product
		$delete = quote_products::where('quote_code', $code);
		$delete->delete();

		//new products
		$products				= $request->productID;
		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$tax_value = $amount * $rate;

			$totalAmount = $amount + $tax_value;

			$product 					= new quote_products;
			$product->quote_code		= $code;
         $product->business_code = Auth::user()->business_code;
			$product->product_code	= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->tax_rate		= $request->tax[$k];
			$product->tax_value		= $tax_value;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->save();
		}
		//get quote products
		$quoteProducts = quote_products::where('quote_code',$code)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as tax_value'))
								->first();

		//update quoe
		if($update->quote_code == "") {
			$code = Helper::generateRandomString(16);
			$update->quote_code = $code;
		}

		$update->main_amount      =  $quoteProducts->mainAmount;
		$update->discount         = $quoteProducts->discount;
		$update->total		        = $quoteProducts->total;
		$update->sub_total	     = $quoteProducts->sub_total;
		$update->tax_value	     = $quoteProducts->tax_value;
		$update->updated_by		  = Auth::user()->user_code;
		$update->customer_code	  = $request->customer;
		$update->reference_number = $request->reference_number;
		$update->subject	    	  = $request->subject;
		$update->tax_config		  = $request->tax_config;
		$update->description	     = $request->description;
		$update->quote_date	     = $request->quote_date;
		$update->quote_due	     = $request->quote_due;
		$update->customer_note	  = $request->customer_note;
		$update->terms				  = $request->terms;
      $update->business_code    = Auth::user()->business_code;
		$update->save();

		Session::flash('success','quotes has been successfully updated');

    	return redirect()->back();
	}

	/**
   * show quotes
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($code){

		$quote = quotes::join('wp_business','wp_business.business_code','=','fn_quotes.business_code')
                     ->join('fn_quote_settings','fn_quote_settings.business_code','=','wp_business.business_code')
                     ->join('wp_status','wp_status.id','=','fn_quotes.status')
                     ->where('fn_quotes.quote_code',$code)
                     ->where('fn_quotes.business_code',Auth::user()->business_code)
                     ->select('*','wp_status.name as statusName','wp_business.name as businessName','fn_quotes.quote_code as quote_code','fn_quotes.reference_number as reff','wp_business.business_code as business_code','wp_business.currency as currency')
                     ->first();

		$products = quote_products::join('fn_product_information','fn_product_information.product_code','=','fn_quote_products.product_code')
                              ->where('quote_code',$quote->quote_code)
                              ->get();

		$customer = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
							->where('fn_customers.customer_code',$quote->customer_code)
							->select('*','fn_customers.customer_code as customer_code')
                     ->first();

		if($quote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $quote->sub_total * ($quote->tax / 100);
		}

		$files = docs::where('file_code',$code)->where('section','quotes')->where('business_code',Auth::user()->business_code)->get();

		$persons = contact_persons::where('customer_code',$customer->customer_code)->get();

		$template = Wingu::template()->template_name;

		return view('app.finance.quotes.show', compact('customer','quote','products','taxed','files','persons','template'));
	}


	/**
	* print quotes
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($code){

		$details = quotes::join('wp_business','wp_business.business_code','=','fn_quotes.business_code')
                        ->join('fn_quote_settings','fn_quote_settings.business_code','=','wp_business.business_code')
                        ->join('wp_status','wp_status.id','=','fn_quotes.status')
                        ->where('fn_quotes.quote_code',$code)
                        ->where('fn_quotes.business_code',Auth::user()->business_code)
                        ->select('*','wp_status.name as statusName','wp_business.name as businessName','fn_quotes.quote_code as quote_code','fn_quotes.reference_number as reff','wp_business.business_code as business_code','wp_business.currency as currency')
                        ->first();

		$products = quote_products::join('fn_product_information','fn_product_information.product_code','=','fn_quote_products.product_code')
                              ->where('quote_code',$details->quote_code)
                              ->get();

      $client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                              ->where('fn_customers.customer_code',$details->customer_code)
                              ->select('*','fn_customers.customer_code as customer_code')
                              ->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template()->template_name.'/quotes/quotes', compact('products','details','client','taxed'));

		return $pdf->stream(Finance::quote()->prefix.$details->quote_number.'.pdf');
	}

	/**
	* attachment quotes
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$quotes = quotes::where('id',$request->quoteID)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/quotes/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
		$file = $request->file('file');
		$size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString().$file->getClientOriginalName();

      //move file
		$upload_success = $file->move($directory, $filename);

      //save the upload details into the database
      $upload = new docs;

      $upload->fileID  = $request->quoteID;
      $upload->folder 	 = 'Finance';
      $upload->section 	 = 'quotes';
		$upload->name 		 = Finance::quote()->prefix.$quotes->quote_number;
		$upload->file_name = $filename;
		$upload->file_size = $size;
		$upload->attach 	 = 'No';
      $upload->file_mime = $file->getClientMimeType();
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
		$file = docs::where('id',$file)->where('business_code',Auth::user()->business_code)->first();
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
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/quotes/';

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
		$details = quotes::join('wp_business','wp_business.business_code','=','fn_quotes.business_code')
                     ->join('fn_quote_settings','fn_quote_settings.business_code','=','wp_business.business_code')
                     ->join('wp_status','wp_status.id','=','fn_quotes.status')
                     ->where('fn_quotes.quote_code',$code)
                     ->where('fn_quotes.business_code',Auth::user()->business_code)
                     ->select('*','wp_status.name as statusName','wp_business.name as businessName','fn_quotes.quote_code as quote_code','fn_quotes.reference_number as reff','wp_business.business_code as business_code','wp_business.currency as currency')
                     ->first();

      $products = quote_products::join('fn_product_information','fn_product_information.product_code','=','fn_quote_products.product_code')
                              ->where('quote_code',$details->quote_code)
                              ->get();

      $client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                              ->where('fn_customers.customer_code',$details->customer_code)
                              ->select('*','fn_customers.customer_code as customer_code')
                              ->first();

		$files = docs::where('file_code',$code)->where('section','quotes')->where('business_code',Auth::user()->business_code)->get();

		$contacts = contact_persons::where('customer_code',$client->customer_code)->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/quotes/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/quotes/quotes', compact('products','details','client','taxed'));

		$pdf->save($directory.$details->prefix.$details->quote_number.'.pdf');

		return view('app.finance.quotes.mail', compact('details','files','contacts','client'));
	}

	/**
	* 	send quotes via email
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function send(Request $request){
		$this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required|email',
			'subject'    => 'required',
			'message'	 => 'required',
		]);

		//quotes information
		$quote = quotes::where('quote_code',$request->quote_code)->where('business_code',Auth::user()->business_code)->first();

		//client info
      $client = customers::single_customer($quote->customer_code);

		$checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('file_code',$request->quote_code)->where('business_code',Auth::user()->business_code)->get();
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
			//change file status to null
			$change = docs::where('file_code',$request->quote_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($change as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

      $mailCode = Helper::generateRandomString(12);
      //save email
      $emails = new Email;
      $emails->mail_code           = $mailCode;
      $emails->message             = $request->message;
      $emails->business_code       = Auth::user()->business_code;
      $emails->client_code         = $quote->customer_code;
      $emails->subject             = $request->subject;
      $emails->mail_from           = 'noreply@winguplus.com';
      $emails->category            = 'Quotes Document';
      $emails->status              = 'Sent';
      $emails->ip 		           =  request()->ip();
      $emails->type                = 'Outgoing';
      $emails->section             = 'quotes';
      $emails->mail_to             = $request->send_to;
      if($checkatt > 0){
			$emails->attachment       = 'yes';
		}
      if($checkcc > 0){
			$emails->cc   	           = json_encode($request->get('email_cc'));
		}
      $emails->created_by   = Auth::user()->user_code;
      $emails->save();

		//update quotes
		$quote->remainder_count = $quote->remainder_count + 1;
		$quote->sent_status 	= 'Sent';
		$quote->save();

		//send email
		$subject = $request->subject;
      $content = $request->message.'<br><img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1" />';

		$from   = $request->email_from;
		$to     = $request->send_to;
		$mailID = $mailCode;
		$docID  = $quote->quote_code;

		$attachment = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/quotes/'.$quote->prefix. $quote->quote_number.'.pdf';

		Mail::to($to)->send(new sendQuotes($content,$subject,$from,$mailID,$docID,$attachment));

		//recored activity
		$activity     = 'quotes #'.$quote->prefix.$quote->quote_number.' has been sent to the client by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Quotes';
      $action       = 'sent';
		$activityCode = $mailCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','quotes Sent to client successfully');

		return redirect()->back();
	}

	/**
	* 	change quotes status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($quoteID,$status){
		$quotes = quotes::where('quote_code',$quoteID)->where('business_code',Auth::user()->business_code)->first();
		$quotes->status = $status;
		$quotes->save();

		//recorord activity
		$activities = 'quotes #'.Finance::quote()->prefix.$quotes->quote_number.' status has been updated by '.Auth::user()->name;
		$section = 'quotes';
		$type = 'update';
		$adminID = Auth::user()->user_code;
		$activityID = $quoteID;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','quotes status successfully changed');
		return redirect()->back();
	}

	/**
	* 	change quotes status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function convert_to_invoice($code){
		$quote = quotes::where('quote_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $code = Helper::generateRandomString(16);

		//create invoice
		$invoice = new invoices;
      $invoice->invoice_code    = $code;
		$invoice->customer        = $quote->customer_code;
		$invoice->invoice_number  = Finance::invoice_settings()->number + 1;
      $invoice->invoice_prefix  = Finance::invoice_settings()->prefix;
		$invoice->invoice_date    = $quote->quote_date;
		$invoice->invoice_due     = $quote->quote_due;
		$invoice->status          = 2;
		$invoice->invoice_type    = 'Product';
		$invoice->invoice_title   = $quote->subject;
		$invoice->main_amount     = $quote->main_amount;
		$invoice->discount        = $quote->discount;
		$invoice->total		     = $quote->total;
		$invoice->sub_total	     = $quote->sub_total;
      $invoice->tax_value	     = $quote->tax_value;
		$invoice->tax_config		  = $quote->tax_config;
      $invoice->created_by		  = Auth::user()->user_code;
		$invoice->branch 		     = Auth::user()->branch_code;
		$invoice->business_code   = Auth::user()->business_code;
		$invoice->save();


		//create products
		$items = quote_products::where('quote_code',$code)->get();
		foreach($items as $item){
         $product 					= new invoice_products;
			$product->invoice_code	= $code;
			$product->product_code	= $item->product_code;
			$product->quantity		= $item->quantity;
			$product->discount		= $item->discount;
			$product->tax_rate		= $item->tax_rate;
			$product->tax_value		= $item->tax_value;
			$product->total_amount  = $item->total_amount;
			$product->main_amount   = $item->main_amount;
			$product->sub_total  	= $item->sub_total;
			$product->selling_price = $item->price;
			$product->category      = 'Product';
         $product->business_code = Auth::user()->business_code;
			$product->save();
		}

		//link quotes to invoice
		$quote->invoice_link = $code;
		$quote->status = 13;
		$quote->save();

		//update invoice number settings
		$invoice_settings = invoice_settings::where('business_code',Auth::user()->business_code)->first();
		$invoice_settings->number = $invoice_settings->number + 1;
		$invoice_settings->save();


		//record activity
      $activity= 'Quotes #'.$quote->prefix.$quote->quote_number.' had been converted to an invoice <a href="'.route('finance.invoice.show',$code).'">#'.$invoice->prefix.$invoice->invoice_number.'</a>  by <b>'.Auth::user()->name.'</b>';
		$module  = 'Finance';
		$section = 'Quotes';
      $action  = 'Convert';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','quotes has been successfully converted');

		return redirect()->back();
	}

	/**
	* 	delete quotes permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_quotes($code){

		$quotes = quotes::where('quote_code',$code)->where('business_code',Auth::user()->business_code)->first();

		if($quotes->invoice_link == "" && $quotes->status == 10){

			//delete all files linked to the quotes
			$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/quotes/';

			$check_files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->count();

			if($check_files > 0){
				$files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();
				foreach($files as $file){
					$doc = docs::find($file->id);

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete quotes products
			quote_products::where('quote_code',$code)->delete();

			//delete quotes plus attachment
			if($quotes->attachment != ""){
				$delete = $directory.$quotes->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}


         //record activity
         $activity= 'quotes #'.$quotes->prefix.$quotes->quote_number.' had been deleted by '.Auth::user()->name;
         $module  = 'Finance';
         $section = 'Quote';
         $action  = 'Delete';
         $activityCode = $code;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

         $quotes->delete();

			Session::flash('success','quotes has been successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this quote. Hence, this quote cannot be deleted.');

			return redirect()->back();
		}
	}
}
