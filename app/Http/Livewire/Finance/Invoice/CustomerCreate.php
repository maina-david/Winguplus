<?php

namespace App\Http\Livewire\Finance\Invoice;
use App\Models\finance\customer\customers as clients;
use Livewire\Component;
use Auth;
use Helper;

class CustomerCreate extends Component
{
   public $customerName,$customerEmail,$customerPhonenumber;

   public function render()
   {
      return view('livewire.finance.invoice.customer-create');
   }

    //validation rules
    protected $rules = [
      'customerName' => 'required',
   ];

   //reset fiels
   public function restFields(){
      $this->customerName = "";
      $this->customerEmail = "";
      $this->customerPhonenumber = "";
   }

   //add customer
   public function AddCustomer(){
      $this->validate();

      $customer = new clients;
      $customer->customer_code = Helper::generateRandomString(20);
      $customer->customer_name = $this->customerName;
      $customer->email = $this->customerEmail;
      $customer->primary_phone_number = $this->customerPhonenumber;
      $customer->business_code = Auth::user()->business_code;
      $customer->created_by = Auth::user()->user_code;
      $customer->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Customer added succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('ModalStore');
   }

}
