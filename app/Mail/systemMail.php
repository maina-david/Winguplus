<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class systemMail extends Mailable
{
   use Queueable, SerializesModels;
   public $content;
   public $subject; 

   /**
    * Create a new message instance.  
    * 
    * @return void
    */
   public function __construct($content,$subject)
   {
      $this->content = $content;
      $this->subject = $subject;
   }

   /**
    * Build the message.
    *
    * @return $this
    */ 
   public function build()
   {
      $subject = $this->subject;
      $content = $this->content;
      $from = 'noreply@winguplus.com';
      $name = 'winguPlus';
      return $this->view('email.system_mail', compact('content'))->from($from, $name)->subject($subject);
   }
}
