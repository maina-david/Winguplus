<?php

namespace App\Http\Livewire\Crm\Leads\Events;

use App\Models\finance\customer\events;
use App\Models\wingu\wp_user;
use Livewire\Component;
use Auth;

class Edit extends Component
{
   protected $listeners = ['render'];

   public $title,$typeView,$meeting_type,$location,$meeting_link,$start_date,$start_time,$end_date,$end_time,$description,$leadCode,$send_invitation,$status,$priority,$host,$reminder,$eventCode;

   public function render()
   {
      $users = wp_user::where('business_code',Auth::user()->business_code)->where('status',15)->orderby('id','desc')->get();
      $edit = events::where('business_code', Auth::user()->business_code)->where('event_code',$this->eventCode)->first();
      $this->title        = $edit->event_name;
      $this->host         = $edit->owner;
      $this->priority     = $edit->priority;
      $this->details      = $edit->details;
      $this->start_date   = $edit->start_date;
      $this->start_time   = $edit->start_time;
      $this->due_date     = $edit->due_date;
      $this->end_time     = $edit->end_time;
      $this->status       = $edit->status;
      $this->meeting_link = $edit->meeting_link;
      $this->end_date     = $edit->end_date;
      $this->end_time     = $edit->end_time;
      $this->description  = $edit->description;
      $this->meeting_type = $edit->meeting_type;

      return view('livewire.crm.leads.events.edit', compact('users'));
   }

   //reset field
   public function restFields(){
      $this->title        = "";
      $this->priority     = "";
      $this->details      = "";
      $this->due_date     = "";
      $this->start_date   = "";
      $this->status       = "";
      $this->meeting_link = "";
      $this->end_date     = "";
      $this->end_time     = "";
      $this->description  = "";
      $this->leadCode     = "";
      $this->meeting_type = "";
      $this->eventCode    = "";
   }

   //update
   public function update_event(){
      $event = events::where('business_code', Auth::user()->business_code)->where('event_code',$this->eventCode)->first();
      $event->event_name    = $this->title;
      $event->priority      = $this->priority;
      $event->status        = $this->status;
      $event->location      = $this->location;
      $event->meeting_link  = $this->meeting_link;
      $event->owner         = $this->host;
      $event->start_date    = $this->start_date;
      $event->start_time    = $this->start_time;
      $event->end_date      = $this->end_date;
      $event->end_time      = $this->end_time;
      $event->description   = $this->description;
      $event->reminder      = $this->reminder;
      $event->meeting_type  = $this->meeting_type;
      $event->updated_by    = Auth::user()->user_code;
      $event->business_code = Auth::user()->business_code;
      $event->save();

      // $this->restFields();

      $this->emitTo('crm.leads.events.list-view','refreshComponent');
      $this->emitTo('crm.leads.events.grid-view','refreshComponent');
      $this->emitTo('crm.leads.events.details','refreshComponent');

      $this->emit('editModal');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Event Updated successfully"
      ]);

      // return redirect(request()->header('Referer'));
   }

   public function close(){
      $this->restFields();

      $this->emitTo('crm.leads.events.list-view','refreshComponent');
      $this->emitTo('crm.leads.events.grid-view','refreshComponent');

      $this->emit('editModal');

      return redirect(request()->header('Referer'));
   }
}
