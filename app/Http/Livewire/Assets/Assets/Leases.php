<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\assets;
use App\Models\asset\events;
use App\Models\finance\customer\customers;
use Livewire\Component;
use Auth;
use Wingu;
class Leases extends Component
{
   public $code;
   public $editMode = 'off';
   public $editCode;
   public $action_date,$due_action_date,$customer,$note;

   public function render()
   {
      $leases = events::join('wp_status','wp_status.id','as_assets_event.status')
                        ->where('business_code',Auth::user()->business_code)
                        ->where('asset_code',$this->code)
                        ->where('status',39)
                        ->orderby('as_assets_event.id','desc')
                        ->get();

      $customers = customers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.assets.assets.leases', compact('leases','customers'));
   }

  //reset fiels
  public function rest_fields(){
   $this->action_date = "";
   $this->due_action_date = "";
   $this->customer = "";
   $this->note = "";
   $this->editCode = "";
}

//edit repair
public function edit($editID){
   $edit = events::where('business_code',Auth::user()->business_code)->where('code',$editID)->first();
   $this->action_date = $edit->action_date;
   $this->due_action_date = $edit->due_action_date;
   $this->customer = $edit->customer;
   $this->note = $edit->note;
   $this->editCode = $editID;
   $this->editMode = 'on';
}

//update repair
public function update(){
   $this->validate([
      'action_date' => 'required',
      'customer' => 'required'
   ]);

   $edit = events::where('business_code',Auth::user()->business_code)->where('code',$this->editCode)->first();
   $edit->action_date     = $this->action_date;
   $edit->due_action_date = $this->due_action_date;
   $edit->customer        = $this->customer;
   $edit->note            = $this->note;
   $edit->updated_by      = Auth::user()->user_code;
   $edit->save();

   $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$this->code)->first();
   $asset->customer       = $this->customer;
   $asset->save();

   // Set Flash Message
   $this->dispatchBrowserEvent('alert',[
      'type'=>'success',
      'message'=>'Lease successfully updated'
   ]);

    //recored activity
   $activity     =  Auth::user()->name.' Has updated lease details';
   $module       = 'Asset Management';
   $section      = 'Lease';
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
      'message'=>'Lease successfully deleted'
   ]);

    //recored activity
   $activity     =  Auth::user()->name.' Has deleted a Lease';
   $module       = 'Asset Management';
   $section      = 'Lease';
   $action       = 'Delete';
   $activityCode = $this->editCode;

   Wingu::activity($activity,$module,$section,$action,$activityCode);

   $this->rest_fields();

   $this->emit('popModal');
}
}
