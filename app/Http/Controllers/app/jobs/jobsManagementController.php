<?php

namespace App\Http\Controllers\app\jobs;

use App\Charts\Jobs\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\jobs\jobs;
use App\Models\jobs\tasks;
use Carbon\Carbon;
use DB;
use Auth;
use Wingu;

class jobsManagementController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function dashboard()
   {
      $year = date('Y');

      //total jobs
      $totalJobs = jobs::where('business_code',Auth::user()->business_code)
                        ->whereYear('created_at','=',$year)
                        ->count();

      //jobs per month
      $jobOverTime= new Reports;

      $month = jobs::where('business_code',Auth::user()->business_code)
                     ->whereYear('start_date', '=', $year)
                     ->groupby(DB::raw('MONTH(start_date)'))
                     ->select(DB::raw('month(start_date) as month'))
                     ->selectRaw("DATE_FORMAT(start_date, '%M') AS month")
                     ->pluck('month');

      $totalMonth = DB::table('jb_jobs')
                        ->where('business_code',Auth::user()->business_code)
                        ->whereYear('start_date', '=', $year)
                        ->select(DB::raw('COUNT(start_date) as total'))
                        ->groupby(DB::raw('MONTH(start_date)'))
                        ->pluck('total');

      $jobOverTime->labels($month->values());
      $jobOverTime->dataset('Jobs Per Month', 'bar', $totalMonth->values())
                      ->backgroundColor(collect(['rgba(243,71,112,0.2','rgba(237, 88, 18, 0.6)','rgba(243,71,112,0.2)','rgba(247, 229, 6, 0.6)','rgba(237, 88, 18, 0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));

      //current jobs
      $currentJobs = jobs::where('status','!=',16)->where('business_code',Auth::user()->business_code)->limit(16)->orderby('id','desc')->get();

      //due tasks
      $dueTasks = tasks::where('business_code',Auth::user()->business_code)
                        ->where('status','!=',16)
                        ->where('due_date', '<=', Carbon::today())
                        ->limit(9)
                        ->get();

      //members with tasks
      $membersWithTasks  = new Reports;

      $users = tasks::join('jb_task_allocations','jb_task_allocations.task','=','jb_tasks.task_code')
                     ->join('wp_users','wp_users.user_code','=','jb_task_allocations.user')
                     ->where('jb_tasks.business_code',Auth::user()->business_code)
                     ->whereYear('start_date', '=', $year)
                     ->groupby('jb_task_allocations.user')
                     ->select('name')
                     ->pluck('name');

      $totaltasks = DB::table('jb_tasks')
                     ->join('jb_task_allocations','jb_task_allocations.task','=','jb_tasks.task_code')
                     ->join('wp_users','wp_users.user_code','=','jb_task_allocations.user')
                     ->where('jb_tasks.business_code',Auth::user()->business_code)
                     ->whereYear('start_date','=', $year)
                     ->select(DB::raw('COUNT(jb_task_allocations.user) as total'))
                     ->groupby('jb_task_allocations.user')
                     ->pluck('total');

      $membersWithTasks->labels($users->values());
      $membersWithTasks->dataset('Total Tasks Per Member', 'line', $totaltasks->values())
                  ->color(collect(['#C5CAE9']));


      return view('app.jobs.dashboard.dashboard', compact('totalJobs','jobOverTime','currentJobs','dueTasks','membersWithTasks'));
   }
}
