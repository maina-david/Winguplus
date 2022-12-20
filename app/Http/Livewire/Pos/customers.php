<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\finance\customer\customers as clients;
use Livewire\WithPagination;
use Auth;
class customers extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public function render()
   {
      $query = clients::join('wp_business','wp_business.business_code','=','fn_customers.business_code');
                        if($this->search){
                           $query->Where('customer_name','like','%'.$this->search.'%')
                           ->orWhere('fn_customers.email','like','%'.$this->search.'%')
                           ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                        }
      $contacts = $query->where('fn_customers.business_code',Auth::user()->business_code)
								->whereNull('category')
								->select('*','fn_customers.created_at as date_added','wp_business.business_code as business_code','fn_customers.business_code as business_code','fn_customers.email as customer_email','fn_customers.created_at as customer_date')
								->OrderBy('fn_customers.id','DESC')
								->simplePaginate($this->perPage);
      $count = 1;

      return view('livewire.pos.customers', compact('contacts','count'));
   }
}
