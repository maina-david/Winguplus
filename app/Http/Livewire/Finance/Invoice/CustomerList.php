<?php

namespace App\Http\Livewire\Finance\Invoice;
use App\Models\finance\customer\customers as clients;
use Livewire\Component;
use Auth;
class CustomerList extends Component
{
   protected $listeners = ['refreshComponent'=>'render'];
   public $editCustomer;
   public $customerCode;

   public function render()
   {
      $clients = clients::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
      
      return view('livewire.finance.invoice.customer-list', compact('clients'));
   }
}
