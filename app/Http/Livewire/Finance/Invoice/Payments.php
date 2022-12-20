<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\payments\payment_methods;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Payments extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $search;
   public $paymentMethod;
   public $perPage = 20;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $query = invoice_payments::join('fn_customers','fn_customers.customer_code','=','fn_invoice_payments.customer_code')
                              ->join('wp_business','wp_business.business_code','=','fn_invoice_payments.business_code')
                              ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','wp_business.business_code')
                              ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_payments.invoice_code');
                              if($this->search){
                                 $query->where('customer_name','like','%'.$this->search.'%')
                                 ->orWhere('reference_number','like','%'.$this->search.'%');
                              }
                              if($this->paymentMethod){
                                 $query->where('fn_invoice_payments.payment_method',$this->paymentMethod);
                              }
      $payments = $query->select('payment_code','reference_number','customer_name','wp_business.currency as currency','invoice_number','invoice_prefix','fn_invoice_payments.payment_method as payment_method','payment_category','creditnote_code','amount','payment_date','fn_invoice_payments.business_code as business_code')
                  ->where('fn_invoice_payments.business_code',Auth::user()->business_code)
                  ->orderby('fn_invoice_payments.id','desc')
                  ->simplePaginate($this->perPage);

      $paymentMethods = payment_methods::where('business_code',Auth::user()->business_code)->get();

      return view('livewire.finance.invoice.payments', compact('payments','paymentMethods'));
   }
}
