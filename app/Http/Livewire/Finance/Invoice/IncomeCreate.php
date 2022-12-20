<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\income\category;
use Livewire\Component;
use Auth;
use Helper;

class IncomeCreate extends Component
{
   public $category_name;

   public function render(){
      return view('livewire.finance.invoice.income-create');
   }

   //validation rules
   protected $rules = [
      'category_name' => 'required',
   ];

   //reset fiels
   public function restFields(){
      $this->category_name = "";
   }

   //add income category
   public function AddIncomeCategory(){
      $this->validate();

      $category = new category;
      $category->category_code = Helper::generateRandomString(20);
      $category->name = $this->category_name;
      $category->business_code = Auth::user()->business_code;
      $category->created_by = Auth::user()->user_code;
      $category->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Income category added succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('ModalStore');
   }
}
