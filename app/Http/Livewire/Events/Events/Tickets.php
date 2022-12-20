<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\finance\invoice\invoice_products;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use App\Models\wingu\file_manager;
use Livewire\Component;
use Helper;
use Auth;
use Wingu;
use File;
class Tickets extends Component
{
   public $eventCode,$ticket_name,$price,$qty,$status,$description,$start_date,$due_date,$editCode,$track_ticket_quantity;

   public function render()
   {
      $tickets = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                        ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                        ->where('event_code',$this->eventCode)
                        ->where('fn_product_information.business_code',Auth::user()->business_code)
                        ->orderby('fn_product_information.id','desc')
                        ->get();

      $currency = Wingu::business()->currency;

      return view('livewire.events.events.tickets', compact('tickets','currency'));
   }

   //reset
   public function restFields(){
      $this->ticket_name = "";
      $this->description = "";
      $this->status      = "";
      $this->start_date  = "";
      $this->due_date    = "";
      $this->price       = "";
      $this->qty         = "";
      $this->editCode    = "";
      $this->track_ticket_quantity = "";
   }

   //add ticket
   public function add_ticket(){
      $this->validate([
         'ticket_name' => 'required',
         'start_date'  => 'required',
         'price'       => 'required',
         'track_ticket_quantity' => 'required',
      ]);

      $productCode = Helper::generateRandomString(20);

      $check = product_information::where('product_name',$this->ticket_name)->where('business_code',Auth::user()->business_code)->count();

      $ticket = new product_information;
      $ticket->sku_code = Helper::generateRandomString(9);
      $ticket->business_code = Auth::user()->business_code;
      $ticket->created_by = Auth::user()->user_code;
      $ticket->product_name = $this->ticket_name;
      $ticket->description = $this->description;
      $ticket->event_code = $this->eventCode;
      $ticket->product_code = $productCode;
      $ticket->active            = $this->status;
      $ticket->event_start_date = $this->start_date;
      $ticket->event_due_date   = $this->due_date;
      $ticket->track_inventory = $this->track_ticket_quantity;
      $ticket->type = 'ticket';
      if($check > 1) {
         $ticket->url = Helper::seoUrl($this->ticket_name).'-'.Helper::generateRandomString(4);
      }else{
         $ticket->url = Helper::seoUrl($this->ticket_name);
      }
      $ticket->save();

      //product price
      $product_price = new product_price;
      $product_price->product_code = $productCode;
      $product_price->selling_price = $this->price;
      $product_price->default_price = 'Yes';
      $product_price->business_code = Auth::user()->business_code;
      $product_price->created_by = Auth::user()->user_code;
      $product_price->save();

      //product inventory
      $product_inventory = new product_inventory;
      $product_inventory->product_code = $productCode;
      $product_inventory->current_stock = $this->qty;
      $product_inventory->default_inventory = 'Yes';
      $product_inventory->business_code = Auth::user()->business_code;
      $product_inventory->created_by = Auth::user()->user_code;
      $product_inventory->save();

      //recorded activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new Ticket <a href="'.route('events.tickets',$productCode).'">'.$this->ticket_name.'</a>';
      $module       = 'Event Manager';
      $section      = 'Tickets';
      $action       = 'Create';
      $activityCode = $productCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Ticket added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit
   public function edit($code){
      $this->editCode = $code;
      $edit = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                  ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                  ->where('fn_product_information.product_code',$code)
                  ->where('fn_product_information.business_code',Auth::user()->business_code)
                  ->first();

      $this->ticket_name = $edit->product_name;
      $this->description = $edit->description;
      $this->eventCode   = $edit->event_code;
      $this->status      = $edit->active;
      $this->start_date  = $edit->event_start_date;
      $this->due_date    = $edit->event_due_date;
      $this->price       = $edit->selling_price;
      $this->qty         = $edit->current_stock;
      $this->track_ticket_quantity = $edit->track_inventory;
   }

   //update
   public function update(){
      $this->validate([
         'ticket_name' => 'required',
         'start_date'  => 'required',
         'price'       => 'required',
         'track_ticket_quantity' => 'required',
      ]);

      $ticket = product_information::where('product_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();
      $ticket->product_name     = $this->ticket_name;
      $ticket->description      = $this->description;
      $ticket->event_code       = $this->eventCode;
      $ticket->active           = $this->status;
      $ticket->event_start_date = $this->start_date;
      $ticket->event_due_date   = $this->due_date;
      $ticket->track_inventory  = $this->track_ticket_quantity;
      $ticket->updated_by       = Auth::user()->user_code;
      $ticket->save();

      //product price
      $product_price = product_price::where('product_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();
      $product_price->selling_price = $this->price;
      $product_price->updated_by = Auth::user()->user_code;
      $product_price->save();

      //product inventory
      $product_inventory = product_inventory::where('product_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();
      $product_inventory->current_stock = $this->qty;
      $product_inventory->updated_by = Auth::user()->user_code;
      $product_inventory->save();

      //recorded activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> Ticket #<a href="'.route('events.tickets',$this->editCode).'">'.$this->ticket_name.'</a>';
      $module       = 'Event Manager';
      $section      = 'Tickets';
      $action       = 'Create';
      $activityCode = $this->editCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Ticket updated successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //delete confirmation
   public function confirm_delete($code){
      $this->editCode = $code;
   }

   //delete
   public function delete(){
      //check product in invoice
      $invoice = invoice_products::where('product_code',$this->editCode)->count();
      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('file_code',$this->editCode)->where('business_code', Auth::user()->business_code)->count();

         if($check_image > 0){
            //directory
            $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/products/';
            $images = file_manager::where('file_code',$this->editCode)->where('business_code', Auth::user()->business_code)->get();
            foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
            }
         }

         $ticket = product_information::where('product_code',$this->editCode)->where('business_code', Auth::user()->business_code)->first();

         product_inventory::where('product_code',$this->editCode)->where('business_code', Auth::user()->business_code)->delete();

         //delete categories
         product_category_product_information::where('product',$this->editCode)->delete();

         //delete price
         product_price::where('product_code',$this->editCode)->where('business_code',Auth::user()->business_code)->delete();

         //recorded activity
         $activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> Ticket #<a href="#">'.$ticket->product_name.'</a>';
         $module       = 'Event Manager';
         $section      = 'Tickets';
         $action       = 'Delete';
         $activityCode = $this->editCode;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

         $ticket->delete();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Ticket successfully deleted!"
         ]);

         $this->restFields();

         $this->emit('popModal');

      }else{
         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"You have recorded transactions for this ticket. Hence, this product cannot be deleted."
         ]);

         $this->restFields();

         $this->emit('popModal');
      }
   }

   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }
}
