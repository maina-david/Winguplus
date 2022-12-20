<?php
namespace App\Http\Livewire\Jobs\Job\Dashboard;

use App\Charts\Jobs\Reports;
use App\Models\jobs\tasks;
use Livewire\Component;
use Auth;
use DB;

class TaskSummary extends Component
{
   public $jobCode;
   public $taskDate;

   public function render()
   {
      //task status summary
      $taskStatusSummary= new Reports;

      $status   = tasks::join('wp_status','wp_status.id','=','jb_tasks.status')
                     ->where('job',$this->jobCode)
                     ->where('business_code',Auth::user()->business_code)
                     ->groupby(DB::raw('status'))
                     ->select(DB::raw('name as statusName'))
                     ->pluck('statusName');

      $tasks  =  DB::table('jb_tasks')
                     ->where('business_code',Auth::user()->business_code)
                     ->where('job',$this->jobCode)
                     ->select(DB::raw('COUNT(status) as tasks'))
                     ->groupby(DB::raw('status'))
                     ->pluck('tasks');

		$taskStatusSummary->labels($status->values());
      $taskStatusSummary->dataset('Task summary', 'doughnut', $tasks->values())
                        ->backgroundColor(collect(['rgba(237, 88, 18, 0.6)','rgba(52,186,187,0.6)','rgba(21, 209, 11, 0.6)','rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(237, 18, 148, 0.45)','rgba(243,71,112,0.2)']));

      return view('livewire.jobs.job.dashboard.task-summary', compact('taskStatusSummary'));
   }
}
