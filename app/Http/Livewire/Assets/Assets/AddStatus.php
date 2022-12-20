<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\status;
use Livewire\Component;
use Helper;
use Auth;

class AddStatus extends Component
{
   public $title;

   public function render()
   {
      return view('livewire.assets.assets.add-status');
   }

   //rest files
   public function restFields(){
      $this->title= "";
   }

   //save
   public function save_status(){
      $this->validate([
         'title' => 'required',
      ]);

      $status = new status;
      $status->title          = $this->title;
      $status->status_code     = Helper::generateRandomString(30);
      $status->business_code = Auth::user()->business_code;
      $status->created_by    = Auth::user()->user_code;
      $status->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Status Label added successfully'
      ]);

      $this->restFields();

      $this->emitTo('assets.assets.status','refreshComponent');
      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }
}
