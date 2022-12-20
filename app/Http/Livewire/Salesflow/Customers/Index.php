<?php

namespace App\Http\Livewire\Salesflow\Customers;

use App\Models\finance\customer\customers;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Index extends Component
{
   use WithPagination;
   public $perPage = 30;
   public $search = '';

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $query = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code');
                     if($this->search){
                        $query->Where('customer_name','like','%'.$this->search.'%')
                        ->orWhere('fn_customers.email','like','%'.$this->search.'%')
                        ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                     }

      $contacts = $query->where('fn_customers.business_code',Auth::user()->business_code)
                     ->select('*','fn_customers.id as customerID','fn_customers.created_at as date_added','wp_business.business_code as business_code','fn_customers.business_code as business_code','fn_customers.customer_code as customerCode','fn_customers.email as customer_email')
                     ->OrderBy('fn_customers.id','DESC')
                     ->simplePaginate($this->perPage);

      return view('livewire.salesflow.customers.index', compact('contacts'));
   }
}
