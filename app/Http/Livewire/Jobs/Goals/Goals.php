<?php

namespace App\Http\Livewire\Jobs\Goals;

use App\Models\jobs\goal_progress;
use App\Models\jobs\goals as JobsGoals;
use App\Models\jobs\jobs;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;
use Helper;

class Goals extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $title,$achievement,$start_date,$end_date,$description,$type;
   public $progress_from,$progress_achievement,$progress_to,$progress_note;
   public $jobCode,$goalCode,$deleteType,$editMode,$goalDetails,$progresses,$progressCode;
   public $search;

   public function updatingSearch()
   {
      $this->resetPage();
   }
   
   public function render()
   {
      $job = jobs::join('wp_status','wp_status.id','=','jb_jobs.status')
                  ->where('jb_jobs.job_code',$this->jobCode)
                  ->where('business_code',Auth::user()->business_code)
                  ->select('*','jb_jobs.job_code as job_code')
                  ->first();

      $query = JobsGoals::where('job_code',$this->jobCode);
                        if($this->search){
                           $query->where('title','like','%'.$this->search.'%');
                        }
      $goals = $query->where('business_code',Auth::user()->business_code)
                     ->orderBy('id','desc')
                     ->get();

      return view('livewire.jobs.goals.goals', compact('job','goals'));
   }

   //rest value
   public function restFields(){
      $this->title       = "";
      $this->achievement = "";
      $this->start_date  = "";
      $this->end_date    = "";
      $this->description = "";
      $this->type        = "";
      $this->editMode    = "";
      $this->deleteType  = "";
      $this->goalDetails = "";
   }

   //restProgressFields
   public function restProgressFields(){
      $this->progress_from  = "";
      $this->progress_achievement = "";
      $this->progress_to = "";
      $this->progress_note = "";
   }

   //store goal
   public function store_goal(){
      $this->validate([
         'title' => 'required',
         'achievement' => 'required',
         'start_date' => 'required',
         'end_date' => 'required',
         'description' => 'required',
         'type' => 'required',
      ]);

      $addGoals                = new JobsGoals;
      $addGoals->goal_code     = Helper::generateRandomString(30);
      $addGoals->job_code      = $this->jobCode;
      $addGoals->title         = $this->title;
      $addGoals->achievement   = $this->achievement;
      $addGoals->start_date    = $this->start_date;
      $addGoals->end_date      = $this->end_date;
      $addGoals->description   = $this->description;
      $addGoals->goal_type     = $this->type;
      $addGoals->business_code = Auth::user()->business_code;
      $addGoals->created_by    = Auth::user()->user_code;
      $addGoals->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Goal created successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit goal
   public function edit_goal($code){
      $editGoal = JobsGoals::where('goal_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->title       = $editGoal->title;
      $this->achievement = $editGoal->achievement;
      $this->start_date  = $editGoal->start_date;
      $this->end_date    = $editGoal->end_date;
      $this->description = $editGoal->description;
      $this->editMode    = 'on';
      $this->goalCode    = $code;
   }

   //update goal
   public function update_goal(){
      $this->validate([
         'title' => 'required',
         'achievement' => 'required',
         'start_date' => 'required',
         'end_date' => 'required',
         'description' => 'required',
         'type' => 'required',
      ]);

      $updateGoal = JobsGoals::where('goal_code',$this->goalCode)->where('business_code',Auth::user()->business_code)->first();
      $updateGoal->title         = $this->title;
      $updateGoal->achievement   = $this->achievement;
      $updateGoal->start_date    = $this->start_date;
      $updateGoal->end_date      = $this->end_date;
      $updateGoal->description   = $this->description;
      $updateGoal->goal_type     = $this->type;
      $updateGoal->updated_by    = Auth::user()->user_code;
      $updateGoal->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Goal updated successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //goal details
   public function goal_details($code){
      $details = JobsGoals::where('goal_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->goalDetails = $details;
      $this->goalCode = $code;

      //progress
      $getProgress = goal_progress::where('goal_code',$code)->where('business_code',Auth::user()->business_code)->get();
      $this->progresses = $getProgress;
   }

   //add progress
   public function add_progress(){
      $addProgress                = new goal_progress;
      $addProgress->achievement   = $this->progress_achievement;
      $addProgress->from_date     = $this->progress_from;
      $addProgress->to_date       = $this->progress_to;
      $addProgress->goal_code     = $this->goalCode;
      $addProgress->note          = $this->progress_note;
      $addProgress->progress_code = Helper::generateRandomString(30);
      $addProgress->business_code = Auth::user()->business_code;
      $addProgress->created_by    = Auth::user()->user_code;
      $addProgress->save();

       // Set Flash Message
       $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Progress added successfully"
      ]);

      $this->restProgressFields();

      $this->emit('progress');
   }

   //delete
   public function delete($code,$type){
      $this->goalCode   = $code;
      $this->progressCode = $code;
      $this->deleteType = $type;
   }

   //delete goal
   public function delete_goal(){
      dd('delete goal');

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Goal deleted successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //delete progress
   public function delete_progress(){

      goal_progress::where('progress_code',$this->progressCode)->where('business_code',Auth::user()->business_code)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Progress deleted successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');

      $this->restProgressFields();
      $this->emit('progress');
   }

   //close progress
   public function close_progress(){
      $this->restProgressFields();
      $this->emit('progress');
   }
}
