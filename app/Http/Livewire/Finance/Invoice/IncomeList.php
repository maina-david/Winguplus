<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\income\category;
use Livewire\Component;
use Auth;
use Helper;

class IncomeList extends Component
{
   public $category_name;
   public $incomeCode;
   public $editIncome;
   
   protected $listeners = ['refreshComponent'=>'render'];

   public function render()
   {
      $incomeCategory = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.finance.invoice.income-list', compact('incomeCategory'));
   }
}
