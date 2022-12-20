<?php

namespace App\Http\Livewire\Finance\Expenses;

use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_category;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Expenses extends Component
{
   public $search,$category,$month,$status;
   public $perPage = 30;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }
   
   public function render()
   {
      $query = expense::join('wp_status','wp_status.id','=','fn_expense.status')
                        ->join('wp_business','wp_business.business_code','=','fn_expense.business_code')
                        ->where('expense_type','expense')
                        ->where('fn_expense.business_code',Auth::user()->business_code);
                        if($this->search){
                           $query->Where('expense_name','like','%'.$this->search.'%')
                           ->orWhere('reference_number','like','%'.$this->search.'%');
                        }
                        if($this->category){
                           $query->Where('category',$this->category);
                        }
                        if($this->month){
                           $query->whereMonth('expense_date',$this->month);
                        }
                        if($this->status){
                           $query->where('fn_expense.status',$this->status);
                        }
      $expense = $query->select('*','fn_expense.expense_code as expenseCode','wp_status.name as statusName','fn_expense.expense_date as expense_date','wp_business.business_code as business_code','category')
                        ->orderBy('fn_expense.id','DESC')
                        ->paginate($this->perPage);

      $categories = expense_category::where('business_code',Auth::user()->business_code)->get();

      return view('livewire.finance.expenses.expenses', compact('expense','categories'));
   }
}
