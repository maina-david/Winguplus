<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\events\schedule;
use Livewire\Component;
use Auth;
use Wingu;
use Helper;

class Sessions extends Component
{
   public $eventCode,$scheduleCode,$editCode;
   public $title,$start_time,$end_time,$details;

   public function render()
   {
      $sessions = schedule::where('parent',$this->scheduleCode)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $schedule = schedule::where('schedule_code',$this->scheduleCode)->where('business_code',Auth::user()->business_code)->first();

      return view('livewire.events.events.sessions', compact('sessions','schedule'));
   }

   //rest fields
   public function restFields(){
      $this->title = "";
      $this->start_time = "";
      $this->end_time = "";
      $this->details = "";
      $this->editCode = "";
   }

   //store schedule
   public function store(){
      $this->validate([
         'title' => 'required',
         'start_time' => 'required',
         'end_time' => 'required',
         'details' => 'required',
      ]);

      $code = Helper::generateRandomString(30);
      $schedule                = new schedule;
      $schedule->business_code = Auth::user()->business_code;
      $schedule->event_code    = $this->eventCode;
      $schedule->schedule_code = $code;
      $schedule->parent        = $this->scheduleCode;
      $schedule->title         = $this->title;
      $schedule->start_time    = $this->start_time;
      $schedule->end_time      = $this->end_time;
      $schedule->details       = $this->details;
      $schedule->created_by    = Auth::user()->user_code;
      $schedule->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added a schedule session';
      $module     = 'Event Manager';
      $section    = 'Session';
      $action     = 'Create';
      $activityID = $code;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Session added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit
   public function edit($code){
      $this->editCode = $code;
      $edit = schedule::where('schedule_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->title      = $edit->title;
      $this->start_time = $edit->start_time;
      $this->end_time   = $edit->end_time;
      $this->details    = $edit->details;
   }

   //update
   public function update(){
      $update = schedule::where('schedule_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();
      $update->event_code    = $this->eventCode;
      $update->title         = $this->title;
      $update->start_time    = $this->start_time;
      $update->end_time      = $this->end_time;
      $update->details       = $this->details;
      $update->updated_by    = Auth::user()->user_code;
      $update->save();

      //recorded activity
      $activities = Auth::user()->name.' Has updated <span class="text-primary font-bold">'.$this->title.'</span> schedule session';
      $module     = 'Event Manager';
      $section    = 'Session';
      $action     = 'Edit';
      $activityID = $this->editCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Session updated successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }

   //confirm delete
   public function confirm_delete($code){
      $this->editCode = $code;
   }

   //delete
   public function delete(){
      $delete = schedule::where('schedule_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();

      $this->restFields();
      $this->emit('popModal');

      //recorded activity
      $activities = Auth::user()->name.' Has deleted <span class="text-primary font-bold">'.$delete->title.'</span> schedule session';
      $module     = 'Event Manager';
      $section    = 'Session';
      $action     = 'Delete';
      $activityID = $this->editCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Session deleted successfully"
      ]);
   }

}
