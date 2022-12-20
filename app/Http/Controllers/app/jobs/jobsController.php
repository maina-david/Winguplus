<?php

namespace App\Http\Controllers\app\jobs;

use App\Charts\Jobs\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\jobs\jobs;
use App\Models\jobs\tasks;
use App\Models\jobs\leaders;
use App\Models\jobs\comments;
use App\Models\jobs\allocation;
use App\Models\jobs\group;
use App\Models\wingu\activity_log;
use App\Models\wingu\wp_user;
use Helper;
use Auth;
use Session;
use Wingu;
use DB;

class jobsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   **/
   public function index()
   {
      $jobs = jobs::join('wp_business','wp_business.business_code','=','jb_jobs.business_code')
                        ->join('wp_status','wp_status.id','=','jb_jobs.status')
                        ->where('jb_jobs.business_code',Auth::user()->business_code)
                        ->select('*','jb_jobs.job_code as job_code','wp_status.name as statusName','wp_business.name as businessName')
                        ->orderby('jb_jobs.id','DESC')
                        ->get();

      return view('app.jobs.job.index', compact('jobs'));
   }

   /**
   * create project
   **/
   public function create(){

      $clients = customers::where('business_code',Auth::user()->business_code)->pluck('customer_name','customer_code');
      $users = wp_user::where('business_code',Auth::user()->business_code)
                        ->select('name as names','user_code')
                        ->pluck('names','user_code')
                        ->prepend('Choose users');

      return view('app.jobs.job.create', compact('clients','users'));

   }

   /**
   * store project
   **/
   public function store(Request $request){
      $this->validate($request, array(
         'end_date'     => 'required',
         'start_date'   => 'required',
         'job_type'     => 'required',
         'status'       => 'required',
         'job_title'    => 'required',
         'job_leads'    =>  'required'
      ));

      $project = new jobs;
      $code = Helper::generateRandomString(20);
      $project->job_code          = $code;
      $project->job_title         = $request->job_title;
      $project->description       = $request->description;
      $project->customer          = $request->customer;
      $project->job_type          = $request->job_type;
      $project->notify_client     = $request->notify_client;
      $project->created_by        = Auth::user()->user_code;
      $project->business_code     = Auth::user()->business_code;
      $project->visibility_status = $request->visibility_status;
      $project->start_date        = $request->start_date;
      $project->end_date          = $request->end_date;
      $project->status            = $request->status;
      $project->save();

      /*==== allocate project to employee ====*/
      if(!empty($request->job_leads)){
         for($i=0; $i < count($request->job_leads); $i++ ) {
            $allocation                = new leaders;
            $allocation->job           = $code;
            $allocation->user          = $request->job_leads[$i];
            $allocation->created_by    = Auth::user()->user_code;
            $allocation->business_code = Auth::user()->business_code;
            $allocation->save();
         }
      }

      //create group

      //task
      $group = new group;
      $group->group_code    = Helper::generateRandomString(20);
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->job           = $code;
      $group->name          = 'Tasks';
      $group->save();

      //In Progress
      $group = new group;
      $group->group_code    = Helper::generateRandomString(20);
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->job           = $code;
      $group->name          = 'In Progress';
      $group->save();

      //In Review
      $group = new group;
      $group->group_code    = Helper::generateRandomString(20);
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->job           = $code;
      $group->name          = 'In Review';
      $group->save();

      //Done
      $group = new group;
      $group->group_code    = Helper::generateRandomString(20);
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->job           = $code;
      $group->name          = 'Done';
      $group->save();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>created</b> a new Job <a href="'.route('job.show',$code).'">'.$request->job_title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Job';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Job has been created !');

      return redirect()->route('job.dashboard',$code);
   }

   /**
   * edit project
   **/
   public function edit($code){
      $project = jobs::join('wp_status','wp_status.id','=','jb_jobs.status')
                        ->where('jb_jobs.job_code',$code)
                        ->where('business_code',Auth::user()->business_code)
                        ->first();

      $clients = customers::where('business_code',Auth::user()->business_code)->pluck('customer_name','customer_code');
      $users = wp_user::where('business_code',Auth::user()->business_code)
                                          ->select('name as names','user_code')
                                          ->pluck('names','user_code')
                                          ->prepend('Choose users');

      //linked users
      $currentemp = leaders::where('job',$code)->pluck('user');

      return view('app.jobs.job.edit', compact('project','clients','users','code','currentemp'));
   }

   /**
   * Update project
   **/
   public function update(Request $request, $code){
      $this->validate($request, array(
         'end_date'     => 'required',
         'start_date'   => 'required',
         'job_type' => 'required',
         'status'       => 'required',
         'job_title' => 'required',
         'job_leads'      =>  'required'
      ));

      $job = jobs::where('job_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $job->job_title         = $request->job_title;
      $job->description       = $request->description;
      $job->customer          = $request->customer;
      $job->job_type          = $request->job_type;
      $job->updated_by        = Auth::user()->user_code;
      $job->business_code     = Auth::user()->business_code;
      $job->start_date        = $request->start_date;
      $job->notify_client     = $request->notify_client;
      $job->end_date          = $request->end_date;
      $job->status            = $request->status;
      $job->brief_info        = $request->brief_info;
      $job->visibility_status = $request->visibility_status;
      $job->save();

      /*==== allocate project to emloyee ====*/
      if(!empty($request->job_leads)){

         //delete the current employee
         leaders::where('job',$code)->where('business_code',Auth::user()->business_code)->delete();

         for($i=0; $i < count($request->job_leads); $i++ ) {
            $allocation                = new leaders;
            $allocation->job           = $code;
            $allocation->user          = $request->job_leads[$i];
            $allocation->created_by    = Auth::user()->user_code;
            $allocation->business_code = Auth::user()->business_code;
            $allocation->save();
         }
      }

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> <a href="'.route('job.show',$code).'">'.$request->job_title.'</a> information';
		$module       = 'Jobs Management';
		$section      = 'Job';
      $action       = 'Edit';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'The project has been updated !');

      return redirect()->back();
   }

   /**
   * Job dashboard
   **/
   public function dashboard($code){
      return view('app.jobs.job.dashboard', compact('code'));
   }

   /**
   * show project
   **/
   public function show($code){
      $job = jobs::join('wp_status','wp_status.id','=','jb_jobs.status')
                        ->where('jb_jobs.job_code',$code)
                        ->where('business_code',Auth::user()->business_code)
                        ->select('*','jb_jobs.job_code as job_code','jb_jobs.created_at as project_date')
                        ->first();

      $client = customers::where('business_code','=',Auth::user()->business_code)
                        ->where('customer_code',$job->customer)
                        ->first();

      $leaders = leaders::join('wp_users','wp_users.user_code','=','jb_leaders.job')
                           ->where('job',$code)
                           ->get();

      return view('app.jobs.job.show', compact('job','leaders','client','code'));
   }

   /**
   * Job budget
   **/
   public function budget($jobCode){
      return view('app.jobs.job.budget');
   }

   /**
   * Users
   **/
   public function users($code){
      return view('app.jobs.job.users', compact('code'));
   }

   /**
   * activity
   **/
   public function activity($jobCode){
      return view('app.jobs.job.activity');
   }

   /**
   * settings
   **/
   public function settings($jobCode){
      return view('app.jobs.job.settings');
   }

   /**
   * delete project
   **/
   public function destroy($code){
      $project = jobs::where('id',$code)->where('business_code',Auth::user()->business_code)->first();
      $task = tasks::where('projectID',$code)->where('business_code',Auth::user()->business_code)->first();
      $taskCount = tasks::where('projectID',$code)->where('business_code',Auth::user()->business_code)->count();
      comments::where('projectID',$code)->where('business_code',Auth::user()->business_code)->delete();
      group::where('projectID',$code)->where('business_code',Auth::user()->business_code)->delete();
      if($taskCount != "0"){
         allocation::where('taskID',$task->id)->delete();
         $task->delete();
      }

      //recored activity
      $activities = $project->job_title.' Project  has been deleted by '.Auth::user()->name;
      $section = 'Project management';
      $type = 'Delete';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $business_code = Auth::user()->business_code;

      $project->delete();

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','Project successfully added');

      return redirect()->route('jb_jobs.index','all');
   }

}
