<?php
namespace App\Http\Controllers\app\ecommerce\products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\subscriptions\subscriptions;
use App\Models\wingu\file_manager as docs;
use App\Models\crm\emails;
use App\Models\finance\payments\payment_type;
use App\Mail\sendInvoices;
use App\Mail\sendMessage;
use App\Models\finance\accounts;
use App\Models\finance\customer\address;
use App\Models\finance\income\category;
use App\Models\finance\payments\payment_methods;
use Input;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;
class ordersController extends Controller{
	public function __construct(){
      $this->middleware('auth');
	}

	public function index(){
		$invoices	= invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                           ->join('wp_status','wp_status.id','=','fn_invoices.status')
                           ->where('invoice_type','wingu store')
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->select('*','wp_status.name as statusName')
                           ->orderby('fn_invoices.id','desc')
                           ->get();

		return view('app.ecommerce.orders.index', compact('invoices'));
	}

	public function deleteProduct(){
		$delete = invoice_products::where('id', Input::get('id'));
		$delete->delete();
	}

	public function show($code){

      $order = invoices::single_invoice($code);
		$products = invoice_products::invoice_products($code);
		$payments = invoice_payments::invoice_payments($code);

		$accountPayment = payment_methods::methods();

      $files = docs::media($code);

      address::customer_address_fix($order->customer);

      $client = customers::single_customer($order->customer);

		$persons = contact_persons::customer_contact_persons($order->customer);

		$accounts = accounts::bank_accounts();

		$categories = category::income_category();

		$template = Wingu::template($order->template_code)->template_name;

		return view('app.ecommerce.orders.show', compact('client','order','products','files','persons','payments','accountPayment','accounts','categories','template'));
	}

	/**
	* 	send invoice via mail
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($id){
		$invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
					->join('currency','currency.id','=','wp_business.base_currency')
					->join('wp_status','wp_status.id','=','fn_invoices.status')
					->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
					->where('fn_invoices.id',$id)
					->where('fn_invoices.business_code',Auth::user()->business_code)
					->select('*','fn_invoices.id as invoice_code','wp_business.name as businessName','fn_invoices.id as invoice_code','wp_business.business_code as business_code')
					->first();

		$client = customers::join('customer_address','customer_address.customer_code','=','fn_customers.customer_code')
							->where('fn_customers.customer_code',$invoice->customer_code)
							->where('fn_customers.business_code',Auth::user()->business_code)
							->select('*','fn_customers.customer_code as clientID')
							->first();

		$files = docs::where('fileID',$id)->where('section','Invoice')->where('business_code',Auth::user()->business_code)->get();
		$contacts = contact_persons::where('customer_code',$client->clientID)->get();

		$count = 1;

		$details = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
					->join('currency','currency.id','=','wp_business.base_currency')
					->join('wp_status','wp_status.id','=','fn_invoices.status')
					->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
					->where('fn_invoices.id',$id)
					->where('fn_invoices.business_code',Auth::user()->business_code)
					->select('*','invoice_number as number','wp_business.name as businessName','fn_invoices.id as invoice_code','wp_business.business_code as business_code')
					->first();

		$products = invoice_products::where('invoice_code',$details->invoice_code)->get();

      $payments = invoice_payments::where('invoice_code',$id)
                        ->where('invoice_payments.business_code',Auth::user()->business_code)
                        ->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->business_code)->templateID)->template_name.'/invoice/invoice', compact('products','details','client','taxed','count','payments'));

		$pdf->save($directory.Finance::invoice_settings()->prefix.$details->invoice_number.'.pdf');

		return view('app.ecommerce.orders.mail', compact('invoice','files','contacts','client','payments'));
	}

	/**
	* 	send invoice via email
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

		//invoice_settings information
		$invoice = invoices::where('id',$request->invoice_code)->where('business_code',Auth::user()->business_code)->first();

		//client info
		$client = customers::join('customer_address','customer_address.customer_code','=','fn_customers.customer_code')
							->where('fn_customers.customer_code',$invoice->customer_code)
							->where('fn_customers.business_code',Auth::user()->business_code)
							->select('*','fn_customers.customer_code as clientID')
							->first();


		$checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','invoice')->where('fileID',$invoice->id)->where('business_code',Auth::user()->business_code)->get();
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
			$change = docs::where('section','invoice')->where('fileID',$invoice->id)->where('business_code',Auth::user()->business_code)->get();
			foreach ($change as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$trackCode = Helper::generateRandomString(9);

		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $client->clientID;
		$emails->subject   = $request->subject;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = 'yes';
		}
		$emails->category  = 'Invoice Document';
		$emails->status    = 'Sent';
		$emails->ip 		 = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'invoices';
		$emails->mail_to   = $request->send_to;
		$emails->userID   = Auth::user()->id;
		$emails->business_code   = Auth::user()->business_code;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		//update invoice
		$invoice->remainder_count = $invoice->remainder_count + 1;
		$invoice->sent_status 	= 'Sent';
		$invoice->save();

		//send email
		$subject = $request->subject;

		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->business_code.'/'.$emails->id.'" width="1" height="1" /><img src="'.url('/').'/track/invoice/'.$trackCode.'/'.Auth::user()->business_code.'/'.$invoice->id.'" width="1" height="1" />';


		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$docID = $invoice->id; //invoice_settings ID

		$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/'.Finance::invoice_settings()->prefix.$invoice->invoice_number.'.pdf';

		Mail::to($to)->send(new sendInvoices($content,$subject,$from,$mailID,$docID,$attachment));

		//recorord activity
		$activities = 'Invoice #'.Finance::invoice_settings()->prefix.''.$invoice->invoice_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->invoice_code;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','Invoice Sent to client successfully');

		return redirect()->back();
	}

	/**
	* attachment invoice_settings
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$invoice = invoices::where('id',$request->invoice_code)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';

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

      $upload->fileID      = $request->invoice_code;
		$upload->folder 	   = 'Finance';
		$upload->section 	   = 'invoice';
		$upload->name 		   = Finance::invoice_settings()->prefix.$invoice->invoice_number;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->id;
		$upload->business_code  = Auth::user()->business_code;
      $upload->save();

		//recorord activity
		$activities = Auth::user()->name.' Has attached files to this invoice #'.Finance::invoice_settings()->prefix.$invoice->invoice_number;
		$section = 'invoice';
		$type = 'Attachment';
      $adminID = Auth::user()->id;
      $business_code = Auth::user()->business_code;
		$activityID = $request->invoice_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);


		Session::flash('success','Invoice has been successfully attached');
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
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';

		$delete = $directory.$file->file_name;
		if(File::exists($delete)) {
			unlink($delete);
		}

		$file->delete();

		Session::flash('success','File Deleted');

		return redirect()->back();
	}

	/**
	* 	delete invoice permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_invoice($invoice_code){

		// check for payments
		$payments = invoice_payments::where('invoice_code',$invoice_code)->where('business_code',Auth::user()->business_code)->count();

		if($payments == 0){

			//delete all files linked to the invoice_settings
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';

			$check_files = docs::where('fileID',$invoice_code)
								->where('section','invoice')
								->where('business_code',Auth::user()->business_code)
								->count();

			if($check_files > 0){
				$files = docs::where('fileID',$invoice_code)->where('section','invoice')->where('business_code',Auth::user()->business_code)->get();
				foreach($files as $file){
					$doc = docs::where('id',$file->id)->where('section','invoice')->where('business_code',Auth::user()->business_code)->first();

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete invoice_settings products
			 invoice_products::where('invoice_code',$invoice_code)->delete();

			//delete invoice_settings plus attachment
			$invoice = invoices::where('id',$invoice_code)->where('business_code',Auth::user()->business_code)->first();
			if($invoice->attachment != ""){
				$delete = $directory.$invoice->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$invoice->delete();

			//delete payments
			$payments = invoice_payments::where('invoice_code',$invoice_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($payments as $payment) {
				$payment->delete();
			}

			//recorord activity
			$activities = 'Invoice #'.Finance::invoice_settings()->prefix.$invoice->invoice_number.' had been deleted by '.Auth::user()->name;
			$section = 'Invoice';
			$type = 'Delete';
			$adminID = Auth::user()->id;
			$activityID = $invoice_code;
			$business_code = Auth::user()->business_code;

			Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

			Session::flash('success','Invoice has been successfully deleted');

			return redirect()->route('ecommerce.orders.index');
		}else{
			Session::flash('error','You have recorded transactions for this Invoice. Hence, this Invoice cannot be deleted.');

			return redirect()->back();
		}
	}

	/**
   * generate invoice pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function pdf($id){
		$count = 1;
		$details = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
					->join('currency','currency.id','=','wp_business.base_currency')
					->join('wp_status','wp_status.id','=','fn_invoices.status')
					->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
					->where('fn_invoices.id',$id)
					->where('fn_invoices.business_code',Auth::user()->business_code)
					->select('*','invoice_number as number','wp_business.name as businessName','fn_invoices.id as invoice_code','wp_business.business_code as business_code')
					->first();

		$products = invoice_products::where('invoice_code',$details->invoice_code)->get();

		$client = customers::join('customer_address','customer_address.customer_code','=','fn_customers.customer_code')
					->where('fn_customers.customer_code',$details->customer_code)
					->where('business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as clientID','bill_country as countryID')
					->first();

      $payments = invoice_payments::where('invoice_code',$id)
                        ->where('invoice_payments.business_code',Auth::user()->business_code)
                        ->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->business_code)->templateID)->template_name.'/invoice/invoice', compact('products','details','client','taxed','count','payments'));

		return $pdf->download(Finance::invoice_settings()->prefix.$details->invoice_number.'.pdf');
	}

	/**
	* print invoice
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($id){
		$count = 1;
		$details = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
					->join('currency','currency.id','=','wp_business.base_currency')
					->join('wp_status','wp_status.id','=','fn_invoices.status')
					->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
					->where('fn_invoices.id',$id)
					->where('fn_invoices.business_code',Auth::user()->business_code)
					->select('*','invoice_number as number','wp_business.name as businessName','fn_invoices.id as invoice_code','wp_business.business_code as business_code')
					->first();

		$products = invoice_products::where('invoice_code',$details->invoice_code)->get();

		$client = customers::join('customer_address','customer_address.customer_code','=','fn_customers.customer_code')
					->where('fn_customers.customer_code',$details->customer_code)
					->where('business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as clientID','bill_country as countryID')
					->first();

      $payments = invoice_payments::where('invoice_code',$id)
                        ->where('invoice_payments.business_code',Auth::user()->business_code)
                        ->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->business_code)->templateID)->template_name.'/invoice/invoice', compact('products','details','client','taxed','count','payments'));

		return $pdf->stream(Finance::invoice_settings()->prefix.$details->invoice_number.'.pdf');
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
	* invoice payments
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function payment(Request $request){
		$this->validate($request, [
			'amount' => 'required',
		]);

		//update invoice payment & status
		$invoice =  invoices::where('id',$request->invoice_code)->where('business_code',Auth::user()->business_code)->first();

		//update payment
		$oldPaid = $invoice->paid;
		$newPaid = $oldPaid + $request->amount;

		$newBalance = $invoice->total - $newPaid;
		if($newBalance < 0){
			$newBalance = 0;
		}
		$invoice->balance = $newBalance;
		$invoice->paid = $newPaid;

		//update status
		if($newPaid == $invoice->total || $newPaid > $invoice->total){
			$invoice->status = 1;
		}elseif($newPaid < $invoice->total && $newPaid != 0 ){
			$invoice->status = 3;
		}

		$invoice->save();

		//record payment
		$pay = new invoice_payments;
		$pay->amount = $request->amount;
		$pay->balance = $newBalance;
		$pay->reference_number = $request->transactionID;
		$pay->payment_method = $request->payment_method;
		$pay->payment_date = $request->payment_date;
		$pay->invoice_code = $request->invoice_code;
		$pay->created_by = Auth::user()->id;
		$pay->business_code = Auth::user()->business_code;
		$pay->note = $request->note;
		$pay->customer_code = $request->clientID;
		$pay->incomeID = $request->incomeID;
		$pay->accountID = $request->accountID;
		$pay->payment_category = 'Received';
		$pay->save();

		//check if invoice is a subscription invoice
		if($invoice->balance <= 0  && $invoice->paid >= $invoice->total){
			if($invoice->invoice_type == "Subscription" && $invoice->subscriptionID != ""){
				$subscription = subscriptions::where('id',$invoice->subscriptionID)->where('business_code',Auth::user()->business_code)->first();
				$subscription->status = 36;
				$subscription->save();
			}
		}


	   //Client Credit
		if($invoice->paid > $invoice->total) {
			$paidAmount = round($invoice->paid);
			if( $paidAmount > 0){

				$check = creditnote_settings::where('business_code',Auth::user()->business_code)->count();
				if($check != 1){
					Finance::creditnote_setting_setup();
				}
				//update creditnote number
				$setting = creditnote_settings::where('business_code',Auth::user()->business_code)->first();

				$creditAmount = $invoice->paid - $invoice->total;

				$credit					      = new creditnote;
				$total                     = $creditAmount;
				$credit->created_by		   = Auth::user()->id;
				$credit->customer_code	 	   = $request->clientID;
				$credit->creditnote_number = $setting->number+1;
				$credit->total		         = $total;
				$credit->balance		      = $total;
				$credit->title             = 'Payment credit for invoice #'.$invoice->invoice_number;
				$credit->sub_total		   = $total;
				$credit->creditnote_date   = date('Y-m-d');
				$credit->status		      = 21;
				$credit->paymentID         = $pay->id;
				$credit->business_code 	      = Auth::user()->business_code;
				$credit->save();

				//products
				$product 					= new creditnote_products;
				$product->creditnoteID  = $credit->id;
				$product->product_name	= 'Payment credit for invoice #'.$invoice->invoice_number;
				$product->quantity		= 1;
				$product->price    		= $total;
				$product->save();


				$setting->number = $setting->number + 1;
				$setting->save();

				//update payment
				$updateCredit = invoice_payments::find($pay->id);
				$updateCredit->credited = 'yes';
				$updateCredit->creditID = $credit->id;
				$updateCredit->save();
			}
		}

		//Send payment acknowledgment message to client
		if($request->send_email == 'yes'){

			$clientName = Finance::client($invoice->customer_code)->customer_name;

			$subject = 'Payment acknowledgment for #'.Finance::invoice_settings()->prefix.$invoice->invoice_number;
			$to = Finance::client($invoice->customer_code)->email;
			$content = '<span style="font-size: 12pt;">Hello '.$clientName.'</span><br/><br/>
			Thank you for the payment. Find the payment details below:<br/><br/>
			-------------------------------------------------
			<br/><br/>
			Amount:&nbsp;<strong>'. number_format($request->amount).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Balance:&nbsp;<strong>'. number_format($invoice->total - $invoice->paid).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
			Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.Finance::invoice_settings()->prefix.$invoice->invoice_number.'</strong><br/><br/></span>
			-------------------------------------------------
			<br/><br/>
			We are looking forward working with you.<br/>';

			Mail::to($to)->send(new sendMessage($content,$subject));

			//save email
			$emails = new emails;
			$emails->message   = $content;
			$emails->clientID  = $invoice->customer_code;
			$emails->subject   = $subject;
			$emails->mail_from = 'noreply@winguplus.com';
			$emails->category  = 'Invoice Payment acknowledgment';
			$emails->status    = 'Sent';
			$emails->ip 		 = Helper::get_client_ip();
			$emails->type      = 'Outgoing';
			$emails->section   = 'invoices';
			$emails->mail_to   = $to;
			$emails->userID   = Auth::user()->id;
			$emails->business_code   = Auth::user()->business_code;
			$emails->save();

		}

		//record activity
		$activities = 'Invoice #'.Finance::invoice_settings()->prefix.$invoice->invoice_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->invoice_code;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','The payment from the customer has been recorded');

		return redirect()->back();

	}
}
