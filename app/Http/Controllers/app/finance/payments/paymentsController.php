<?php

namespace App\Http\Controllers\app\finance\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\invoice\invoices;
use App\Models\finance\customer\customers;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\creditnote\invoice_creditnote;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\creditnote\creditnote;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\accounts;
use App\Models\finance\income\category;
use App\Mail\sendPayment;
use App\Mail\sendMessage;
use App\Models\finance\payments\payment_methods;
use App\Models\wingu\business;
use App\Models\wingu\Email;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

class paymentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      return view('app.finance.payments.index');
   }

   public function create(){
      $contacts = customers::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

      $paymentMethod = payment_methods::where('business_code',Auth::user()->business_code)->pluck('name','method_code')->prepend('Choose payment method','');

      $currency = Wingu::business()->currency;

      $accounts = accounts::where('business_code',Auth::user()->business_code)->pluck('title','account_code')->prepend('Choose deposit account','');

      return view('app.finance.payments.create', compact('contacts','paymentMethod','accounts','currency'));
   }

   public function store(request $request){
      $this->validate($request, array(
         'customer'=>'required',
         'amount'=>'required',
         'invoice'=>'required',
      ));

      //update invoice payment & status
      $invoice =  invoices::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->first();
      $newBalance = $invoice->balance - $request->amount;
      if($newBalance < 0){
         $newBalance = 0;
      }

      $payment = new invoice_payments;
      $paymentCode = Helper::generateRandomString(20);
      $payment->payment_code     = $paymentCode;
      $payment->amount           = $request->amount;
      $payment->balance          = $newBalance;
      $payment->bank_charges     = $request->bank_charges;
      $payment->payment_date     = $request->payment_date;
      $payment->payment_method   = $request->payment_method; 
      $payment->reference_number = $request->reference_number;
      $payment->invoice_code     = $request->invoice;
      $payment->note             = $request->note;
      $payment->customer_code    = $request->customer;
      $payment->created_by       = Auth::user()->user_code;
      $payment->business_code    = Auth::user()->business_code;
      $payment->payment_category = 'Received';
      $payment->save();

      //update payment
      $oldPaid = $invoice->paid;
      $newPaid = $oldPaid + $request->amount;

      $invoice->balance = $invoice->total - $newPaid;
      $invoice->paid = $newPaid;
         //update status
         if($newPaid == $invoice->total || $newPaid > $invoice->total){
            $invoice->status = 1;
         }elseif($newPaid < $invoice->total && $newPaid != 0 ){
            $invoice->status = 3;
      }
      $invoice->save();

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

            $code = Helper::generateRandomString(20);
				$credit					      = new creditnote;
				$total                     = $creditAmount;
            $credit->business_code 	   = Auth::user()->business_code;
            $credit->creditnote_code 	= $code;
				$credit->customer_code	 	= $request->client;
				$credit->number            = $setting->number+1;
            $credit->prefix            = $setting->prefix;
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

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/';

         if(!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //get attachment
         $files = $request->file('files');

         foreach($files as $file) {

            $size =  $file->getSize();

            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(30). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;
            $upload->file_code     = $paymentCode;
            $upload->folder 	     = 'Finance';
            $upload->section 	     = 'Payments';
            $upload->name 		     = $invoice->invoice_prefix.$invoice->invoice_number;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->attach 	     = 'No';
            $upload->file_mime     = $file->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      //Send payment acknowledgment message to client
      if($request->send_email == 'yes'){
         $customer = customers::single_customer($invoice->customer);
         if($customer->email){
            $mailCode = Helper::generateRandomString(20);
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
            Amount:&nbsp;<strong>'.$business->currency.number_format($request->amount).'</strong><br/>
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
            $emails->mail_from           = $business->email;
            $emails->category            = 'Invoice Payment acknowledgment';
            $emails->status              = 'Sent';
            $emails->ip 		           =  request()->ip();
            $emails->type                = 'Outgoing';
            $emails->section             = 'Payments';
            $emails->mail_to             = $to;
            $emails->created_by          = Auth::user()->user_code;
            $emails->save();
         }else{
            Session::flash('warning','The customer has no email linked to them, update the email in the customer section');
         }
		}

      //record activity
		$activity     = 'A payment has been made for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Payments';
      $action       = 'sent';
		$activityCode = $paymentCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','The payments have been added');

      return redirect()->route('finance.payments.received');
   }

   public function edit($code){
      $customers = customers::where('business_code',Auth::user()->business_code)->get();
      $paymentMethod = payment_methods::where('business_code',Auth::user()->business_code)->pluck('name','method_code')->prepend('Choose payment method','');
      $payment = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                                 ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                                 ->where('fn_invoice_payments.payment_code',$code)
                                 ->select('*','fn_invoice_payments.payment_code as payment_code','fn_invoice_payments.reference_number as reference_number')
                                 ->first();

      $invoice = invoices::where('invoice_code',$payment->invoice_code)->where('business_code',Auth::user()->business_code)->first();
      $files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

      $accounts = accounts::where('business_code',Auth::user()->business_code)->pluck('title','account_code')->prepend('Choose deposit account','');

      $currency = Wingu::business()->currency;

      return view('app.finance.payments.edit',  compact('customers','payment','invoice','files','accounts','paymentMethod','currency'));
   }

   public function update(Request $request, $code){
      $this->validate($request, array(
         'customer'=>'required',
         'amount'=>'required',
         'invoice'=>'required',
      ));

      $payment = invoice_payments::where('payment_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $invoice =  invoices::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->first();

      //check if amount has changed
      if($payment->amount != $request->amount){

         //subtract the initial edited payment and replace with new
         $remove = invoices::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->first();
         $remove->paid = $remove->paid - $payment->amount;
         $remove->save();

         $newInvoice =  invoices::where('invoice_code',$request->invoice)->where('business_code',Auth::user()->business_code)->first();

         //update invoice payment & status
         //update payment
         $currentPayment = $newInvoice->paid;
         $newPayment = $currentPayment + $request->amount;
         $newInvoice->paid = $newPayment;
         $newInvoice->balance = $newInvoice->total - $newPayment;

         //update status
         if($newPayment == $newInvoice->total || $newPayment > $newInvoice->total){
            $newInvoice->status = 1;
         }elseif($newPayment < $newInvoice->total && $newPayment != 0 ){
            $newInvoice->status = 3;
         }

         $newInvoice->save();

         //credit customer
         if($payment->amount != $request->amount && $payment->credit == 'yes' && $invoice->paid != $invoice->total) {
            //delete credit note
            //credit note
            $creditnote = creditnote::where('creditnote_code ',$payment->creditnote_code )->where('business_code',Auth::user()->business_code)->first();

            if($creditnote->status != 22){
               $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/creditnote/';

               $check_files = docs::where('file_code',$payment->creditnote_code)->count();

               if($check_files > 0){
                  $files = docs::where('file_code',$payment->creditnote_code)->get();
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

               //delete creditnote products
               creditnote_products::where('creditnote_code',$payment->creditnote_code)->delete();

               //delete creditnote plus attachment

               $creditnote->delete();

               //record activity
               $activity     = 'Credit Note #'.$creditnote->prefix.$creditnote->number.' had been deleted by '.Auth::user()->name;
               $module       = 'Credit Note';
               $section      = 'Credit Note';
               $action       = 'Delete';
               $activityCode = $payment->creditnote_code;

               Wingu::activity($activity,$module,$section,$action,$activityCode);
            }
         }

         if($payment->amount != $request->amount && $payment->credit == 'yes' && $invoice->paid > $invoice->total) {
               //update credit note
               $update = creditnote::where('business_code',Auth::user()->business_code)->where('creditnote_code',$payment->creditnote_code)->first();
               $update->student	 	   = $request->student;
               $update->total		      = $request->amount;
               $update->sub_total		= $request->amount;
               $update->business_code 	= Auth::user()->business_code;
               $update->save();

               //delete product
               $delete = creditnote_products::where('creditnote_code',$payment->creditnote_code)->delete();

               //new products
               $product 					   = new creditnote_products;
               $product->creditnote_code  = $payment->creditnote_code;
               $product->product_name	   = 'Payment credit';
               $product->quantity		   = 1;
               $product->price    		   = $request->amount;
               $product->save();
         }

         if($payment->amount != $request->amount && $payment->credit == "" && $invoice->paid > $invoice->total) {
            //create a new credit note
            //update creditnote number
            $setting = creditnote_settings::where('business_code',Auth::user()->business_code)->first();

            $creditAmount = $invoice->paid - $invoice->total;

            $creditNoteCode = Helper::generateRandomString(30);

            $credit					      = new creditnote;
            $credit->creditnote_code   = $creditNoteCode;
            $total                     = $creditAmount;
            $credit->created_by        = Auth::user()->user_code;
            $credit->customer_code     = $payment->customer_code;
            $credit->number            = $setting->number;
            $credit->prefix            = $setting->prefix;
            $credit->total		         = $total;
            $credit->balance			   = $total;
            $credit->sub_total			= $total;
            $credit->creditnote_date	= date('Y-m-d');
            $credit->status			   = 21;
            $credit->payment_code      = $code;
            $credit->business_code 		= Auth::user()->business_code;
            $credit->save();

            //products
            $product 					   = new creditnote_products;
            $product->creditnote_code  = $creditNoteCode;
            $product->product_name	   = 'Payment credit';
            $product->quantity		   = 1;
            $product->price    		   = $total;
            $product->save();

            $setting->number = $setting->number + 1;
            $setting->save();

            //update payment
            $updateCredit = invoice_payments::where('payment_code',$code)->where('business_code',Auth::user()->business_code)->first();
            $updateCredit->credited = 'yes';
            $updateCredit->creditnote_code = $creditNoteCode;;
            $updateCredit->save();
         }
      }

      // edit payment info
      if($payment->amount != $request->amount){
         $payBalance =  invoices::where('invoice_code',$request->invoice)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->first();
         $payment->amount = $request->amount;
         $payment->balance = $payBalance->total - $payBalance->paid;
      }

      $payment->bank_charges      = $request->bank_charges;
      $payment->payment_date      = $request->payment_date;
      $payment->payment_method    = $request->payment_method;
      $payment->reference_number  = $request->reference_number;
      $payment->invoice_code      = $request->invoice;
      $payment->note              = $request->note;
      $payment->account           = $request->account;
      $payment->display_in_portal = $request->display_in_portal;
      $payment->customer_code     = $request->customer;
      $payment->updated_by        = Auth::user()->user_code;
      $payment->business_code     = Auth::user()->business_code;
      $payment->payment_category  = 'Received';
      $payment->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/';

         if(!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //get attachment
         $files = $request->file('files');

         foreach($files as $file) {

            $size =  $file->getSize();

            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(30). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;
            $upload->file_code     = $code;
            $upload->folder 	     = 'Finance';
            $upload->section 	     = 'Payments';
            $upload->name 		     = $invoice->invoice_prefix.$invoice->invoice_number;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->attach 	     = 'No';
            $upload->file_mime     = $file->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      Session::flash('success','The payment has been updated');

      //record activity
      $activity     = 'A payment update has been made for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
      $module       = 'Finance';
      $section      = 'Credit Note';
      $action       = 'Delete';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      return redirect()->back();
   }

   public function retrive_client($code){
      $invoices = invoices::where('customer',$code)->where('status','!=',1)->where('business_code',Auth::user()->business_code)->get();
      return \Response::json($invoices);
   }

   public function file_delete($id){
      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/';

      $delete = docs::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      $file = $directory.$delete->file_name;

      if(File::exists($file)) {
         unlink($file);
      }

      $delete->delete();

      //record activity
      $activities = 'payment file has been deleted by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'Payment';
      $adminID = Auth::user()->user_code;
      $activityID = $id;
      $business_code = Auth::user()->business_code;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   public function download($id) {
      $file = docs::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/'.$file->file_name;
      return response()->download($path);
   }

   public function show($code){
      $details = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                  ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_payments.invoice_code')
                  ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
                  ->where('fn_invoice_payments.payment_code',$code)
                  ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
                  ->select('*','fn_invoice_payments.reference_number as transactionID','fn_invoice_payments.balance as paymentBalance','fn_invoice_payments.payment_code as invoicePaymentID','wp_business.name as businessName')
                  ->first();

      return view('app.finance.payments.show', compact('details'));
   }

   public function print($code){

      $payments = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                  ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
                  ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_payments.invoice_code')
                  ->join('wp_users','wp_users.user_code','=','fn_invoice_payments.created_by')
                  ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
                  ->select('*','fn_invoice_payments.payment_code as paymentID','fn_invoice_payments.created_at as payment_date','fn_invoice_payments.reference_number as transactionID','wp_users.name as username')
                  ->orderby('fn_invoice_payments.payment_code','desc')
                  ->get();

      $details = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                  ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_payments.invoice_code')
                  ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
                  ->where('fn_invoice_payments.payment_code',$code)
                  ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
                  ->select('*','fn_invoice_payments.reference_number as transactionID','fn_invoice_payments.balance as paymentBalance','fn_invoice_payments.payment_code as invoicePaymentID','wp_business.name as businessName')
                  ->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/receipt', compact('payments','details'));

      return $pdf->stream($details->transactionID.'.pdf');
   }

   public function mail($code){
      $details = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                  ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_invoice_payments.customer_code')
                  ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_payments.invoice_code')
                  ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
                  ->where('fn_invoice_payments.payment_code',$code)
                  ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
                  ->select('*','fn_invoice_payments.reference_number as transactionID','fn_invoice_payments.balance as paymentBalance','fn_invoice_payments.payment_code as invoicePaymentID','wp_business.name as businessName')
                  ->first();

      $contacts = contact_persons::where('customer_code',$details->customer_code)->get();

      //directory
      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/';


      //create directory if it doesn't exists
      if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
      }

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/receipt', compact('details'));

      $pdf->save($directory.$details->invoicePaymentID.'payment.pdf');

      return view('app.finance.payments.mail', compact('details','contacts'));
   }

   public function send(Request $request){
      $this->validate($request,[
            'email_from' => 'required|email',
            'send_to' 	 => 'required',
            'subject'    => 'required',
            'message'	 => 'required',
      ]);

         //creditnote information
      $payment = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
               ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
               ->where('fn_invoice_payments.payment_code',$request->paymentID)
               ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
               ->select('*','fn_invoice_payments.reference_number as transactionID','fn_invoice_payments.balance as paymentBalance','fn_invoice_payments.payment_code as invoicePaymentID','wp_business.name as businessName','fn_customers.customer_code as customer_code')
                  ->first();

         //check for email CC
         $checkcc = count(collect($request->email_cc));

         //save email
         $emails = new emails;
         $emails->message   = $request->message;
         $emails->clientID  = $payment->customer_code;
         $emails->subject   = $request->subject;
         $emails->mail_from = $request->email_from;
         $emails->category  = 'Payment Document';
         $emails->status    = 'Sent';
         $emails->ip 		 = Helper::get_client_ip();
         $emails->type      = 'Outgoing';
         $emails->section   = 'payments';
         $emails->mail_to   = $request->send_to;
         if($checkcc > 0){
               $emails->cc   	= json_encode($request->get('email_cc'));
         }
         $emails->save();

         //send email
         $subject = $request->subject;
         $content = $request->message;
         $from = $request->email_from;
         $to = $request->send_to;
         $mailID = $emails->id;
         $doctype = 'payments';
         $docID = $payment->invoicePaymentID;

         if($request->attaches == 'Yes'){
            $attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/payments/'.$payment->invoicePaymentID.'payment.pdf';
         }else{
               $attachment = 'No';
         }


         Mail::to($to)->send(new sendPayment($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

         //recorded activity
         $activities = 'Payment #'.Finance::creditnote()->prefix.$payment->creditnote_number.' has been sent to the client by '.Auth::user()->name;
         $section = 'payment';
         $type = 'Sent';
         $adminID = Auth::user()->user_code;
         $activityID = $request->paymentID;
         $business_code = Auth::user()->business_code;

         Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

         Session::flash('success','Payment Sent to client successfully');

         return redirect()->back();
   }

   public function delete($code){
      //delete payments
      $payment = invoice_payments::where('payment_code',$code)->where('business_code',Auth::user()->business_code)->first();

      //reduce payment amount
      $invoice =  invoices::where('invoice_code',$payment->invoice_code)->where('business_code',Auth::user()->business_code)->first();

      $balance = $invoice->paid - $payment->amount;
      $invoice->paid = $balance;
      $invoice->balance = $invoice->total - $invoice->paid;

      //update status
      if($invoice->balance == 0){
         $invoice->status = 1;
      }elseif($invoice->balance < $invoice->total){
         $invoice->status = 3;
      }elseif($invoice->balance == $invoice->total){
         $invoice->status = 2;
      }

      //check if credited
      if($payment->credited == 'Yes'){
         $creditnote = creditnote::where('creditnote_code',$payment->creditnote_code)->where('business_code',Auth::user()->business_code)->first();
         $creditnote->balance = $creditnote->balance + $payment->amount;
         $creditnote->status = 21;
         $creditnote->save();
         $invoice->credited = NULL;
      }

      $invoice->save();
      $payment->delete();

      //delete files
      $check = docs::where('file_code',$code)->count();

      if($check > 0){
         $files = docs::where('file_code',$code)->get();
         foreach ($files as $file) {
            $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/payments/';
            $delete = $directory.$file->file_name;
            if (File::exists($delete)) {
            unlink($delete);
            }
            $file->delete();
         }
      }

      //record activity
      $activity     = 'payment has been deleted by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Payments';
      $action       = 'Delete';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Payment successfully deleted and invoice adjusted');

      return redirect()->back();
   }
}
