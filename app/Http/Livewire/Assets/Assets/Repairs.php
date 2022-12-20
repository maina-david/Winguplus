<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\events;
use App\Models\finance\suppliers\suppliers;
use App\Models\hr\employees;
use Livewire\Component;
use Auth;
use Wingu;

class Repairs extends Component
{
   public $code;
   public $editMode = 'off';
   public $editCode;
   public $action_date,$due_action_date,$employee,$cost,$note,$supplier;

   public function render()
   {
      $repairs = events::join('wp_status','wp_status.id','as_assets_event.status')
                        ->where('business_code',Auth::user()->business_code)
                        ->where('asset_code',$this->code)
                        ->where('status',34)
                        ->orderby('as_assets_event.id','desc')
                        ->get();

      $employees = employees::where('business_code',Auth::user()->business_code)
                              ->orderby('id','desc')
                              ->get();

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->get();

      return view('livewire.assets.assets.repairs', compact('repairs','employees','suppliers'));
   }

   //reset fiels
   public function rest_fields(){
      $this->action_date = "";
      $this->due_action_date = "";
      $this->employee = "";
      $this->cost = "";
      $this->note = "";
      $this->supplier = "";
      $this->editCode = "";
   }

   //edit repair
   public function edit($editID){
      $edit = events::where('business_code',Auth::user()->business_code)->where('code',$editID)->first();
      $this->action_date = $edit->action_date;
      $this->due_action_date = $edit->due_action_date;
      $this->employee = $edit->employee;
      $this->cost = $edit->cost;
      $this->note = $edit->note;
      $this->supplier = $edit->supplier;
      $this->editCode = $editID;
      $this->editMode = 'on';
   }

   //update repair
   public function update(){
      $this->validate([
         'action_date' => 'required',
      ]);

      $edit = events::where('business_code',Auth::user()->business_code)->where('code',$this->editCode)->first();
      $edit->action_date     = $this->action_date;
      $edit->due_action_date = $this->due_action_date;
      $edit->employee        = $this->employee;
      $edit->cost            = $this->cost;
      $edit->note            = $this->note;
      $edit->supplier        = $this->supplier;
      $edit->updated_by      = Auth::user()->user_code;
      $edit->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Log successfully updated'
      ]);

       //recored activity
		$activity     =  Auth::user()->name.' Has updated asset repair details';
		$module       = 'Asset Management';
		$section      = 'Repair';
      $action       = 'Edit';
		$activityCode = $this->editCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->rest_fields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->rest_fields();

      $this->emit('popModal');
   }

   //remove
   public function remove($getCode){
      $this->editCode = $getCode;
   }

   //delete
   public function delete(){
      events::where('business_code',Auth::user()->business_code)->where('code',$this->editCode)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Log successfully deleted'
      ]);

       //recored activity
		$activity     =  Auth::user()->name.' Has deleted asset repair log';
		$module       = 'Asset Management';
		$section      = 'Repair';
      $action       = 'Delete';
		$activityCode = $this->editCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->rest_fields();

      $this->emit('popModal');
   }
}
