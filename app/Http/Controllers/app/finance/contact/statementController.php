<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_settings;
use App\Models\wingu\Email;
use App\Mail\sendStatement;
use Session;
use Helper;
use Wingu;
use Auth;
use PDF;
use Mail;
use Finance;
use Request as Req;

class statementController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //index
   public function index($customerCode){
      $year = date('Y');
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$customerCode)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as customerCode','wp_business.business_code as business_code','wp_business.currency as symbol')
               ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('balance');
      $invoicedAmount = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('main_amount');
      $amountReceived = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('paid');
      $invoices = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.finance.contacts.view', compact('client','customerCode','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
   }

   //format
   public function convert($customerCode,$format){
      $year = date('Y');
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$customerCode)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as cid','wp_business.business_code as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('balance');
      $invoicedAmount = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('main_amount');
      $amountReceived = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->sum('paid');
      $invoices = invoices::where('customer',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/statement/statement', compact('client','customerCode','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

      if($format=='pdf'){
         return $pdf->download('statement.pdf');
      }

      if($format=='print'){
         return $pdf->stream('statement.pdf');
      }
   }

   //mail
   public function mail($customerCode){
      $year = date('Y');
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                           ->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                           ->where('fn_customers.customer_code',$customerCode)
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->select('*','fn_customers.customer_code as cid','wp_business.business_code as business_code')
                           ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->get();

      //invoices
      $invoicesBalance = invoices::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->sum('balance');
      $invoicedAmount = invoices::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->sum('main_amount');
      $amountReceived = invoices::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->sum('paid');
      $invoices = invoices::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/statement/';

      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/statement/statement', compact('client','customerCode','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

      $pdf->save($directory.$client->customer_code.'-'.$year.'.pdf');

      return view('app.finance.contacts.view', compact('client','customerCode','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
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
      $trackCode = Helper::generateRandomString(20);

      $client = customers::where('customer_code',$request->customerCode)->where('fn_customers.business_code',Auth::user()->business_code)->first();

		$emails = new Email;
		$emails->mail_code      = $trackCode;
      $emails->message        = $request->message;
		$emails->customer_code  = $request->customerCode;
      $emails->subject        = $request->subject;
      $emails->names          = $client->customer_name;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from      = Wingu::business()->primary_email;
		$emails->category       = 'Customer account statement';
		$emails->status         = 'Sent';
		$emails->ip 		      = Req::ip();
		$emails->type           = 'Outgoing';
		$emails->section        = 'Statement';
      $emails->module         = 'finance';
		$emails->mail_to        = $request->send_to;
		$emails->created_by     = Auth::user()->user_code;
		$emails->business_code  = Auth::user()->business_code;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
      $emails->save();

		//send email
		$subject = $request->subject;
		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->business_code.'" width="1" height="1" />';

		$from = $request->email_from;
		$to = $request->send_to;
      $mailCode = $trackCode;

      $year = date('Y');

		$attachment = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/statement/'.$client->customer_code.'-'.$year.'.pdf';

		Mail::to($to)->send(new sendStatement($content,$subject,$from,$mailCode,$attachment));

      //recorded activity
      $activities = Auth::user()->name.' has email statement of account to '.$client->customer_name;
      $module = 'Finance';
      $section = 'Customer statement of account';
      $action = 'Sent';
      $activityID = $mailCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      Session::flash('success','statement of account successfully sent');

      return redirect()->route('finance.customer.mail',$request->customerCode);
   }
}
