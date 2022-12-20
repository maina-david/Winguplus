<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\invoice\invoices;
use Livewire\Component;
use Auth;

class Due extends Component
{
   public $page = 20;
   public $year,$search;
   public function render()
   {

      $query = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                           ->join('wp_status','wp_status.id','=','fn_invoices.status');
                           if($this->search){
                              $query->Where('customer_name','like','%'.$this->search.'%')
                              ->orWhere('fn_customers.email','like','%'.$this->search.'%')
                              ->orWhere('primary_phone_number','like','%'.$this->search.'%');
                           }
                           if($this->year){
                              $query->whereYear('invoice_date', '=', $this->year);
                           }else{
                              $query->whereYear('invoice_date', '=', date('Y'));
                           }

      $invoices = $query->where('invoice_due', '>=', date('Y-m-d'))
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->select('*','fn_invoices.invoice_code as invoiceCode','wp_status.name as statusName','wp_business.business_code as business_code')
                           ->orderby('fn_invoices.id','desc')
                           ->get();

      return view('livewire.finance.invoice.due', compact('invoices'));
   }
}

