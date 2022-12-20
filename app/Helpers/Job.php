<?php
namespace App\Helpers;
use App\Models\job\allocation;
use App\Models\jobs\comments;
use App\Models\jobs\events;
use App\Models\jobs\goal_progress;
use App\Models\jobs\group;
use App\Models\jobs\jobs;
use App\Models\jobs\leaders;
use App\Models\jobs\members;
use App\Models\jobs\notes;
use App\Models\jobs\priority;
use App\Models\jobs\task_allocation;
use App\Models\jobs\tasks;
use App\Models\jobs\ticket_allocation;
use App\Models\jobs\tickets;
use App\Models\wingu\file_manager;
use Auth;
use DB;

class Job
{
   /*=================================== discussions =================================== */
   //attachments per comment
   public static function comment_attachments($code){
      $count = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }


   /*=================================== Tasks =================================== */
   //tasks information
   public static function task_info($code){
      $info = tasks::where('task_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return $info;
   }

   //tasks check
   public static function check_task($code){
      $check = tasks::where('task_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return $check;
   }

   //count tasks per job
   public static function count_task_per_job($code){
      $count = tasks::where('job',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //count task by status
   public static function count_task_per_status($code,$status){
      $count = tasks::where('job',$code)->where('business_code',Auth::user()->business_code)->where('status',$status)->count();
      return $count;
   }

   public static function task_allocations($code){
      $allocation = task_allocation::where('task',$code)->where('business_code',Auth::user()->business_code)->get();
      return $allocation;
   }

   public static function check_priority($id){
      $check = priority::where('id',$id)->count();
      return $check;
   }

   //tasks per group
   public static function group_tasks($code){
      $tasks = tasks::where('group',$code)
                     ->where('business_code',Auth::user()->business_code)
                     ->orderby('id','desc')
                     ->get();
      return $tasks;
   }

   //count task attachments
   public static function task_attachments($code){
      $attachments = file_manager::where('parent_link',$code)->where('business_code',Auth::user()->business_code)->get();
      return $attachments;
   }

   //tasks comments
   public static function task_comments($code){
      $comments = comments::where('task',$code)->where('business_code',Auth::user()->business_code)->get();
      return $comments;
   }

   //tasks comment replies
   public static function task_comment_replies($code,$comment){
      $comments = comments::where('task',$code)->where('parent',$comment)->where('business_code',Auth::user()->business_code)->get();
      return $comments;
   }

   //count incomplete tasks per user
   public static function count_incomplete_tasks_per_user(){
      $count = tasks::join('pr_job_tasks_allocation','pr_job_tasks_allocation.task','=','pr_job_tasks.task_code')
                     ->where('business_code',Auth::user()->business_code)
                     ->where('user',Auth::user()->id)
                     ->where('status','!=',7)
                     ->where('due_date', '<', DB::raw('NOW()'))
                     ->count();
      return $count;
   }

   //count all incomplete tasks
   public static function count_all_incomplete(){
      $count = tasks::join('pr_job_tasks_allocation','pr_job_tasks_allocation.task','=','pr_job_tasks.task_code')
                     ->where('business_code',Auth::user()->business_code)
                     ->where('status','!=',7)
                     ->where('due_date', '<', DB::raw('NOW()'))
                     ->count();

      return $count;
   }

   /*=================================== job =================================== */
   //job info
   public static function job_details($code){
      $query = jobs::where('job_code',$code)->where('business_code',Auth::user()->business_code);

      $job = $query->first();
      $check = $query->count();

      return response()->json([
         "details" => $job,
         "check"   => $check,
      ]);
   }

   //count comments per job
   public static function count_comments_per_job($code){
      $count = comments::where('job',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //get job leaders
   public static function job_leaders($code){
      $leaders = leaders::where('job',$code)->where('business_code',Auth::user()->business_code)->get();
      return $leaders;
   }

   //Count tasks per job
   public static function count_job_tasks($code){
      $tasks = tasks::where('job',$code)->where('business_code',Auth::user()->business_code)->count();
      return $tasks;
   }

   //groups per job
   public static function count_job_groups($code){
      $count = group::where('job',$code)->count();
      return $count;
   }

   //count tasks per job by status
   public static function count_job_per_status($status,$code){
      $count = tasks::where('status',$status)->where('job',$code)->count();
      return $count;
   }

   //count discussions per job
   public static function count_job_comments($id){
      $count = comments::where('job',$id)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //count files per job
   public static function count_job_attachments($code){
      $count = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //count tickets per job
   public static function count_job_tickets($code){
      $count = tickets::where('job',$code)->count();
      return $count;
   }

   //count notes per job
   public static function count_job_note($code){
      $count = notes::where('job',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //count events per job
   public static function count_job_events($code){
      $count = events::where('job',$code)->where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //count account job
   public static function count_jobs(){
      $count = jobs::where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   /*=================================== tickets =================================== */
   //ticket allocation
   public static function ticket_allocations($id){
      $allocation = ticket_allocation::where('ticketID',$id)->get();
      return $allocation;
   }

   //count tickets comments
   public static function count_ticket_comments($id){
      $comments = comments::where('ticketID',$id)->count();
      return $comments;
   }

   //count task attachments
   public static function count_ticket_attachments($id){
      $attachments = file_manager::where('fileID',$id)->where('section','Ticket')->where('business_code',Auth::user()->business_code)->count();
      return $attachments;
   }

   /*=================================== members =================================== */
   //check if user is a job member
   public static function check_if_job_member($jobCode,$userCode){
      $check = members::where('business_code',Auth::user()->business_code)->where('user_code',$userCode)->where('job_code',$jobCode)->count();
      return $check;
   }

   /*=================================== goals =================================== */
   public static function calculate_goal_progress($code,$achievement){
      $query = goal_progress::where('goal_code',$code)->where('business_code',Auth::user()->business_code)->get();

      if($query->sum('achievement') > 0 && $achievement > 0){
         $progress = ($query->sum('achievement')/$achievement) * 100;
      }else{
         $progress = 0;
      }

      return response()->json([
         "total_achievement" => $query->sum('achievement'),
         "percentage"        => number_format($progress),
      ]);
   }
}
