<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\hr\department;
use Livewire\Component;
use Helper;
use Auth;

class AddDepartment extends Component
{
   public $title;

   public function render()
   {
      return view('livewire.assets.assets.add-department');
   }

   //rest files
   public function restFields(){
      $this->title= "";
   }

   //save
   public function save_department(){
      $this->validate([
         'title' => 'required',
      ]);

      $department = new department;
      $department->department_code = Helper::generateRandomString(30);
      $department->title = $this->title;
      $department->business_code = Auth::user()->business_code;
      $department->created_by = Auth::user()->user_code;
      $department->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Department added successfully'
      ]);

      $this->restFields();

      $this->emitTo('assets.assets.departments','refreshComponent');
      
      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }
}
