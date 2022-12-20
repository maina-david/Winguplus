<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoices;
use App\Models\finance\products\product_information;
use App\Models\events\checkin;
use App\Models\events\events;
use Livewire\Component;
use Auth;
use Wingu;

class Attendance extends Component
{
   public $eventCode;
   public $search;
   public $email,$phone_number,$names,$ticketCode,$invoiceProductId,$checkInDetails,$invoiceCode;
   public function render()
   {
      $event = events::where('event_code',$this->eventCode)->where('business_code',Auth::user()->business_code)->first();
      $query = product_information::join('fn_invoice_products','fn_invoice_products.product_code','=','fn_product_information.product_code')
                           ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
                           ->join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->join('wp_status','wp_status.id','=','fn_invoices.status');
                           if($this->search){
                              $query->where('customer_name','like','%'.$this->search.'%');
                           }
      $customers = $query->where('fn_product_information.event_code',$this->eventCode)
                           ->where('fn_product_information.business_code',Auth::user()->business_code)
                           ->orderby('fn_invoice_products.id','desc')
                           ->select('*','wp_status.id as statusID','fn_invoices.invoice_code as invoiceCode','fn_customers.customer_code as customerCode','fn_product_information.product_code as productCode')
                           ->get();

      $currency = Wingu::business()->currency;

      return view('livewire.events.events.attendance', compact('event','customers','currency'));
   }

   //rest fields
   public function restFields(){
      $this->email          = "";
      $this->phone_number   = "";
      $this->names          = "";
      $this->ticketCode     = "";
      $this->eventType      = "";
      $this->checkInDetails = "";
   }

   //get ticker information
   public function ticket_details($customerCode,$productCode,$invoice){

      $customer = customers::where('customer_code',$customerCode)->where('business_code',Auth::user()->business_code)->first();

      $this->email            = $customer->email;
      $this->phone_number     = $customer->primary_phone_number;
      $this->names            = $customer->customer_name;
      $this->ticketCode       = $productCode;
      $this->invoiceCode      = $invoice;

   }

   //paid check In
   public function paid_check_in(){
      $this->validate([
         'names'         => 'required',
         'phone_number' => 'required',
      ]);


      //check if already checked in
      $checkEmail = checkin::where('email',$this->email)->where('ticket_code',$this->ticketCode)->count();
      $checkPhone = checkin::where('phone_number',$this->phone_number)->where('ticket_code',$this->ticketCode)->count();

      if($checkEmail == 0 && $checkPhone == 0){
         $checkin = new checkin;

         $checkin->business_code      = Auth::user()->business_code;
         $checkin->event_code         = $this->eventCode;
         $checkin->names              = $this->names;
         $checkin->email              = $this->email;
         $checkin->phone_number       = $this->phone_number;
         $checkin->ticket_code        = $this->ticketCode;
         $checkin->created_by         = Auth::user()->user_code;
         $checkin->save();


         //update ticket count
         $ticket = invoice_products::where('invoice_code',$this->invoiceCode)
                        ->where('product_code',$this->ticketCode)
                        ->where('business_code',Auth::user()->business_code)
                        ->first();


         if($ticket->quantity > 1){
            if($ticket->checked_in != $ticket->quantity){
               $ticket->checked_in = $ticket->checked_in + 1;
            }
         }else{
            $ticket->checked_in = 1;
         }
         $ticket->save();

         //update invoice
         $invoice = invoices::where('invoice_code',$this->invoiceCode)->where('business_code',Auth::user()->business_code)->first();
         $invoice->delivery_status = 14;
         $invoice->delivery_date   = date('Y-m-d H:i:s');
         $invoice->save();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Customer checked in successfully"
         ]);

         $this->restFields();

         $this->emit('popModal');

      }else{
         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"Customer already checked in"
         ]);

         $this->restFields();

         $this->emit('popModal');
      }
   }

   //checkin detail
   public function check_in_details($productCode){
      $getInfo = checkin::where('ticket_code',$productCode)
                     ->where('event_code',$this->eventCode)
                     ->where('business_code',Auth::user()->business_code)
                     ->orderby('id','desc')
                     ->get();
      $this->checkInDetails = $getInfo;
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }
}
