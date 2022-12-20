<?php

namespace App\Mail;

use App\Models\finance\products\product_information;
use App\Models\wingucrowd\events;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class sendTicket extends Mailable
{
   use Queueable, SerializesModels;
   public $content;
   public $subject;

   /**
    * Create a new message instance.
    *
    * @return void
    */
   public function __construct($productCode,$eventCode)
   {
      $this->productCode = $productCode;
      $this->eventCode = $eventCode;
   }

   /**
    * Build the message.
    *
    * @return $this
    */
   public function build()
   {
      $eventCode = $this->eventCode;
      $productCode = $this->productCode;
      $from = 'notification@winguplus.com';
      $name = 'winguPlus';
      $subject = 'Event ticket';
      $ticket  = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $event = events::where('event_code',$eventCode)->where('business_code',Auth::user()->business_code)->first();
      $link = route('wingu.ticket.details',$productCode);

      return $this->view('email.tickets.template2', compact('event','ticket','link'))->from($from, $name)->subject($subject);
   }
}
