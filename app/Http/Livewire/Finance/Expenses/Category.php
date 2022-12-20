<?php

namespace App\Http\Livewire\Finance\Expenses;

use App\Models\finance\expense\expense_category;
use Livewire\Component;
use Auth;
use Wingu;
use Helper;

class Category extends Component
{
   protected $paginationTheme = 'bootstrap';

   public $name,$description,$categoryCode,$editMode = "false";
   public $perPage = 20;
   

   public function render()
   {
      $category = expense_category::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->paginate($this->perPage);;

      return view('livewire.finance.expenses.category', compact('category'));
   }

   //rest value
   public function reset_values(){
      $this->name = "";
      $this->description = "";
      $this->categoryCode = "";
      $this->editMode = "false";
   }

   public function save_category(){
      $this->validate([
         'name' => 'required',
      ]);

      $category = new expense_category;
      $category->category_code = Helper::generateRandomString(30);
      $category->name = $this->name;
      $category->description = $this->description;
      $category->created_by = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();

      //recorded activity
		$activity     = 'A new expense category has been added by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Expense Category';
      $action       = 'Create';
		$activityCode = $category->category_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Category added successfully'
      ]);

      $this->emit('popModal');

      $this->reset_values();

   }

   //edit
   public function edit($code){
      $edit = expense_category::where('category_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->name = $edit->name;
      $this->description = $edit->description;
      $this->editMode = 'true';
      $this->categoryCode = $code;
   }

   //update
   public function update_category(){
      $this->validate([
         'name' => 'required',
      ]);

      $category = expense_category::where('category_code',$this->categoryCode)->where('business_code',Auth::user()->business_code)->first();
      $category->name = $this->name;
      $category->description = $this->description;
      $category->updated_by = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();

      //recorded activity
		$activity     = Auth::user()->name.' has updated expense category';
		$module       = 'Finance';
		$section      = 'Expense Category';
      $action       = 'Edit';
		$activityCode = $category->category_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Category updated successfully'
      ]);

      $this->emit('popModal');

      $this->reset_values();
   }

   //remove
   public function remove($code){
      $this->categoryCode = $code;
   }

   //close
   public function close(){
      $this->emit('popModal');

      $this->reset_values();
   }

   public function delete(){
      $delete = expense_category::where('category_code',$this->categoryCode)->where('business_code',Auth::user()->business_code)->first();

      //records activity
      $activity     =  Auth::user()->name.' Has deleted <b>'.$delete->name.'</b> expense category';
		$module       = 'Finance';
		$section      = 'Expense Category';
      $action       = 'Delete';
		$activityCode = $this->categoryCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Category added successfully'
      ]);

      $this->emit('popModal');

      $this->reset_values();
   }

}
