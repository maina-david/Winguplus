<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\jobs\members;
use App\Models\wingu\wp_user;
use Livewire\Component;
use Auth;

class AddMemberModal extends Component
{
   public $jobCode;
   public $search;

   public function render()
   {
      $query = wp_user::where('business_code',Auth::user()->business_code);
            if($this->search){
               $query->where('name','like','%'.$this->search.'%');
            }
      $users = $query->get();

      return view('livewire.jobs.job.add-member-modal', compact('users'));
   }

   //add member
   public function add_member($code,$userCode){
      //check if member is already linked
      $check = members::where('business_code',Auth::user()->business_code)->where('user_code',$userCode)->where('job_code',$code)->count();
      if($check == 0){
         $member = new members;
         $member->business_code = Auth::user()->business_code;
         $member->user_code     = $userCode;
         $member->job_code      = $code;
         $member->created_by    = Auth::user()->user_code;
         $member->save();
      }

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'User added successfully'
      ]);

      $this->emitTo('jobs.job.head','refreshComponent');
      $this->emitTo('jobs.job.dashboard.team-members','refreshComponent');
      $this->emit('popModal');
   }
}
