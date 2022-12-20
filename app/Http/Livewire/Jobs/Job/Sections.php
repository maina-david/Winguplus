<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\jobs\sections as JobsSections;
use Livewire\Component;
use Helper;
use Auth;
use Wingu;

class Sections extends Component
{
   public $jobCode;
   public $title;

   public function render()
   {
      return view('livewire.jobs.job.sections');
   }

   //restFields
   public function restFields(){
      $this->title = "";
   }

   //add section
   public function store(){
      $this->validate([
         'title' => 'required',
      ]);

      $section = new JobsSections;
      $code = Helper::generateRandomString(30);
      $section->title         = $this->title;
      $section->section_code  = $code;
      $section->job_code      = $this->jobCode;
      $section->business_code = Auth::user()->business_code;
      $section->created_by    = Auth::user()->user_code;
      $section->save();

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a job section <a href="#">'.$this->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Section';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Section added successfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');
      $this->emitTo('jobs.tasks','refreshComponent');
      $this->emit('popModal');
   }
}
