<?php

namespace App\Http\Livewire\Finance\Customers;

use Livewire\Component;
use App\Models\finance\customer\customers;
use Auth;
class Index extends Component
{
   public $perPage = 10;
   public $search = '';
   public $balance;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }

   public function render()
   {
      if($this->balance){

         $query = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                           ->join('fn_invoices','fn_invoices.customer','=','fn_customers.customer_code')
                           ->where('balance','!=',0)
                           ->where('fn_customers.business_code',Auth::user()->business_code);
         $contacts = $query->groupBy('fn_invoices.customer')
                           ->select('*','fn_customers.created_at as date_added','wp_business.business_code as business_code','fn_customers.business_code as business_code','fn_customers.customer_code as customerCode','fn_customers.email as customer_email','wp_business.currency as currency')
                           ->OrderBy('fn_customers.id','DESC')
                           ->simplePaginate($this->perPage);
      }else{
         $query = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code');
                     if($this->search){
                        $query->Where('customer_name','like','%'.$this->search.'%')
                        ->orWhere('fn_customers.email','like','%'.$this->search.'%')
                        ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                     }

         $contacts = $query->where('fn_customers.business_code',Auth::user()->business_code)
                        ->select('*','fn_customers.id as customerID','fn_customers.created_at as date_added','wp_business.business_code as business_code','fn_customers.business_code as business_code','fn_customers.customer_code as customerCode','fn_customers.email as customer_email')
                        ->OrderBy('fn_customers.id','DESC')
                        ->paginate($this->perPage);
      }
      return view('livewire.finance.customers.index', compact('contacts'));
   }
}
