<?php

namespace App\Http\Livewire\General\Notes;

use App\Models\general\notes;
use Livewire\Component;
use Auth;
use Helper;

class Note extends Component
{

   public $note_content,$noteCode,$mode,$details;

   public function render()
   {
      $notes = notes::where('business_code',Auth::user()->business_code)->where('user_code',Auth::user()->user_code)->orderby('id','desc')->get();

      return view('livewire.general.notes.note', compact('notes'));
   }

   //reset field
   public function resetField(){
      $this->note_content = "";
      $this->noteCode     = "";
      $this->mode         = "";
   }

   //add note
   public function add_note(){
      $this->validate([
         'note_content' => 'required',
      ]);

      $submit                = new notes;
      $submit->note_code     = Helper::generateRandomString(30);
      $submit->note          = $this->note_content;
      $submit->user_code     = Auth::user()->user_code;
      $submit->created_by    = Auth::user()->user_code;
      $submit->business_code = Auth::user()->business_code;
      $submit->save();

      $this->resetField();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note added successfully"
      ]);

      $this->emit('ModalSlideNoteArea');
   }

   //edit
   public function edit($code){
      $edit               = notes::where('note_code',$code)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->where('user_code',Auth::user()->user_code)
                                 ->first();
      $this->note_content = $edit->note;
      $this->noteCode     = $code;
      $this->mode         = 'edit';
   }

   //update
   public function update(){
      $edit                = notes::where('note_code',$this->noteCode)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->where('user_code',Auth::user()->user_code)
                                    ->first();
      $edit->note          = $this->note_content;
      $edit->user_code     = Auth::user()->user_code;
      $edit->updated_by    = Auth::user()->user_code;
      $edit->business_code = Auth::user()->business_code;
      $edit->save();

      $this->resetField();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note updated successfully"
      ]);

      $this->emit('ModalSlideNoteArea');
   }

   //view
   public function view_note($code){
      $this->mode = 'view';
      $edit = notes::where('note_code',$code)
                  ->where('business_code',Auth::user()->business_code)
                  ->where('user_code',Auth::user()->user_code)
                  ->first();
      $this->details = $edit;
      $this->noteCode = $code;
   }

   //delete confirmation
   public function delete_confirmation($code){
      $this->noteCode = $code;
   }

   //remove note
   public function delete(){
      notes::where('note_code',$this->noteCode)->where('business_code',Auth::user()->business_code)->where('user_code',Auth::user()->user_code)->delete();

      $this->resetField();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note deleted successfully"
      ]);

      $this->emit('ModalSlideNoteDelete');
   }

   //close create and edit Modal
   public function close_crud(){
      $this->resetField();
      $this->emit('ModalSlideNoteArea');
   }

   //close note model
   public function close_note(){
      $this->resetField();
      $this->emit('ModalSlideNote');
   }

   //close delete
   public function close_delete(){
      $this->resetField();
      $this->emit('ModalSlideNoteDelete');
   }

   //close delete
   public function close_view(){
      $this->emit('ModalSlideNoteView');
   }
}
