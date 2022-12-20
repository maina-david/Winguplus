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

class AttendanceFree extends Component
{
   public $eventCode;
   public $search;
   public $email,$phone_number,$names,$checkInID;
   public function render()
   {
      $event = events::where('event_code',$this->eventCode)->where('business_code',Auth::user()->business_code)->first();
      $query = checkin::where('event_code',$this->eventCode);
                  if($this->search){
                     $query->where('names','like','%'.$this->search.'%');
                  }
      $checkIns = $query->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.events.events.attendance-free', compact('event','checkIns'));
   }

   //rest fields
   public function restFields(){
      $this->email          = "";
      $this->phone_number   = "";
      $this->names          = "";
      $this->checkInID      = "";
   }

   //checkin
   public function check_in(){
      $this->validate([
         'names'         => 'required',
         'phone_number' => 'required',
      ]);


      //check if already checked in
      $checkEmail = checkin::where('email',$this->email)->where('event_code',$this->eventCode)->count();
      $checkPhone = checkin::where('phone_number',$this->phone_number)->where('event_code',$this->eventCode)->count();

      if($checkEmail == 0 && $checkPhone == 0){
         $checkin = new checkin;

         $checkin->business_code      = Auth::user()->business_code;
         $checkin->event_code         = $this->eventCode;
         $checkin->names              = $this->names;
         $checkin->email              = $this->email;
         $checkin->phone_number       = $this->phone_number;
         //$checkin->ticket_code        = $this->ticketCode;
         $checkin->created_by         = Auth::user()->user_code;
         $checkin->save();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Customer checked in successfully"
         ]);

         $this->restFields();

         $this->emit('popModal');
      }
   }

   //confirm delete
   public function confirm_delete($id){
      $this->checkInID = $id;
   }

   //delete
   public function delete(){
      checkin::where('business_code',Auth::user()->business_code)->where('id',$this->checkInID)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Customer removed successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }

}
