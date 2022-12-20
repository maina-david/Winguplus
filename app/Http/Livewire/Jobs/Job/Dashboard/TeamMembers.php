<?php

namespace App\Http\Livewire\Jobs\Job\Dashboard;

use App\Models\jobs\members;
use Livewire\Component;
use Auth;

class TeamMembers extends Component
{
   public $jobCode;
   protected $listeners = ['refreshComponent'=>'$refresh'];

   public function render()
   {
      $members = members::join('wp_users','wp_users.user_code','=','jb_job_member.user_code')
                        ->where('job_code',$this->jobCode)
                        ->where('jb_job_member.business_code',Auth::user()->business_code)
                        ->select('name','avatar','jb_job_member.user_code as user_code')
                        ->get();

      return view('livewire.jobs.job.dashboard.team-members', compact('members'));
   }

   //remove member
   public function remove_member($jobCode,$userCode){

      members::where('business_code',Auth::user()->business_code)->where('user_code',$userCode)->where('job_code',$jobCode)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'User removed successfully'
      ]);

      $this->emitTo('jobs.job.head','refreshComponent');
      $this->emitTo('jobs.job.dashboard.team-members','refreshComponent');
      $this->emit('popModal');
   }
}
