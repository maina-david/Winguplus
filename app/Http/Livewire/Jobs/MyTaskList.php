<?php

namespace App\Http\Livewire\Jobs;

use App\Models\jobs\comments;
use Livewire\WithPagination;
use App\Models\jobs\tasks;
use App\Models\jobs\group;
use App\Models\jobs\jobs;
use App\Models\jobs\members;
use App\Models\jobs\sections;
use App\Models\jobs\task_allocation;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;

class MyTaskList extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $view = 'All';
   public $status,$projects,$search;

   protected $listeners = ['view_task'];

   public $jobCode,$taskCode;
   public $taskDetails = [];
   public $task_status,$task_title,$start_date,$due_date,$priority,$details,$job;
   public $reply,$taskReplyCode,$parent_comment,$comments;
   public $editTask="off",$editTaskCode;
   public $taskView="off";
   public $currentView,$checklist_task, $checklistItems;

   //delete
   public $deleteType,$deleteCode;

   public function render()
   {
      $today = date('Y-m-d');

      //all tasks
      $mainQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code);
                              if($this->status){
                                 $mainQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $mainQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $mainQuery->where('jb_tasks.job',$this->projects);
                              }
      $allTasks = $mainQuery->orderby('jb_tasks.start_date','desc')
                           ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                           ->get();

      //todays tasks
      $todaysTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code)
                              ->where('jb_tasks.due_date',$today);
                              if($this->status){
                                 $todaysTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $todaysTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $todaysTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $todaysTasks = $todaysTasksQuery->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Tomorrow
      $tomorrow = date("Y-m-d", strtotime("+1 day"));
      $tomorrowTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code)
                              ->where('jb_tasks.due_date',$tomorrow);
                              if($this->status){
                                 $tomorrowTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $tomorrowTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $tomorrowTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $tomorrowTasks = $tomorrowTasksQuery->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Next 7 Days
      $next7Days = date("Y-m-d", strtotime("+7 day"));
      $next7DaysTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code)
                              ->where('jb_tasks.due_date',$next7Days);
                              if($this->status){
                                 $next7DaysTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $next7DaysTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $next7DaysTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $next7DaysTasks = $next7DaysTasksQuery->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Past Due
      $pastDueTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code)
                              ->where('jb_tasks.due_date','<=',$today);
                              if($this->status){
                                 $pastDueTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $pastDueTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $pastDueTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $pastDueTasks = $pastDueTasksQuery->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Pending
      $pendingTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code);
                              if($this->status){
                                 $pendingTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $pendingTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $pendingTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $pendingTasks = $pendingTasksQuery->where('jb_tasks.status',7)
                              ->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Waiting Approval
      $waitingApprovalTasksQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code);
                              if($this->status){
                                 $waitingApprovalTasksQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $waitingApprovalTasksQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $waitingApprovalTasksQuery->where('jb_tasks.job',$this->projects);
                              }

      $waitingApprovalTasks = $waitingApprovalTasksQuery->where('jb_tasks.status',62)
                              ->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      //Completed
      $completeQuery = task_allocation::join('jb_tasks','jb_tasks.task_code','=','jb_task_allocations.task')
                              ->where('jb_task_allocations.user',Auth::user()->user_code)
                              ->where('jb_tasks.business_code',Auth::user()->business_code);
                              if($this->status){
                                 $completeQuery->where('jb_tasks.status',$this->status);
                              }
                              if($this->search){
                                 $completeQuery->where('jb_tasks.title','like','%'.$this->search.'%');
                              }
                              if($this->projects){
                                 $completeQuery->where('jb_tasks.job',$this->projects);
                              }

      $completeTasks = $completeQuery->where('jb_tasks.status',16)
                              ->orderby('jb_tasks.start_date','desc')
                              ->select('*','jb_tasks.business_code as business_code','jb_tasks.status as status','jb_tasks.task_code as task_code','jb_tasks.job as job_code')
                              ->get();

      $jobs = jobs::where('business_code',Auth::user()->business_code)->select('job_code','job_title')->orderby('id','DESC')->get();


      return view('livewire.jobs.my-task-list', compact('allTasks','todaysTasks','tomorrowTasks','next7DaysTasks','pastDueTasks','pendingTasks','waitingApprovalTasks','completeTasks','jobs'));
   }

   //reset field
   public function restFields(){
      $this->title = "";
      $this->priority = "";
      $this->details = "";
      $this->due_date = "";
      $this->start_date = "";
      $this->task_title = "";
      $this->task_status = "";
      $this->priority = "";
      $this->checklist_task = "";
   }

   //change view
   public function change_view($section){
      $this->view = $section;
      $this->emit('refreshComponent');
   }

   //add task
   public function add_task(){
      $this->validate([
         'task_title' => 'required',
      ]);

      $taskCode = Helper::generateRandomString(20);
      $task = new tasks;
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

      $this->emit('popModal');
   }

   //edit task
   public function edit_task($code){
      $this->editTask = "on";
      $this->taskView = "off";
      $edit = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
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

      $update = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
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

      $details = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $taskComments = comments::join('wp_users','wp_users.user_code','=','jb_comments.created_by')
                        ->where('jb_comments.task',$code)
                        ->where('jb_comments.business_code',Auth::user()->business_code)
                        ->orderby('jb_comments.id','desc')
                        ->select('jb_comments.created_at as comment_date','wp_users.name as user_name','jb_comments.comment as user_comment','wp_users.avatar as profile_picture')
                        ->get();

      //check list
      $getCheckList = tasks::where('parent',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

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
      $task = new tasks;
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
      $update = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$checkListCode)->first();
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
      $task = tasks::where('task_code',$checkListCode)->where('business_code',Auth::user()->business_code)->first();

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
      $task = tasks::where('task_code',$code)->where('business_code',Auth::user()->business_code)->first();

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
}
