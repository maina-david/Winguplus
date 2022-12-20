<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\jobs\jobs;
use App\Models\jobs\notes as JobsNotes;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;

class Notes extends Component
{
   public $jobCode,$search;
   public $title,$brief,$label;
   public function render()
   {
      $query = JobsNotes::where('job',$this->jobCode)
                        ->where('business_code',Auth::user()->business_code);
                        if($this->search){
                           $query->where('content','like','%'.$this->search.'%');
                        }
      $notes = $query->orderby('id','desc')
                        ->get();

      return view('livewire.jobs.job.notes', compact('notes'));
   }

   //reset fiels
   public function restFields(){
      $this->title = "";
      $this->brief = "";
      $this->label = "";
   }

   //add note
   public function create_note(){
      $this->validate([
         'title' => 'required',
      ]);

      $note = new JobsNotes;
      $note->note_code     = Helper::generateRandomString(30);
      $note->job           = $this->jobCode;
      $note->title         = $this->title;
      $note->brief         = $this->brief;
      $note->label         = $this->label;
      $note->business_code = Auth::user()->business_code;
      $note->created_by    = Auth::user()->user_code;
      $note->save();

      $job = jobs::where('job_code',$this->jobCode)->where('business_code',Auth::user()->business_code)->first();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new note to <a href="#">'.$job->job_title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Notes';
      $action       = 'Create';
		$activityCode = $note->note_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note added succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');
   }

   //delete note
   public function delete_note($code){
      JobsNotes::where('note_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Note deleted succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');
   }
}
