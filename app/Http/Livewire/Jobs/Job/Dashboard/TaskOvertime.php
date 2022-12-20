<?php

namespace App\Http\Livewire\Jobs\Job\Dashboard;

use App\Charts\Jobs\Reports;
use App\Models\jobs\tasks;
use Livewire\Component;
use DB;
use Auth;

class TaskOvertime extends Component
{
   public $jobCode;

   public function render()
   {
      //task over time
      $taskovertime= new Reports;

      $days   = tasks::join('wp_status','wp_status.id','=','jb_tasks.status')
                     ->where('job',$this->jobCode)
                     ->where('business_code',Auth::user()->business_code)
                     ->groupby(DB::raw('close_date'))
                     ->select('close_date')
                     ->pluck('close_date');

      $tasks  =  DB::table('jb_tasks')
                     ->where('business_code',Auth::user()->business_code)
                     ->where('job',$this->jobCode)
                     ->groupby(DB::raw('close_date'))
                     ->select(DB::raw('COUNT(close_date) as tasks'))
                     ->pluck('tasks');

      $taskovertime->labels($days->values());
      $taskovertime->dataset('Task over time', 'bar', $tasks->values())
                      ->backgroundColor(collect(['rgba(243,71,112,0.2','rgba(237, 88, 18, 0.6)','rgba(243,71,112,0.2)','rgba(247, 229, 6, 0.6)','rgba(237, 88, 18, 0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));

      return view('livewire.jobs.job.dashboard.task-overtime', compact('taskovertime'));
   }
}
