<?php

namespace App\Http\Livewire\Jobs\Job\Dashboard;
use App\Charts\Jobs\Reports;
use App\Models\jobs\task_allocation;
use App\Models\jobs\tasks;
use Livewire\Component;
use Auth;
use DB;

class Tasksperuser extends Component
{
   public $jobCode;
   public $taskDate;

   public function render()
   {
      //task status summary
      $tasksperuser= new Reports;

      $users = task_allocation::join('wp_users','wp_users.user_code','=','jb_task_allocations.user')
                     ->join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                     ->where('job',$this->jobCode)
                     ->where('jb_task_allocations.business_code',Auth::user()->business_code)
                     ->groupby(DB::raw('jb_task_allocations.user'))
                     ->select(DB::raw('name as userName'))
                     ->pluck('userName');

      $tasks =  DB::table('jb_task_allocations')
                     ->join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                     ->where('jb_task_allocations.business_code',Auth::user()->business_code)
                     ->where('job',$this->jobCode)
                     ->groupby(DB::raw('user'))
                     ->select(DB::raw('COUNT(user) as tasks'))
                     ->pluck('tasks');

		$tasksperuser->labels($users->values());
      $tasksperuser->dataset('Task Per User', 'polarArea', $tasks->values())
                  ->backgroundColor(collect(['rgba(247, 229, 6, 0.6)','rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));

      return view('livewire.jobs.job.dashboard.tasksperuser', compact('tasksperuser'));
   }
}
