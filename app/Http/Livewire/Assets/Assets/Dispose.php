<?php
namespace App\Http\Livewire\Assets\Assets;

use Livewire\Component;
use App\Models\asset\events;
use Auth;
use Wingu;

class Dispose extends Component
{
   public $code;
   public $editMode = 'off';
   public $editCode;
   public $action_date,$action_to,$note;

   public function render()
   {
      $events = events::join('wp_status','wp_status.id','as_assets_event.status')
                        ->where('business_code',Auth::user()->business_code)
                        ->where('asset_code',$this->code)
                        ->where('status',40)
                        ->orderby('as_assets_event.id','desc')
                        ->get();


      return view('livewire.assets.assets.dispose', compact('events'));
   }

   //reset fiels
   public function rest_fields(){
      $this->action_date = "";
      $this->note = "";
      $this->action_to = "";
      $this->editCode = "";
   }

   //edit repair
   public function edit($editID){
      $edit = events::where('business_code',Auth::user()->business_code)->where('code',$editID)->first();
      $this->action_date = $edit->action_date;
      $this->note        = $edit->note;
      $this->action_to   = $edit->action_to;
      $this->editCode    = $editID;
      $this->editMode    = 'on';
   }

   //update repair
   public function update(){
      $this->validate([
         'action_date' => 'required',
      ]);

      $edit = events::where('business_code',Auth::user()->business_code)->where('code',$this->editCode)->first();
      $edit->action_date     = $this->action_date;
      $edit->note            = $this->note;
      $edit->action_to       = $this->action_to;
      $edit->updated_by      = Auth::user()->user_code;
      $edit->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Log successfully updated'
      ]);

      //recored activity
		$activity     =  Auth::user()->name.' Has Recorded asset as Disposed';
		$module       = 'Asset Management';
		$section      = 'Disposed';
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
         'message'=>'Asset log successfully deleted'
      ]);

       //recored activity
		$activity     =  Auth::user()->name.' Has deleted asset disposed log';
		$module       = 'Asset Management';
		$section      = 'Disposed';
      $action       = 'Delete';
		$activityCode = $this->editCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->rest_fields();

      $this->emit('popModal');
   }
}
