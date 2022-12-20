<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\types;
use Livewire\Component;
use Auth;
use Helper;

class AddTypes extends Component
{
   public $name;

   public function render()
   {
      return view('livewire.assets.assets.add-types');
   }

   //rest files
   public function restFields(){
      $this->name= "";
   }

   //save
   public function save_category(){
      $this->validate([
         'name' => 'required',
      ]);

      $type = new types;
      $type->name          = $this->name;
      $type->type_code     = Helper::generateRandomString(30);
      $type->business_code = Auth::user()->business_code;
      $type->created_by    = Auth::user()->user_code;
      $type->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Asset category added successfully'
      ]);

      $this->restFields();

      $this->emitTo('assets.assets.types','refreshComponent');
      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }
}
