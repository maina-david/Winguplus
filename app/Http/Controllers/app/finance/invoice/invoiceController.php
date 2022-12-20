<?php

namespace App\Http\Controllers\app\finance\invoice;

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
use App\Models\finance\income\category;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\accounts;
use App\Mail\sendInvoices;
use App\Mail\sendMessage;
use App\Mail\sendTicket;
use App\Models\finance\customer\address;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\payments\payment_methods;
use App\Models\wingu\business;
use App\Models\wingu\Email;
use Input;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;
class invoiceController extends Controller
{
	public function __construct(){
      $this->middleware('auth');
	}

   public function pdf($products,$details,$client,$payments,$settings){
      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/invoice/invoice', compact('products','details','client','payments','settings'));
      return $pdf;
   }

	public function index(){
		return view('app.finance.invoices.index');
	}

   /**
	* 	invoice details
   *
	* @param  string  $code
	*/
	public function show($code){

      $invoice = invoices::single_invoice($code);
		$products = invoice_products::invoice_products($code);
		$payments = invoice_payments::invoice_payments($code);

		$accountPayment = payment_methods::methods();

      $files = docs::media($code);

      address::customer_address_fix($invoice->customer);

      $client = customers::single_customer($invoice->customer);

		$persons = contact_persons::customer_contact_persons($invoice->customer);

		$accounts = accounts::bank_accounts();

		$categories = category::income_category();

		$template = Wingu::template($invoice->template_code)->template_name;

      $settings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		return view('app.finance.invoices.show', compact('client','invoice','products','files','persons','payments','accountPayment','accounts','categories','template','settings'));
	}

	/**
	* 	send invoice via mail
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($code){
		$details = invoices::single_invoice($code);

      $client = customers::single_customer($details->customer);

		$files = docs::media($code);

      $settings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		$contacts = contact_persons::customer_contact_persons($details->customer);

		$products = invoice_products::invoice_products($code);
		$payments = invoice_payments::invoice_payments($code);

		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

      $pdf = $this->pdf($products,$details,$client,$payments,$settings);

		$pdf->save($directory.$details->invoice_prefix.$details->invoice_number.'.pdf');

		return view('app.finance.invoices.mail', compact('details','files','contacts','client','payments'));
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
		$invoice = invoices::where('invoice_code',$request->invoiceCode)->where('business_code',Auth::user()->business_code)->first();

		//client info
		$client = customers::single_customer($invoice->customer);

		$checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('file_code',$invoice->invoice_code)->where('business_code',Auth::user()->business_code)->get();
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
			$change = docs::where('file_code',$invoice->invoice_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($change as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$mailCode = Helper::generateRandomString(20);

		$emails = new Email;
      $emails->mail_code           = $mailCode;
      $emails->message             = $request->message;
      $emails->business_code       = Auth::user()->business_code;
      $emails->client_code         = $client->customer_code;
      $emails->subject             = $request->subject;
      $emails->mail_from           = 'noreply@winguplus.com';
      $emails->category            = 'Invoice Payment acknowledgment';
      $emails->status              = 'Sent';
      $emails->ip 		           =  request()->ip();
      $emails->type                = 'Outgoing';
      $emails->section             = 'invoices';
      $emails->mail_to             = $request->send_to;
      if($checkatt > 0){
			$emails->attachment = 'yes';
		}
      if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
      $emails->created_by   = Auth::user()->user_code;
      $emails->save();


		//update invoice
		$invoice->remainder_count = $invoice->remainder_count + 1;
		$invoice->sent_status 	= 'Sent';
		$invoice->save();

		//send email
		$subject = $request->subject;

		$content = $request->message.'<img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1">';


		$from   = $request->email_from;
		$to     = $request->send_to;
		$mailID = $mailCode;
		$docID  = $invoice->invoice_code; //invoice_settings ID

		$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/'.$invoice->invoice_prefix.$invoice->invoice_number.'.pdf';

		Mail::to($to)->send(new sendInvoices($content,$subject,$from,$mailID,$docID,$attachment));


      //recored activity
		$activity     = 'Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' has been sent to the client by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Invoice';
      $action       = 'sent';
		$activityCode = $mailCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','Invoice Sent to client successfully');

		return redirect()->back();
	}

   /**
   * generate invoice pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function convert($code,$format){
		$details = invoices::single_invoice($code);

		$products = invoice_products::invoice_products($code);

      $client = customers::single_customer($details->customer);

      $payments = invoice_payments::invoice_payments($code);

      $settings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		$pdf = $this->pdf($products,$details,$client,$payments,$settings);

      if($format == 'pdf'){
		   return $pdf->download($details->invoice_prefix.$details->invoice_number.'.pdf');
      }

      if($format == 'print'){
         return $pdf->stream($details->invoice_prefix.$details->invoice_number.'.pdf');
      }
	}

	/**
	* attachment invoice_settings
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$invoice = invoices::where('invoice_code',$request->invoice_code)->where('business_code',Auth::user()->business_code)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/invoices/';

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
		$file->move($directory, $filename);

      //save the upload details into the database

		$upload = new docs;

      $upload->file_code     = $request->invoice_code;
		$upload->folder 	     = 'Finance';
		$upload->section 	     = 'invoice';
		$upload->name 		     = $invoice->invoice_prefix.$invoice->invoice_number;
		$upload->file_name     = $filename;
      $upload->file_size     = $size;
		$upload->attach 	     = 'No';
      $upload->file_mime     = $file->getClientMimeType();
		$upload->created_by    = Auth::user()->user_code;
		$upload->business_code = Auth::user()->business_code;
      $upload->save();

      //recored activity
		$activity=   Auth::user()->name.' Has attached files to this invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
		$module = 'Finance';
		$section = 'invoice';
      $action = 'create';
		$activityCode = $request->invoice_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

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
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/invoices/';

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

		//check if linked to creditnote
		$creditNote = creditnote::where('invoice_link',$invoice_code)->where('business_code',Auth::user()->business_code)->count();

		if($payments == 0 && $creditNote == 0){

			//delete all files linked to the invoice_settings
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';

			$check_files = docs::where('file_code',$invoice_code)
                           ->where('business_code',Auth::user()->business_code)
                           ->count();

			if($check_files > 0){
				$files = docs::where('file_code',$invoice_code)->where('section','invoice')->where('business_code',Auth::user()->business_code)->get();
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

			//delete invoice_settings products
			invoice_products::where('invoice_code',$invoice_code)->delete();

			//delete invoice_settings plus attachment
			$invoice = invoices::where('invoice_code',$invoice_code)->where('business_code',Auth::user()->business_code)->first();
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

         //recored activity
         $activity=   'Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' had been deleted by '.Auth::user()->name;
         $module = 'Finance';
         $section = 'invoice';
         $action = 'delete';
         $activityCode = $invoice_code;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

			Session::flash('success','Invoice has been successfully deleted');

			return redirect()->route('finance.invoice.index');
		}else{
			Session::flash('error','You have recorded transactions for this Invoice. Hence, this Invoice cannot be deleted.');

			return redirect()->back();
		}
	}

	/**
	* print Delivery note
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function deliverynote($code){
		$count = 1;
		$details = invoices::single_invoice($code);
		$products = invoice_products::invoice_products($code);
      $client = customers::single_customer($details->customer);

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/invoice/deliverynote', compact('products','details','client'));

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
		$invoice = invoices::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->first();

		//update payment
		if($invoice->paid == "NULL"){
			$oldPaid = 0;
		}else{
			$oldPaid = $invoice->paid;
		}
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
      $paymentCode = Helper::generateRandomString(20);
		$pay = new invoice_payments;
      $pay->payment_code     = $paymentCode;
		$pay->amount           = $request->amount;
		$pay->balance          = $newBalance;
		$pay->reference_number = $request->transactionID;
		$pay->payment_method   = $request->payment_method;
		$pay->payment_date     = $request->payment_date;
		$pay->invoice_code     = $request->invoice;
		$pay->created_by       = Auth::user()->user_code;
		$pay->business_code    = Auth::user()->business_code;
		$pay->note             = $request->note;
		$pay->customer_code    = $request->client;
		$pay->account          = $request->account;
		$pay->payment_category = 'Received';
		$pay->save();

		//check if invoice is a subscription invoice
		if($invoice->balance <= 0  && $invoice->paid >= $invoice->total){
			if($invoice->invoice_type == "subscription" && $invoice->subscription_code != ""){
				$subscription = subscriptions::where('id',$invoice->subscription_code)->where('business_code',Auth::user()->business_code)->first();
				$subscription->status = 36;
				$subscription->save();
			}
		}

	   //Client Credit
		if($invoice->paid > $invoice->total) {
			$paidAmount = round($invoice->paid);
			if($paidAmount > 0){
				$check = creditnote_settings::where('business_code',Auth::user()->business_code)->count();
				if($check != 1){
					Finance::creditnote_setting_setup();
				}

				//update creditnote number
				$setting = creditnote_settings::where('business_code',Auth::user()->business_code)->first();

				$creditAmount = $invoice->paid - $invoice->total;

            $code = Helper::generateRandomString(20);
				$credit					      = new creditnote;
				$total                     = $creditAmount;
            $credit->business_code 	   = Auth::user()->business_code;
            $credit->creditnote_code 	= $code;
				$credit->customer_code	 	= $request->client;
				$credit->number            = $setting->number+1;
            $credit->prefix            = $setting->prefix;
            $credit->reference_number  = $invoice->prefix.$invoice->number;
				$credit->total		         = $total;
				$credit->balance		      = $total;
				$credit->title             = 'Payment credit for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
				$credit->sub_total		   = $total;
				$credit->creditnote_date   = date('Y-m-d');
				$credit->status		      = 21;
				$credit->payment_code      = $paymentCode;
				$credit->invoice_link      = $request->invoice_code;
            $credit->created_by		   = Auth::user()->user_code;
				$credit->save();

				//products
				$product 					  = new creditnote_products;
				$product->creditnote_code = $code;
				$product->product_name	  = 'Payment credit for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
				$product->quantity		  = 1;
				$product->price    		  = $total;
				$product->save();

				$setting->number          = $setting->number + 1;
				$setting->save();

				//update payment
				$updateCredit                  = invoice_payments::where('payment_code',$paymentCode)->where('business_code',Auth::user()->business_code)->first();
				$updateCredit->credited        = 'yes';
				$updateCredit->creditnote_code = $code;
				$updateCredit->save();
			}
		}

		//Send payment acknowledgment message to client
		if($request->send_email == 'yes'){
         $mailCode = Helper::generateRandomString(20);
			$customer = customers::single_customer($invoice->customer);
         $business = business::business_info();
			$subject = 'Payment acknowledgment for #'.$invoice->invoice_prefix.$invoice->invoice_number;
			$to = $customer->email;
         $GetCreditBalance = $invoice->total - $invoice->paid;
         if($GetCreditBalance < 0){
            $creditBalance = 0;
         }else{
            $creditBalance = $GetCreditBalance;
         }

         $checkCredit = $invoice->paid - $invoice->total;
         if($checkCredit > 0){
            $creditedAmount = $checkCredit;
         }else{
            $creditedAmount = 0;
         }

			$content = '<span style="font-size: 12pt;">Hello '.$customer->customer_name.'</span><br/><br/>
			Thank you for the payment. Find the payment details below:<br/><br/>
			-------------------------------------------------
			<br/><br/>
			Balance:&nbsp;<strong>'.$business->currency.number_format($creditBalance).'</strong><br/>
         Credited:&nbsp;<strong>'.$business->currency.number_format($creditedAmount).'</strong><br/>
			Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
			Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.$invoice->invoice_prefix.$invoice->invoice_number.'</strong><br/><br/></span>
			-------------------------------------------------
			<br/><br/>
			We are looking forward working with you.<br/><img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1">';

			Mail::to($to)->send(new sendMessage($content,$subject));

			//save email
         $emails = new Email;
         $emails->mail_code           = $mailCode;
         $emails->message             = $content;
         $emails->business_code       = Auth::user()->business_code;
         $emails->client_code         = $invoice->customer;
         $emails->subject             = $subject;
         $emails->mail_from           = 'noreply@winguplus.com';
         $emails->category            = 'Invoice Payment acknowledgment';
         $emails->status              = 'Sent';
         $emails->ip 		           =  request()->ip();
         $emails->type                = 'Outgoing';
         $emails->section             = 'Payments';
         $emails->mail_to             = $to;
         $emails->created_by   = Auth::user()->user_code;
         $emails->save();

		}

      //send ticket
      if($invoice->is_ticket == 'Yes'){
         if($invoice->balance == 0){
            $customer = customers::where('customer_code',$invoice->customer)->where('business_code',Auth::user()->business_code)->first();
            $products = invoice_products::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->get();

            foreach($products as $product){
               $to = $customer->email;
               Mail::to($to)->send(new sendTicket($product->product_code,$product->event_code));
            }
         }
      }

      //record activity
		$activity     = 'A payment has been recorder for Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Invoice';
      $action       = 'sent';
		$activityCode = $paymentCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','The payment from the customer has been recorded');

		return redirect()->back();

	}

   /**
   * Due invoices
   */
   public function due_invoices(){
      return view('app.finance.invoices.due');
   }
}
