<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\jobs\jobs;
use App\Models\jobs\tasks;
use App\Models\jobs\priority;
use App\Models\jobs\allocation;
use App\Models\jobs\group;
use App\Models\wingu\file_manager;
use App\Models\jobs\comments;
use App\Models\jobs\leaders;
use App\Models\wingu\wp_user;
use Helper;
use Auth;
use Session;
use Prm;
use Wingu;
use File;
use DB;

class taskController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function all(){
      $tasks = tasks::OrderBy('due_date','DESC')->where('business_code',Auth::user()->business_code)->paginate(10);
      return view('app.jobs.tasks.all', compact('tasks'));
   }

   public function tasks($code){
      return view('app.jobs.tasks.tasks', compact('code'));
   }

   /**
   * task section
   **/
   public function section($code,$section,$name){
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

      return view('app.jobs.tasks.section', compact('job','leaders','client','code','section'));
   }


   /**
   * Add comment
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function comment(Request $request){

      $comment = new comments;
      $code = Helper::generateRandomString(20);
      $comment->comment_code  = $code;
      $comment->job           = $request->jobCode;
      $comment->task          = $request->taskCode;
      $comment->comment       = $request->comment;
      $comment->created_by    = Auth::user()->user_code;
      $comment->business_code = Auth::user()->business_code;
      $comment->save();

      if($request->file_title){
         $filetitle = $request->file_title;
      }else{
         $filetitle = 'Task files';
      }

      /*==== upload attachment ====*/
      if($request->comment_files){
         //directory
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$request->jobCode.'/';
         if(!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         //
         $documents = $request->comment_files;

         foreach($documents as $doc) {
            $size =  $doc->getSize();

            // GET THE FILE EXTENSION
            $extension = $doc->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $doc->move($path, $fileName);

            $upload = new file_manager;
            $upload->file_code     = $code;
            $upload->parent_link   = $request->taskCode;
            $upload->folder 	     = 'Jobs';
            $upload->section 	     = 'Tasks';
            $upload->name 		     = $filetitle;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->file_mime     = $doc->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      //recored activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has add a comment to his allocated job.';
      $module       = 'Jobs Management';
      $section      = 'Task comments';
      $action       = 'Create';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Comment added successfully');

      return redirect()->back();
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  string  $jobcode,$taskcode
   * @return \Illuminate\Http\Response
   */
   public function complete($jobcode,$taskcode){
      $update = tasks::where('job',$jobcode)->where('business_code',Auth::user()->business_code)->where('task_code',$taskcode)->first();
      $update->status = 16;
      $update->close_date = date("Y-m-d");
      $update->save();

      Session::flash('success','Task marked as complete');

      return redirect()->back();
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($projectID,$id)
   {
      tasks::where('projectID',$projectID)->where('id',$id)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','The task was deleted successfully');

      return redirect()->back();
   }


   //group_change
   public function group_change(Request $request){
      //update task group
      $update = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$request->task_code)->first();
      $update->group = $request->group_code;
      $update->updated_by = Auth::user()->user_code;
      $update->save();

      $group = group::where('business_code',Auth::user()->business_code)->where('group_code',$request->group_code)->first();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>moved</b> task#<i>'.$update->title.'</i> to <i>'.$group->name.'</i></a>';
		$module       = 'Project Management';
		$section      = 'Tasks';
      $action       = 'Edit';
		$activityCode = $request->group_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);
   }
}
