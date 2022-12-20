<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Helpers\Wingu;
use App\Models\jobs\comments;
use App\Models\jobs\group;
use App\Models\jobs\jobs;
use App\Models\jobs\members;
use App\Models\jobs\sections;
use App\Models\jobs\task_allocation;
use App\Models\jobs\tasks as JobsTasks;
use App\Models\wingu\file_manager;
use File;
use Auth;
use Helper;
use Livewire\Component;

class Tasks extends Component
{
   protected $listeners = ['view_task'];

   public $jobCode;
   public $taskDetails = [];
   public $group_title,$groupCode,$taskCode,$color,$section_code,$group_section;
   public $task_status,$task_title,$start_date,$due_date,$priority,$details;
   public $assignMembers = [];
   public $reply,$taskReplyCode,$parent_comment,$comments;
   public $editTask="off",$editTaskCode;
   public $taskView="off";
   public $currentView,$checklist_task, $checklistItems;
   public $editGroupModal="off",$groupEditCode;

   //delete
   public $deleteType,$deleteCode;

   public function render()
   {
      $job = jobs::join('wp_status','wp_status.id','=','jb_jobs.status')
                  ->where('jb_jobs.job_code',$this->jobCode)
                  ->where('business_code',Auth::user()->business_code)
                  ->select('*','jb_jobs.job_code as job_code')
                  ->first();
      $code = $this->jobCode;
      $groups = group::where('business_code',Auth::user()->business_code)
                     ->where('job',$code)
                     ->whereNull('section_code')
                     ->orderby('id','asc')
                     ->get();
      $members = members::join('wp_users','wp_users.user_code','=','jb_job_member.user_code')
                        ->where('job_code',$code)
                        ->where('jb_job_member.business_code',Auth::user()->business_code)
                        ->select('name','avatar','jb_job_member.user_code as user_code')
                        ->get();
      $sections = sections::where('job_code',$this->jobCode)->orderby('id','desc')->get();

      return view('livewire.jobs.job.tasks', compact('job','code','groups','members','sections'));
   }

   //reset field
   public function restFields(){
      $this->title = "";
      $this->priority = "";
      $this->details = "";
      $this->due_date = "";
      $this->start_date = "";
      $this->assignMembers = [];
      $this->task_title = "";
      $this->task_status = "";
      $this->priority = "";
      $this->checklist_task = "";
      $this->section_title = "";
   }

   //add task group
   public function add_task_group(){

      $this->validate([
         'group_title' => 'required',
      ]);

      $group = new group;
      $group->group_code    = Helper::generateRandomString(20);
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->job           = $this->jobCode;
      $group->section_code = $this->group_section;
      $group->name          = $this->group_title;
      $group->section_code  = $this->group_section;
      $group->color         = $this->color;
      $group->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task group added succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');

      $this->taskView = "off";

      $this->editGroupModal = "off";
   }

   //edit group
   public function editGroup($code){
      $this->editGroupModal = "on";
      $group = group::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();
      $this->group_title = $group->name;
      $this->group_section = $group->section_code;
      $this->color = $group->color;
      $this->groupEditCode = $code;

      $this->editTask = "off";
      $this->taskView = "off";
      $this->restFields();
   }

   //edit group
   public function update_group($code){
      $group = group::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();
      $group->name = $this->group_title;
      $group->color = $this->color;
      $group->section_code = $this->group_section;
      $group->save();

      $this->editTask = "off";
      $this->taskView = "on";
      $this->editGroupModal = "off";

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Group title updated succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');
   }

   //add task modal
   public function addTaskModal($code){
      $this->groupCode = $code;
      $this->emit('ckeditor');
      $this->taskView = "off";
      $this->restFields();
   }

   //add task
   public function add_task(){
      $this->validate([
         'task_title' => 'required',
      ]);

      $taskCode = Helper::generateRandomString(20);
      $task = new JobsTasks;
      $task->task_code =  $taskCode;
      $task->job = $this->jobCode;
      $task->group = $this->groupCode;
      $task->priority = $this->priority;
      $task->title = $this->task_title;
      $task->details = $this->details;
      $task->due_date = $this->due_date;
      $task->start_date = $this->start_date;
      if($this->task_status == 16){
         $task->status     = $this->task_status;
         $task->close_date = date("Y-m-d");
      }else{
         $task->status     = $this->task_status;
      }
      $task->progress = 0;
      $task->created_by    = Auth::user()->user_code;
      $task->business_code = Auth::user()->business_code;
      $task->save();

		/*==== allocate job to user ====*/
      if(!empty($this->assignMembers)){
   		for($i=0; $i < count($this->assignMembers); $i++ ) {
   			$allocation = new task_allocation;
   			$allocation->task       = $taskCode;
   			$allocation->user       = $this->assignMembers[$i];
            $allocation->created_by = Auth::user()->user_code;
            $allocation->business_code = Auth::user()->business_code;
   			$allocation->save();
   		}
      }

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new task <a href="#">'.$this->task_title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Tasks';
      $action       = 'Create';
		$activityCode = $taskCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task added successfully"
      ]);

      $this->groupCode = "";

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');
   }

   //edit task
   public function edit_task($code){
      $this->editTask = "on";
      $this->taskView = "off";
      $edit = JobsTasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $this->task_title = $edit->title;
      $this->priority = $edit->priority;
      $this->details = $edit->details;
      $this->due_date = $edit->due_date;
      $this->start_date = $edit->start_date;
      $this->task_status = $edit->status;
      $getMembers = members::join('wp_users','wp_users.user_code','=','jb_job_member.user_code')
                        ->where('job_code',$edit->job)
                        ->where('jb_job_member.business_code',Auth::user()->business_code)
                        ->select('name','avatar','jb_job_member.user_code as user_code')
                        ->get();
      $this->members = $getMembers;
      $this->editTaskCode = $code;
      $this->emit('ckeditor');
   }

   //update task
   public function update_task($code){

      $this->validate([
         'task_title' => 'required',
      ]);

      $update = JobsTasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $update->priority      = $this->priority;
      $update->title         = $this->task_title;
      $update->details       = $this->details;
      $update->due_date      = $this->due_date;
      $update->start_date    = $this->start_date;

      if($this->task_status == 16){
         $update->status     = $this->task_status;
         $update->close_date = date("Y-m-d");
      }else{
         $update->status     = $this->task_status;
      }
      $update->updated_by    = Auth::user()->user_code;
      $update->business_code = Auth::user()->business_code;
      $update->save();

		/*==== allocate job to user ====*/
      if(!empty($this->assignMembers)){
         $delete = task_allocation::where('task',$code)->where('business_code',Auth::user()->business_code)->delete();
   		for($i=0; $i < count($this->assignMembers); $i++ ) {
   			$allocation = new task_allocation;
   			$allocation->task          = $code;
   			$allocation->user          = $this->assignMembers[$i];
            $allocation->created_by    = Auth::user()->user_code;
            $allocation->business_code = Auth::user()->business_code;
   			$allocation->save();
   		}
      }

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> <a href="#">'.$this->task_title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Tasks';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task updated succesfully"
      ]);

      $this->editTask = "off";

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('popModal');
   }

   //view task
   public function view_task($code,$view){
      $this->taskCode = $code;
      $this->taskView = "on";
      $this->currentView = $view;

      $details = JobsTasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $taskComments = comments::join('wp_users','wp_users.user_code','=','jb_comments.created_by')
                        ->where('jb_comments.task',$code)
                        ->where('jb_comments.business_code',Auth::user()->business_code)
                        ->orderby('jb_comments.id','desc')
                        ->select('jb_comments.created_at as comment_date','wp_users.name as user_name','jb_comments.comment as user_comment','wp_users.avatar as profile_picture')
                        ->get();

      //check list
      $getCheckList = JobsTasks::where('parent',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      $this->taskDetails    = $details;
      $this->comments       = $taskComments;
      $this->checklistItems = $getCheckList;
      $this->restFields();

      $this->editGroupModal = "off";
      $this->editTask = "off";

   }

   //task detail view change
   public function change_task_view($view,$code){
      $this->currentView = $view;

      $this->emit('view_task',$code,$view);
   }

   //task add checklist
   public function add_checklist($code){
      $this->validate([
         'checklist_task' => 'required',
      ]);

      $taskCode = Helper::generateRandomString(20);
      $task = new JobsTasks;
      $task->task_code     = $taskCode;
      $task->parent        = $code;
      $task->title         = $this->checklist_task;
      $task->created_by    = Auth::user()->user_code;
      $task->business_code = Auth::user()->business_code;
      $task->save();

      $this->taskCode = $code;
      $this->taskView = "on";
      $this->currentView = "checklist";

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new checklist <a href="#">'.$this->checklist_task.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Tasks';
      $action       = 'Create';
		$activityCode = $taskCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->restFields();

      $this->emit('view_task',$code,'checklist');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Checklist added successfully"
      ]);
   }

   //task delete checklist
   public function update_checklist_status($taskCode,$checkListCode,$statusID){
      $update = JobsTasks::where('business_code',Auth::user()->business_code)->where('task_code',$checkListCode)->first();
      $update->status = $statusID;
      $update->close_date = date("Y-m-d");
      $update->save();

      $this->emit('view_task',$taskCode,'checklist');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Checklist status changed"
      ]);
   }

   //task delete checklist
   public function delete_checklist($taskCode,$checkListCode){
      //task
      $task = JobsTasks::where('task_code',$checkListCode)->where('business_code',Auth::user()->business_code)->first();

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> a checklist <a href="#">'.$task->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Tasks';
      $action       = 'Delete';
		$activityCode = $checkListCode;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      //delete task
      $task->delete();

      $this->restFields();

      $this->emit('view_task',$taskCode,'checklist');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Checklist deleted successfully"
      ]);
   }

   //delete alert
   public function delete_alert($code,$type){

      $this->editTask = "off";
      $this->taskView = "off";

      $this->restFields();

      $this->deleteCode = $code;
      $this->deleteType = $type;
   }

   //delete task
   public function delete_task($code){
      //task
      $task = JobsTasks::where('task_code',$code)->where('business_code',Auth::user()->business_code)->first();

      //allocations
      task_allocation::where('task',$code)->where('business_code',Auth::user()->business_code)->delete();

      //delete file
      $files = file_manager::where('parent_link',$code)->where('business_code',Auth::user()->business_code)->get();
      if($files->count()>0){
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$task->job.'/';
         foreach($files as $file){
            $delete = file_manager::where('parent_link',$code)->where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();
            //delete document if already exists
            if($delete->file_name){
               $unlink = $path.$file->file_name;
               if(File::exists($unlink)) {
                  unlink($unlink);
               }
            }
            $delete->delete();
         }
      }

      //comments
      comments::where('task',$code)->where('business_code',Auth::user()->business_code)->delete();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> a task <a href="#">'.$task->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Tasks';
      $action       = 'Delete';
		$activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      //delete task
      $task->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task deleted succesfully"
      ]);

      $this->emit('refreshComponent');

      $this->editTask       = "off";
      $this->taskView       = "off";
      $this->editGroupModal = "on";
      $this->deleteType     = "";
      $this->deleteCode     = "";
      $this->restFields();
      $this->emit('popModal');
   }

   //delete group
   public function delete_group($code){
      //group
      $group = group::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();

      //task
      $tasks = JobsTasks::where('group',$code)->where('business_code',Auth::user()->business_code)->get();
      foreach($tasks as $task){

         $deleteTask = JobsTasks::where('task_code',$task->task_code)->where('business_code',Auth::user()->business_code)->first();
         //allocations
         task_allocation::where('task',$deleteTask->task_code)->where('business_code',Auth::user()->business_code)->delete();

         //delete file
         $files = file_manager::where('parent_link',$deleteTask->task_code)->where('business_code',Auth::user()->business_code)->get();
         if($files->count()>0){
            $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$deleteTask->job.'/';
            foreach($files as $file){
               $delete = file_manager::where('parent_link',$deleteTask->task_code)->where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();
               //delete document if already exists
               if($delete->file_name){
                  $unlink = $path.$file->file_name;
                  if(File::exists($unlink)) {
                     unlink($unlink);
                  }
               }
               $delete->delete();
            }
         }

         //comments
         comments::where('task',$deleteTask->task_code)->where('business_code',Auth::user()->business_code)->delete();

         //delete task
         $deleteTask->delete();
      }

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> a task group <a href="#">'.$group->name.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Task Group';
      $action       = 'Delete';
		$activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      //delete
      $group->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task group deleted succesfully"
      ]);

      $this->emit('refreshComponent');

      $this->editTask       = "off";
      $this->taskView       = "off";
      $this->editGroupModal = "on";
      $this->deleteType     = "";
      $this->deleteCode     = "";
      $this->restFields();
      $this->emit('popModal');
   }

   //close delete
   public function close(){
      $this->editTask       = "off";
      $this->taskView       = "off";
      $this->editGroupModal = "on";
      $this->deleteType     = "";
      $this->deleteCode     = "";
      $this->taskDetails    = "";
      $this->comments       = "";
      $this->taskCode       = "";
      $this->currentView    = "";
      $this->restFields();
      $this->emit('popModal');
   }

   //change status
   public function complete($code){
      $update = JobsTasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $update->status = 16;
      $update->close_date = date("Y-m-d");
      $update->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Task status changed"
      ]);

      $this->editTask       = "off";
      $this->taskView       = "off";
      $this->editGroupModal = "on";
      $this->deleteType     = "";
      $this->deleteCode     = "";
      $this->restFields();

   }
}
