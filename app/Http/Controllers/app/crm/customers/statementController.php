<?php

namespace App\Http\Controllers\app\crm\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_settings;
use App\Models\crm\emails;
use App\Mail\sendStatement;
use Session;
use Helper;
use Wingu;
use Auth;
use PDF;
use Mail;
use Finance;

class statementController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //index
   public function index($code){
      $year = date('Y');
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$code)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','wp_business.business_code as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.crm.customers.view', compact('client','code','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
   }

   //pdf
   public function pdf($code){
      $year = date('Y');
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                        ->where('fn_customers.customer_code',$code)
                        ->where('fn_customers.business_code',Auth::user()->business_code)
                        ->select('*','fn_customers.customer_code as cid','wp_business.business_code as business_code')
                        ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      $pdf = PDF::loadView('templates/'.Wingu::template($client->template_code)->template_name.'/statement/statement', compact('client','code','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

		return $pdf->download('statement.pdf');
   }

   
   //mail
   public function mail($id){
      $year = date('Y');
      $code = $id;
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                        ->where('fn_customers.customer_code',$id)
                        ->where('fn_customers.business_code',Auth::user()->business_code)
                        ->select('*','fn_customers.customer_code as cid','wp_business.business_code as business_code')
                        ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/statement/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/statement/statement', compact('client','code','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

      $pdf->save($directory.$client->customer_code.'.pdf');

      return view('app.crm.customers.view', compact('client','code','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
   }

   //send
   public function send(Request $request){
      $this->validate($request,[
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
      ]);

      //check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
      $trackCode = Helper::generateRandomString(30);

      $client = customers::where('customer_code',$request->customer_code)->where('business_code',Auth::user()->business_code)->first();

		$emails = new emails;
      $emails->mail_code      = $trackCode;
		$emails->message        = $request->message;
		$emails->client_code    = $request->customer_code;
      $emails->subject        = $request->subject;
      $emails->names          = $client->customer_name;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from      = Wingu::business()->primary_email;
		$emails->category       = 'Customer statement';
		$emails->status         = 'Sent';
		$emails->ip 		      = Helper::get_client_ip();
		$emails->type           = 'Outgoing';
		$emails->section        = 'Statement';
		$emails->mail_to        = $request->send_to;
		$emails->created_by     = Auth::user()->user_code;
		$emails->business_code  = Auth::user()->business_code;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
      $emails->save();

		//send email
		$subject = $request->subject;
		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->business_code.'/'.$emails->id.'" width="1" height="1" />';

		$from = $request->email_from;
		$to = $request->send_to;
      $mailID = $emails->id;

      $year = date('Y');

		$attachment = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/statement/'.$client->customer_code.'-'.$year.'.pdf';

		Mail::to($to)->send(new sendStatement($content,$subject,$from,$mailID,$attachment));

		//recorord activity
		$activities = Auth::user()->name.' has email statement of account to '.$client->customer_name;
		$section    = 'Statement of account';
		$type       = 'Sent';
		$adminID    = Auth::user()->id;
		$activityID = $emails->id;
		$business_code = Auth::user()->business_code;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','statement of account successfully sent');

      return redirect()->route('crm.customer.mail',$request->customer_code);
   }
}


