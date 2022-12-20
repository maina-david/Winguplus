<?php

namespace App\Http\Livewire\Crm\Leads\Events;

use App\Models\finance\customer\events;
use App\Models\finance\customer\notes;
use Livewire\Component;
use Helper;
use Auth;

class Details extends Component
{
   protected $listeners = ['render','refreshComponent'=>'$refresh'];
  //protected $listeners = [];

   public $eventCode,$subject,$note,$noteCode,$deleteNoteCode,$deleteEventCode;
   public $currentView = 'details';

   public function render()
   {
      $details = events::where('business_code', Auth::user()->business_code)->where('event_code',$this->eventCode)->first();
      $notes = notes::where('business_code',Auth::user()->business_code)->where('parent_code',$this->eventCode)->get();

      return view('livewire.crm.leads.events.details', compact('details','notes'));
   }

   //reset fields
   public function restFields(){
      $this->subject = "";
      $this->note = "";
      $this->noteCode = "";
      $this->deleteNoteCode = "";
      $this->deleteEventCode = "";
   }

   //task detail view change
   public function change_view($view){
      $this->currentView = $view;

      // $this->emit('view_task',$code,$view);
   }

   //add note
   public function add_note(){
      $note = new notes;
      $note->note_code   = Helper::generateRandomString(30);
      $note->parent_code = $this->eventCode;
      $note->subject     = $this->subject;
      $note->note        = $this->note;
      $note->section     = 'Leads';
      $note->created_by  = Auth::user()->user_code;
      $note->business_code  = Auth::user()->business_code;
      $note->save();

      $this->restFields();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note added successfully"
      ]);
   }

   //edit note
   public function edit_note($code){
      $this->noteCode = $code;
      $edit = notes::where('business_code',Auth::user()->business_code)->where('note_code',$code)->first();
      $this->subject = $edit->subject;
      $this->note    = $edit->note;
   }

   //update note
   public function update_note(){
      $edit = notes::where('business_code',Auth::user()->business_code)->where('note_code',$this->noteCode)->first();
      $edit->subject       = $this->subject;
      $edit->note          = $this->note;
      $edit->created_by    = Auth::user()->user_code;
      $edit->business_code = Auth::user()->business_code;
      $edit->save();

      $this->restFields();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note updated successfully"
      ]);
   }

   //delete notification
   public function delete_note($code){
      $this->deleteNoteCode = $code;
   }

   //remove note
   public function remove_note(){
      notes::where('business_code',Auth::user()->business_code)->where('note_code',$this->deleteNoteCode)->delete();

      $this->restFields();

      $this->emit('deleteModal');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note deleted successfully"
      ]);
   }

   //close delete
   public function close_delete(){
      $this->restFields();
      $this->emit('deleteModal');
   }

   //delete notification
   public function delete_event(){
      $this->deleteEventCode = $this->eventCode;
   }

   //delete event
   public function remove_event(){
      events::where('business_code', Auth::user()->business_code)->where('event_code',$this->eventCode)->delete();
      notes::where('business_code',Auth::user()->business_code)->where('parent_code',$this->eventCode)->delete();

      $this->restFields();

      $this->emit('detailsModal');
      $this->emit('deleteModal');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Event deleted successfully"
      ]);

      return redirect(request()->header('Referer'));

   }


   public function close(){

      $this->restFields();

      $this->emitTo('crm.leads.events.list-view','refreshComponent');
      $this->emitTo('crm.leads.events.grid-view','refreshComponent');

      $this->emit('detailsModal');

      return redirect(request()->header('Referer'));
   }
}
