<?php

namespace App\Http\Livewire\Events\Events;

use App\Helpers\Finance;
use App\Mail\sendMessage;
use App\Mail\sendTicket;
use App\Models\finance\customer\address;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\invoice\invoices;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\wingu\Email;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;
use DB;
use Illuminate\Support\Facades\Mail;

class Sold extends Component
{
   public $eventCode;
   public $member_type,$customer,$ticket,$quantity,$customer_name,$email,$phone_number,$status,$payment_link,$amount_paid,$transaction_number,$payment_method;

   public function render()
   {
      $tickets = product_information::join('fn_invoice_products','fn_invoice_products.product_code','=','fn_product_information.product_code')
                        ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
                        ->where('fn_invoices.status',1)
                        ->groupby('fn_product_information.product_code')
                        ->where('fn_product_information.event_code',$this->eventCode)
                        ->where('fn_product_information.business_code',Auth::user()->business_code)
                        ->select('fn_product_information.product_code as productCode','fn_invoice_products.selling_price as selling_price','fn_product_information.product_name as product_name',DB::raw('SUM(total) as total_sales'))
                        ->orderby('fn_invoice_products.id','desc')
                        ->get();
      $currency = Wingu::business()->currency;

      $ticketItems = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                     ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                     ->where('event_code',$this->eventCode)
                     ->where('active','Yes')
                     ->where('fn_product_information.business_code',Auth::user()->business_code)
                     ->select('fn_product_information.product_code as product_code','selling_price','product_name','track_inventory','current_stock')
                     ->orderby('fn_product_information.id','desc')
                     ->get();

      $customers = customers::where('fn_customers.business_code',Auth::user()->business_code)
                        ->select('customer_code','customer_name')
                        ->orderBy('fn_customers.id','DESC')
                        ->get();

      return view('livewire.events.events.sold', compact('tickets','currency','ticketItems','customers'));
   }

   public function resetField(){
      $this->member_type   = "";
      $this->customer      = "";
      $this->ticket        = "";
      $this->quantity      = "";
      $this->customer_name = "";
      $this->email         = "";
      $this->phone_number  = "";
      $this->status        = "";
      $this->payment_link  = "";
      $this->amount_paid  = "";
      $this->transaction_number  = "";
      $this->payment_method  = "";
   }

   public function sell_ticket(){
      if($this->member_type == 'new'){
         $this->validate([
            'customer_name' => 'required',
            'email'         => 'required',
            'phone_number'  => 'required',
         ]);

         $customerCode = Helper::generateRandomString(30);

         //create use if
         $user = new customers;
         $user->customer_code        = $customerCode;
         $user->customer_name        = $this->customer_name;
         $user->email                = $this->email;
         $user->primary_phone_number = $this->phone_number;
         $user->business_code        = Auth::user()->business_code;
         $user->created_by           = Auth::user()->user_code;
         $user->save();

         //save address
         $address = new address;
         $address->customer_code = $customerCode;
         $address->bill_country  = 'Kenya';
         $address->business_code = Auth::user()->business_code;
         $address->save();

         $customer = $customerCode;

      }else{
         $this->validate([
            'customer' => 'required',
            'quantity' => 'required',
            'ticket'   => 'required',
         ]);

         $customer = $this->customer;
      }

      if($this->status == 3){
         $this->validate([
            'amount_paid' => 'required'
         ]);
      }

      $date = date('Y-m-d');

      //create invoice
		$invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		$code = Helper::generateRandomString(8);

      $ticket = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                           ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                           ->where('fn_product_information.product_code',$this->ticket)
                           ->select('fn_product_information.product_code as product_code','selling_price','product_name','current_stock','track_inventory')
                           ->first();

      //dd($ticket);

      if($ticket->track_inventory == 'Yes'){
         if($ticket->current_stock <= 0){
            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
               'type'=>'warning',
               'message'=>"This tickets are sold out"
            ]);

            $this->resetField();

            $this->emit('popModal');
         }
      }


      if($this->status == 1){
         $main_amount = $ticket->selling_price * $this->quantity;
         $subtotal    = $main_amount;
         $total       = $main_amount;
         $balance     = 0;
      }else{
         $main_amount = $this->amount_paid;
         $paidAmount  = $this->amount_paid;
         $subtotal    = $ticket->selling_price * $this->quantity;
         $total       = $ticket->selling_price * $this->quantity;
         $balance     = $main_amount - $paidAmount;

         if($balance < 0){
            $balance = 0;
         }
      }


		//store invoice
		$store					    = new invoices;
      $store->created_by		 = Auth::user()->user_code;
		$store->customer   	 	 = $customer ;
		$store->invoice_title	 = 'Ticket order #'.$code;
		$store->income_category  = 'tickets';
		$store->invoice_number   = $invoiceSettings->number + 1;
		$store->invoice_prefix   = $invoiceSettings->prefix;
		$store->invoice_date	    = $date;
		$store->invoice_due	    = $date;
		$store->invoice_type		 = 'Event Manager';
      $store->is_ticket  		 = 'Yes';

		$store->invoice_code 	 = $code;
		$store->business_code 	 = Auth::user()->business_code;
      $store->main_amount      = $total;
		$store->discount         = 0;
		$store->total		       = $total;
      if($this->status == 1){
         $store->status  		 = 1;
         $store->balance       = $balance;
         $store->paid    	    = $total;
      }elseif($this->status == 3){
         $store->status  		 = 3;
      }else{
         $store->balance		 = $total;
         $store->paid    	    = 0;
         $store->status  		 = 2;
      }
		$store->sub_total	       = $total;
		$store->tax_value	       = 0;
      $store->tax_rate	       = 0;
		$store->save();


      $product 					= new invoice_products;
      $product->invoice_code  = $code;
      $product->product_code	= $this->ticket;
      $product->product_name  = $ticket->product_name;
      $product->quantity		= $this->quantity;
      $product->discount		= 0;
      $product->tax_rate		= 0;
      $product->tax_value		= 0;
      $product->total_amount  = $total;
      $product->main_amount   = $total;
      $product->sub_total  	= $subtotal;
      $product->selling_price = $ticket->selling_price;
      $product->business_code = Auth::user()->business_code;
      $product->category      = 'Ticket';
      $product->event_code    = $this->eventCode;
      $product->save();

		//invoice setting
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

      //reduce inventory
      if($ticket->track_inventory == 'Yes'){
         $inventory = product_inventory::where('product_code',$this->ticket)->where('business_code',Auth::user()->business_code)->first();
         if($inventory->current_stock > 0){
            $balance = $inventory->current_stock - $this->quantity;
         }else{
            $balance = 0;
         }
         $inventory->current_stock = $balance;
         $inventory->save();
      }

      if($this->status == 1){

         $mailCode = Helper::generateRandomString(20);
         $customerInfo = customers::single_customer($customer);
         $subject = 'Ticket order #'.$code;
         $to = $customerInfo->email;

         $content = '<span style="font-size: 12pt;">Hello '.$customerInfo->customer_name.'</span><br/><br/>
         Thank you for the payment. Find the payment details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         Date:&nbsp;<strong>'.date('jS F, Y', strtotime($date)).'</strong><br/>
         Ticket / Order Number:&nbsp;<span style="font-size: 12pt;"><strong>#'.$code.'</strong><br/><br/></span>
         -------------------------------------------------
         <br/><br/>
         We are looking forward working with you.<br/><img src="'.url('/').'/track/email/'.$mailCode.'" width="1" height="1">';

         Mail::to($to)->send(new sendMessage($content,$subject));

         //save email
         $emails = new Email;
         $emails->mail_code           = $mailCode;
         $emails->message             = $content;
         $emails->business_code       = Auth::user()->business_code;
         $emails->client_code         = $customer;
         $emails->subject             = $subject;
         $emails->mail_from           = 'noreply@winguplus.com';
         $emails->category            = 'Ticket Payment acknowledgment';
         $emails->status              = 'Sent';
         $emails->ip 		           =  request()->ip();
         $emails->type                = 'Outgoing';
         $emails->section             = 'Payments';
         $emails->mail_to             = $to;
         $emails->created_by          = Auth::user()->user_code;
         $emails->save();

         //send ticket
         $customer = customers::where('customer_code',$customer)->where('business_code',Auth::user()->business_code)->first();

         Mail::to($to)->send(new sendTicket($this->ticket,$this->eventCode));

      }

      if($this->status == 1 || $this->status == 3){
         //record payment
         $paymentCode = Helper::generateRandomString(20);
         $pay = new invoice_payments;
         $pay->payment_code     = $paymentCode;
         $pay->amount           = $total;
         $pay->balance          = $balance;
         $pay->reference_number = $this->transaction_number;
         $pay->payment_method   = $this->payment_method;
         $pay->payment_date     = $date;
         $pay->invoice_code     = $code;
         $pay->created_by       = Auth::user()->user_code;
         $pay->business_code    = Auth::user()->business_code;
         $pay->customer_code    = $customer;
         $pay->payment_category = 'Received';
         $pay->save();
      }

      // if($this->payment_link == 'send_link'){
      //    $userContent = '<h4>Hello, '.$user->name.'</h4><p>Thank you for creating your account with us. Managing your business has never gotten easier.We have a powerful product suite to help you manage your business with ease. <p><p>To activate your '.$appNames.' account, please click the link below within the next 30 days.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><center><a href="'.route('account.verify',$token).'" target="_blank">Confirm Account</a></center></td></tr></tbody></table></td></tr></tbody></table><p>If you have any questions regarding your '.$appNames.' account, please contact us at '.$appEmail.' Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to '.$appNames.'<sup>TM</sup>.</p><p><p>Regards<br>'.$appNames.' Team<br><a href="'.$appWebsiteLink.'">'.$appLinkName.'</a></p><hr><small>If you’re having trouble clicking the "Confirm Account" button, copy and paste the URL below into your web browser: <a href="'.route('account.verify',$token).'">'.route('account.verify',$token).'</a></small>';
      // }

      //recorded activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>sold</b> a ticket  <a href="'.route('finance.invoice.show',$code).'">'.$ticket->product_name.'</a>';
      $module       = 'Finance';
      $section      = 'Tickets';
      $action       = 'Invoice';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Ticket sale recorded successfully"
      ]);

      $this->resetField();

      $this->emit('popModal');
   }


}
