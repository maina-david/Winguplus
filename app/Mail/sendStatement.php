<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\wingu\Email;
use App\Models\wingu\business;
use Wingu;
use Auth;

class sendStatement extends Mailable
{
   use Queueable, SerializesModels;
   public $content;
   public $subject;

   /**
    * Create a new message instance.
    *
    * @return void
    */
   public function __construct($content,$subject,$from,$mailCode,$attachment)
   {
      $this->content     = $content;
      $this->subject     = $subject;
      $this->$from       = $from;
      $this->mailCode      = $mailCode;
      $this->attachment  = $attachment;
   }

   /**
    * Build the message.
    *
    * @return $this
    */
   public function build()
   {

      $subject     = $this->subject;
      $content     = $this->content;
      $mailCode    = $this->mailCode;
      $attachment  = $this->attachment;

      $from = Wingu::business()->primary_email;
      $name = Wingu::business()->name;

      //get email info
      $email = Email::where('mail_code',$mailCode)->where('business_code',Auth::user()->business_code)->first();

      $business = business::where('business_code',Auth::user()->business_code)->first();

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

                  //attachments
                  if($attachment != 'No'){
                     $message->attach($attachment);
                  }

      return $message;
   }
}
