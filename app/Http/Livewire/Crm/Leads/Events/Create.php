<?php

namespace App\Http\Livewire\Crm\Leads\Events;

use App\Helpers\Finance;
use App\Mail\sendMessage;
use App\Models\finance\customer\events;
use App\Models\wingu\wp_user;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;
use Mail;

class Create extends Component
{
   protected $listeners = ['render'];

   public $title,$typeView,$meeting_type,$location,$meeting_link,$start_date,$start_time,$end_date,$end_time,$description,$leadCode,$send_invitation,$status,$priority,$host,$reminder;

   public function render()
   {
      $users = wp_user::where('business_code',Auth::user()->business_code)->where('status',15)->orderby('id','desc')->get();
      return view('livewire.crm.leads.events.create', compact('users'));
   }

   //change view
   public function change(){
      $this->typeView = $this->meeting_type;
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
   }

   //save event
   public function save_event(){
      $this->validate([
         'title' => 'required',
         'meeting_type' => 'required',
         'start_date' => 'required',
         'start_time' => 'required'
      ]);

      $event = new events;
      $event->event_code    = Helper::generateRandomString(30);
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
      $event->customer_code = $this->leadCode;
      $event->reminder      = $this->reminder;
      $event->meeting_type  = $this->meeting_type;
      $event->created_by    = Auth::user()->user_code;
      $event->business_code = Auth::user()->business_code;
      $event->save();

      if($this->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Finance::client($this->leadCode)->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$this->title.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($this->start_date)).' @ '.$this->start_time.' </strong><br/>
         </strong><br/><br/>
         -------------------------------------------------<br><br>'.$this->description;

         $subject = 'Meeting invitation - '.$this->title;
         $to = Finance::client($this->leadCode)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new event <a href="#">'.$this->title.'</a>';
		$module       = 'Customer Relationship Management';
		$section      = 'Events';
      $action       = 'Create';
		$activityCode = $event->event_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->restFields();

      $this->emitTo('crm.leads.events.list-view','refreshComponent');
      $this->emitTo('crm.leads.events.grid-view','refreshComponent');

      $this->emit('popModal');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Event added successfully"
      ]);

   }

   public function close(){
      $this->restFields();

      $this->emitTo('crm.leads.events.list-view','refreshComponent');
      $this->emitTo('crm.leads.events.grid-view','refreshComponent');

      $this->emit('eventCreate');

      return redirect(request()->header('Referer'));
   }
}
