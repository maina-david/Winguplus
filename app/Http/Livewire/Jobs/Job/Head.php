<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\finance\customer\customers;
use App\Models\jobs\jobs;
use App\Models\jobs\members;
use Livewire\Component;
use Auth;

class Head extends Component
{
   public $jobCode;

   protected $listeners = ['refreshComponent'=>'$refresh'];

   public function render()
   {
      $job = jobs::join('wp_status','wp_status.id','=','jb_jobs.status')
                  ->where('jb_jobs.job_code',$this->jobCode)
                  ->where('business_code',Auth::user()->business_code)
                  ->select('*','jb_jobs.job_code as job_code','jb_jobs.end_date as end_date')
                  ->first();

      $code = $this->jobCode;

      $members = members::join('wp_users','wp_users.user_code','=','jb_job_member.user_code')
                        ->where('job_code',$code)
                        ->where('jb_job_member.business_code',Auth::user()->business_code)
                        ->select('name','avatar','jb_job_member.user_code as user_code')
                        ->get();

      $client = customers::where('business_code','=',Auth::user()->business_code)
                        ->where('customer_code',$job->customer)
                        ->first();

      return view('livewire.jobs.job.head', compact('job','code','members','client'));
   }
}
