<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\events\events;
use App\Models\events\schedule;
use Livewire\Component;
use Auth;
use Wingu;
use Helper;

class Schedules extends Component
{
   public $eventCode,$editCode;
   public $title,$start_date,$location,$start_time,$end_time,$details;

   public function render()
   {
      $schedules = schedule::where('event_code',$this->eventCode)
                  ->whereNull('parent')->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.events.events.schedules', compact('schedules'));
   }

   //rest fields
   public function restFields(){
      $this->title = "";
      $this->start_date = "";
      $this->location = "";
      $this->start_time = "";
      $this->end_time = "";
      $this->details = "";
   }

   //store schedule
   public function store(){
      $this->validate([
         'title' => 'required',
         'start_date' => 'required',
         'start_time' => 'required',
         'end_time' => 'required',
         'details' => 'required',
      ]);

      $code = Helper::generateRandomString(30);
      $schedule = new schedule;
      $schedule->business_code = Auth::user()->business_code;
      $schedule->event_code    = $this->eventCode;
      $schedule->schedule_code = $code;
      $schedule->title         = $this->title;
      $schedule->start_date    = $this->start_date;
      $schedule->start_time    = $this->start_time;
      $schedule->end_time      = $this->end_time;
      $schedule->location      = $this->location;
      $schedule->details       = $this->details;
      $schedule->created_by    = Auth::user()->user_code;
      $schedule->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added a schedule';
      $module     = 'Wingu crowd';
      $section    = 'Schedule';
      $action     = 'Create';
      $activityID = $code;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Schedule added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }

   //edit
   public function edit($code){
      $this->editCode = $code;
      $edit = schedule::where('schedule_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $this->title      = $edit->title;
      $this->end_time   = $edit->end_time;
      $this->start_time = $edit->start_time;
      $this->start_date = $edit->start_date;
      $this->details    = $edit->details;
      $this->location   = $edit->location;
   }

   //update
   public function update(){
      $update = schedule::where('schedule_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();
      $update->event_code    = $this->eventCode;
      $update->title         = $this->title;
      $update->location      = $this->location;
      $update->start_time    = $this->start_time;
      $update->end_time      = $this->end_time;
      $update->details       = $this->details;
      $update->start_date    = $this->start_date;
      $update->updated_by    = Auth::user()->user_code;
      $update->save();

      //recorded activity
      $activities = Auth::user()->name.' Has updated <span class="text-primary font-bold">'.$this->title.'</span> schedule';
      $module     = 'Wingu crowd';
      $section    = 'Schedule';
      $action     = 'Edit';
      $activityID = $this->editCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Schedule updated successfully"
      ]);

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

      schedule::where('parent',$this->editCode)->where('business_code',Auth::user()->business_code)->delete();

      $this->restFields();
      $this->emit('popModal');

      //recorded activity
      $activities = Auth::user()->name.' Has deleted <span class="text-primary font-bold">'.$delete->title.'</span> schedule';
      $module     = 'Wingu crowd';
      $section    = 'Schedule';
      $action     = 'Delete';
      $activityID = $this->editCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Schedule deleted successfully"
      ]);
   }

}
