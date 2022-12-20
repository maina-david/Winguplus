<?php

namespace App\Http\Livewire\Crm\Leads;

use App\Models\finance\customer\customers;
use Livewire\Component;
use Auth;

class Canvas extends Component
{
   public $perPage = 30;
   public $search;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render(){
      $query = customers::where('fn_customers.business_code',Auth::user()->business_code)
                     ->where('category','Lead');
                     if($this->search){
                        $query->Where('customer_name','like','%'.$this->search.'%')
                        ->orWhere('email','like','%'.$this->search.'%')
                        ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                     }
      $leads = $query->OrderBy('fn_customers.id','DESC')
                  ->paginate($this->perPage);

      return view('livewire.crm.leads.canvas', compact('leads'));
   }
}
