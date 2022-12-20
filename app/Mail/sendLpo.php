<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\wingu\file_manager  as documents;
use App\Models\wingu\business;
use App\Models\wingu\Email;
use Wingu;
use Auth;

class sendLpo extends Mailable
{
   use Queueable, SerializesModels;
   public $content;
   public $subject;

   /**
    * Create a new message instance.
    *
    * @return void
    */
   public function __construct($content,$subject,$from,$mailCode,$docID,$doctype,$attachment)
   {
      $this->content     = $content;
      $this->subject     = $subject;
      $this->$from       = $from;
      $this->mailCode    = $mailCode;
      $this->docID       = $docID; //id of eithe the estimate,invoice
      $this->doctype     = $doctype;
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
      $content    = $this->content;
      $doctype    = $this->doctype;
      $mailCode   = $this->mailCode;
      $docID      = $this->docID;
      $attachment      = $this->attachment;

      $from = Wingu::business()->email;
      $name = Wingu::business()->name;

      $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/purchase-order/';

      //get email info
      $email = Email::where('mail_code',$mailCode)->first();

      //get attachments
      $checkfiles = documents::where('file_code',$docID)
                     ->where('attach','Yes')
                     ->where('business_code',Auth::user()->business_code)
                     ->count();

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
                  $message->attach($attachment);

                  if($checkfiles > 0){
                     $files = documents::where('file_code',$docID)
                              ->where('attach','Yes')
                              ->where('business_code',Auth::user()->business_code)
                              ->get();
                     foreach ($files as $attach) {
                        $message->attach($path.$attach->file_name);// attach each file
                     }
                  }
      return $message;
   }
}
