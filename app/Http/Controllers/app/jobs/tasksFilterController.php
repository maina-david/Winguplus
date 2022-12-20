<?php
namespace App\Http\Controllers\app\jobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\project\project;
use App\Models\project\tasks;
use App\Models\project\status;
use App\Models\project\priority;
use App\Models\project\allocation;
use App\Models\hr\employees;
use App\Models\project\group;
use App\Models\wingu\file_manager as documents;
use App\Models\project\comments;
use App\Models\wingu\User;
use Mail;
use Finance;
use Helper;
use Hr;
use Auth;
use Session;
use Prm;
use Wingu;
use File;
use DB;

class tasksFilterController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Task today
   */
   public function today($id){
      $project = project::join('status','status.id','=','project.statusID')
                        ->where('project.id',$id)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','project.id as id')
                        ->first();
      $tasks = tasks::join('project_tasks_allocation','project_tasks_allocation.taskID','=','project_tasks.id')
                     ->join('project','project.id','=','project_tasks.projectID')
                     ->where('project_tasks.businessID',Auth::user()->businessID)
                     ->where('project_tasks_allocation.userID',Auth::user()->id)
                     ->where('due_date','=',date("Y-m-d"))
                     ->select('*','project_tasks.id as id','project_tasks.statusID as statusID','project_tasks.projectID as projectID')
                     ->get();

      return view('app.jobs.tasks.filter.due_today', compact('tasks','project'));
   }

   /**
   * Last 7 days
   */
   public function last_seven($id){
      $start = date("Y-m-d", strtotime("-1 week"));
      $end = date("Y-m-d");

      $project = project::join('status','status.id','=','project.statusID')
                        ->where('project.id',$id)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','project.id as id')
                        ->first();
      $tasks = tasks::join('project_tasks_allocation','project_tasks_allocation.taskID','=','project_tasks.id')
                     ->join('project','project.id','=','project_tasks.projectID')
                     ->where('project_tasks.businessID',Auth::user()->businessID)
                     ->where('project_tasks_allocation.userID',Auth::user()->id)
                     // ->where('start_date','=',$start)
                     // ->where('due_date','=',$end)
                     ->where('start_date', '>=', $start)
                     ->where('start_date', '<=', $end)
                     ->where('due_date', '>=', $start)
                     ->where('due_date', '<=', $end)
                     //->select('*','project_tasks.id as id','project_tasks.statusID as statusID','project_tasks.projectID as projectID')
                     ->get();

      return view('app.jobs.tasks.filter.due_today', compact('tasks','project'));
   }

   /**
   * Overdue tasks
   */
   public function overdue($id){
      $today = date("Y-m-d");
      $project = project::join('status','status.id','=','project.statusID')
                        ->where('project.id',$id)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','project.id as id')
                        ->first();
      $tasks = tasks::join('project_tasks_allocation','project_tasks_allocation.taskID','=','project_tasks.id')
                     ->join('project','project.id','=','project_tasks.projectID')
                     ->where('project_tasks.businessID',Auth::user()->businessID)
                     ->where('project_tasks_allocation.userID',Auth::user()->id)
                     ->where('project_tasks.statusID',)
                     ->where('due_date','<',$today)
                     ->select('*','project_tasks.id as id','project_tasks.statusID as statusID','project_tasks.projectID as projectID')
                     ->get();

                     return $start;
   }

}
