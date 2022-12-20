<?php

namespace App\Mail;

use App\Models\wingu\business;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\wingu\file_manager  as documents;
use App\Models\wingu\Email;
use Auth;
use Wingu;
class sendQuotes extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $subject;

    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($content,$subject,$from,$mailID,$docID,$attachment)
    {
        $this->content     = $content;
        $this->subject     = $subject;
        $this->$from       = $from;
        $this->mailID      = $mailID;
        $this->docID       = $docID; //id of eithe the estimate,invoice
        $this->attachment  = $attachment;
    }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build()
   {

      $subject    = $this->subject;
      $from       = $this->from;
      $content    = $this->content;
      $mailID     = $this->mailID;
      $docID      = $this->docID;
      $attachment = $this->attachment;
      $business = business::join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
      ->where('wp_business.business_code',Auth::user()->business_code)
      ->select('*','wp_business.business_code as business_code','wp_business.name as businessName')
      ->first();

      $from = $business->email;
      $name = $business->businessName;

      $path = base_path().'/public/businesses/'.$business->business_code.'/finance/quotes/';

      //get email info
      $email = Email::where('mail_code',$mailID)->where('business_code',Auth::user()->business_code)->first();

      //get attachments
      $checkfiles = documents::where('file_code',$docID)
      ->where('business_code',Auth::user()->business_code)
      ->count();


        $message = $this->view('email.template01', compact('content','subject','business'))
                    ->from($from, $name)
                    ->subject($subject);

                    //email cc's
                    if ($email->cc != ""){
                        $data = json_decode($email->cc, TRUE);
                        for($i=0; $i < count($data); $i++ ) {
                            $message->cc($data[$i]);
                        }
                    }

                    //email bcc
                    if($business->bcc != ""){
                        $message->bcc($business->bcc,'Finance');
                    }


                    //attachments
                    if($attachment != 'No'){
                        $message->attach($attachment);
                    }

                    if($checkfiles > 0){
                     $files = documents::where('file_code',$docID)
                     ->where('business_code',Auth::user()->business_code)
                     ->get();
                     foreach ($files as $attach) {
                        $message->attach($path.$attach->file_name);// attach each file
                     }
                    }
        return $message;
    }
}
