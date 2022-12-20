<?php

namespace App\Http\Livewire\Salesflow\Customers;

use App\Models\finance\customer\groups as CustomerGroups;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;

class Groups extends Component
{

   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $name;
   public $updateMode = false;
   public $categoryID = '';

   protected $rules = [
      'name' => 'required',
   ];

   public function updatingSearch()
   {
      $this->resetPage();
   }

   //reset fiels
   public function restFields(){
      $this->name = "";
   }

   public function render()
   {
      $groups = CustomerGroups::where('business_code',Auth::user()->business_code)->orderby('id','desc')->simplePaginate(20);

      return view('livewire.salesflow.customers.groups', compact('groups'));
   }

   //store
   public function store(){
      $this->validate();

      $group = new CustomerGroups;
      $group->name = $this->name;
      $group->business_code = Auth::user()->business_code;
      $group->created_by = Auth::user()->user_code;
      $group->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Category added successfully"
      ]);

      $this->restFields();
   }


   //edit mode
   public function edit($id){
      $group = CustomerGroups::find($id);
      $this->name = $group->name;
      $this->categoryID = $group->id;
      $this->updateMode = true;
   }

   //update Subject
   public function update(){

      $this->validate();

      $group = CustomerGroups::where('business_code',Auth::user()->business_code)->where('id',$this->categoryID)->first();
      $group->name = $this->name;
      $group->business_code = Auth::user()->business_code;
      $group->updated_by = Auth::user()->user_code;
      $group->save();

      $this->categoryID = '';
      $this->name = '';
      $this->updateMode = false;

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Category updated successfully"
      ]);

   }

   //delete pop modal
   public function confirmDelete($id){
      $this->categoryID = $id;
   }

   //delete class
   public function delete(){
      CustomerGroups::where('business_code',Auth::user()->business_code)->where('id',$this->categoryID)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Category deleted successfully"
      ]);
   }

}
