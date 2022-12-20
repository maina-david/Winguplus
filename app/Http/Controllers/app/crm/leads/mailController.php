<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\wingu\file_manager as docs;
use App\Mail\sendCrm;
use App\Models\wingu\Email;
use Mail;
use Session;
use Auth;
use Helper;
use Wingu;
use Crm;
class mailController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   public function index($code){
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->where('category','Lead')->first();
      $mails = Email::where('client_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->paginate(13);

      return view('app.crm.leads.show', compact('lead','code','mails'));
   }

   //compose mail
   public function send($code){
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->where('category','Lead')->first();
      $files = docs::where('file_code',$code)
                     ->where('business_code',Auth::user()->business_code)
                     ->orderby('id','desc')
                     ->get();

      return view('app.crm.leads.show', compact('lead','code','files'));
   }

   //send mail
   public function store(Request $request){
      $this->validate($request, [
         'email' => 'required',
         'message' => 'required',
         'customer_code' => 'required',
         'subject' => 'required',
      ]);

      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$request->customer_code)->first();

      $checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','customer')->where('file_code',$request->customer_code)->where('business_code',Auth::user()->business_code)->get();
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
			$chage = docs::where('section','leads')->where('file_code',$request->customer_code)->where('business_code',Auth::user()->business_code)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('business_code',Auth::user()->business_code)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
      $checkcc = count(collect($request->email_cc));

      //save email
		$trackCode = Helper::generateRandomString(30);
      $emails = new emails;
      $emails->mail_code = $trackCode;
      $emails->message   = $request->message;
      $emails->names   = $lead->customer_name;
      $emails->client_code	    = $request->customer_code;
      $emails->subject   = $request->subject;
      $emails->mail_from = Wingu::business()->email;
      $emails->category  = 'customer';
      $emails->ip 		 = Helper::get_client_ip();
      $emails->type      = 'Outgoing';
      $emails->section   = 'customer';
      $emails->mail_to   = $request->email;
      $emails->created_by    = Auth::user()->user_code;
      $emails->business_code = Auth::user()->business_code;
      if($checkcc > 0){
			$emails->cc  = json_encode($request->get('email_cc'));
		}
      $emails->save();

		//send email

      $mailID = $emails->id;
      $parentID = $request->customer_code;
		$folder = 'customer/'.$lead->reference_number;
      $subject = $request->subject;
      $to      = $request->email;
      $from    = Wingu::business()->primary_email;
      $content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->business_code.'/'.$emails->id.'" width="1" height="1" />';


      Mail::to($to)->send(new sendCrm($content,$subject,$from,$mailID,$parentID,$folder));

      $updateEmails = emails::where('id',$emails->id)->where('business_code',Auth::user()->business_code)->first();
      $updateEmails->status = 'Sent';
      $updateEmails->save();

      //record activity
		// $activities = Auth::user()->name.' has sent an email to '.$lead->customer_name;
		// $section = 'crm';
		// $type = 'Leads';
		// $adminID = Auth::user()->user_code;
		// $activityID = $emails->id;
		// $business_code = Auth::user()->business_code;

      // Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','Email successfully sent');

      return redirect()->route('crm.leads.mail',$request->customer_code);
   }

   //mail details
   public function details($id,$customer_code){
      $lead = customers::where('business_code',Auth::user()->business_code)->where('id',$customer_code)->where('category','Lead')->first();
      $mail = emails::where('client_code	',$customer_code)->where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      return view('app.crm.leads.show', compact('lead','customer_code','mail'));
   }
}
