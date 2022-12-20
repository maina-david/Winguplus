<?php

namespace App\Http\Livewire\Ecommerce\Customers;

use Livewire\Component;
use App\Models\finance\customer\customers;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }

   public function render()
   {
      $query = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code')
								->where('fn_customers.business_code',Auth::user()->business_code);
                        if($this->search){
                           $query->Where('customer_name','like','%'.$this->search.'%')
                           ->orWhere('fn_customers.email','like','%'.$this->search.'%')
                           ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                        }
      $contacts = $query->select('*','fn_customers.created_at as date_added','fn_customers.email as customer_email','fn_customers.primary_phone_number as phone_number')
                     ->OrderBy('fn_customers.id','DESC')
                     ->simplePaginate($this->perPage);

      return view('livewire.ecommerce.customers.index', compact('contacts'));
   }
}
