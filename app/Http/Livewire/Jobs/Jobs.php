<?php

namespace App\Http\Livewire\Jobs;

use App\Models\jobs\jobs as JobsJobs;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Jobs extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $search;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $query = JobsJobs::join('wp_business','wp_business.business_code','=','jb_jobs.business_code')
                  ->join('wp_status','wp_status.id','=','jb_jobs.status')
                  ->where('jb_jobs.business_code',Auth::user()->business_code);
                  if($this->search){
                     $query->where('job_title','like','%'.$this->search.'%');
                  }
      $jobs = $query->select('*','jb_jobs.job_code as job_code','wp_status.name as statusName','wp_business.name as businessName','wp_business.business_code as business_code')
                  ->orderby('jb_jobs.id','DESC')
                  ->simplePaginate(15);

      return view('livewire.jobs.jobs', compact('jobs'));
   }
}
