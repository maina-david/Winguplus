<?php

namespace App\Http\Livewire\Crm\Deals;

use App\Models\crm\call_log;
use App\Models\crm\deals\appointments;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\tasks;
use App\Models\crm\leads\notes;
use App\Models\finance\customer\customers;
use App\Models\wingu\wp_user;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;

class Grid extends Component
{
   public $pipelineCode,$dealEdit,$dealCode,$deleteType,$deleteCode,$stageModal;
   public $stageCode,$title,$value,$close_date,$owner,$contact,$description,$status,$stage_title,$color;

   public function render()
   {
      if($this->pipelineCode){
         $pipeCode = $this->pipelineCode;
         $pipeline = pipeline::where('pipeline_code',$pipeCode)->where('business_code',Auth::user()->business_code)->first();
      }else{
         $pipeline = pipeline::where('default_value','Yes')->where('business_code',Auth::user()->business_code)->first();
         $pipeCode = $pipeline->pipeline_code;
         $this->pipelineCode = $pipeCode;
      }

      $stages = stages::where('pipeline_code',$pipeCode)->where('business_code',Auth::user()->business_code)->get();

      //users
      $users = wp_user::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      //customer
      $customers = customers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      //business
      $business = Wingu::business();

      //lines
      $lines = pipeline::where('business_code',Auth::user()->business_code)->get();

      return view('livewire.crm.deals.grid', compact('pipeline','stages','users','customers','business','lines'));
   }

   //field reset
   public function restFields(){
      $this->title       = "";
      $this->value       = "";
      $this->contact     = "";
      $this->owner       = "";
      $this->status      = "";
      $this->close_date  = "";
      $this->description = "";
      $this->dealEdit    = "";
      $this->dealCode    = "";
      $this->stage_title = "";
      $this->color       = "";
   }

   //add deal
   public function add_deal($code){
      $this->stageCode = $code;
   }

   //store deal
   public function store_deal(){
      $this->validate([
         'title' => 'required',
      ]);

      $deals = new deals;
      $deals->deal_code     = Helper::generateRandomString(30);
      $deals->title         = $this->title;
      $deals->pipeline      = $this->pipelineCode;
      $deals->stage         = $this->stageCode;
      $deals->value         = $this->value;
      $deals->contact       = $this->contact;
      $deals->owner         = $this->owner;
      $deals->status        = $this->status;
      $deals->close_date    = $this->close_date;
      $deals->description   = $this->description;
      $deals->business_code = Auth::user()->business_code;
      $deals->created_by    = Auth::user()->user_code;
      $deals->save();

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new deal <a href="'.route('crm.deals.show',$deals->deal_code ).'">'.$this->title.'</a>';
		$module       = 'CRM';
		$section      = 'Deal';
      $action       = 'Create';
		$activityCode = $deals->deal_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Deal successfully added"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit deal
   public function edit_deal($code){
      $this->dealEdit = 'on';
      $edit = deals::where('business_code',Auth::user()->business_code)->where('deal_code',$code)->first();
      $this->title       = $edit->title;
      $this->value       = $edit->value;
      $this->contact     = $edit->contact;
      $this->owner       = $edit->owner;
      $this->status      = $edit->status;
      $this->close_date  = $edit->close_date;
      $this->description = $edit->description;
      $this->dealCode    = $code;
   }

   //update deal
   public function update_deal(){
      $this->validate([
         'title' => 'required',
      ]);

      $deals                = deals::where('business_code',Auth::user()->business_code)->where('deal_code',$this->dealCode)->first();
      $deals->title         = $this->title;
      $deals->pipeline      = $this->pipelineCode;
      $deals->value         = $this->value;
      $deals->contact       = $this->contact;
      $deals->owner         = $this->owner;
      $deals->status        = $this->status;
      $deals->close_date    = $this->close_date;
      $deals->description   = $this->description;
      $deals->updated_by    = Auth::user()->user_code;
      $deals->save();

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> deal details for <a href="'.route('crm.deals.show',$deals->deal_code ).'">'.$this->title.'</a>';
		$module       = 'CRM';
		$section      = 'Deal';
      $action       = 'Edit';
		$activityCode = $deals->deal_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Deal successfully updated"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //add stage
   public function add_stage(){
      $this->stageModal = 'add';
   }

   //store stage
   public function store_stage(){

      $stage = new stages;
      $stage->stage_code    = Helper::generateRandomString(30);
      $stage->title         = $this->stage_title;
      $stage->color         = $this->color;
      $stage->pipeline_code = $this->pipelineCode;
      $stage->business_code = Auth::user()->business_code;
      $stage->created_by    = Auth::user()->user_code;
      $stage->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Pipeline stage successfully added"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit stage
   public function edit_stage($code){
      $this->stageCode   = $code;
      $stage             = stages::where('business_code',Auth::user()->business_code)->where('stage_code',$code)->first();
      $this->stage_title = $stage->title;
      $this->color       = $stage->color;
   }

   //update stage
   public function update_stage(){
      $update = stages::where('business_code',Auth::user()->business_code)->where('stage_code',$this->stageCode)->first();
      $update->title = $this->stage_title;
      $update->color = $this->color;
      $update->updated_by = Auth::user()->user_code;
      $update->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Pipeline stage successfully updated"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //delete alert
   public function delete_alert($code,$type){
      $this->deleteCode = $code;
      $this->deleteType = $type;
   }

   //delete deal
   public function delete_deal(){
      deals::where('business_code',Auth::user()->business_code)->where('deal_code',$this->deleteCode)->delete();

      call_log::where('parent_code',$this->deleteCode)->where('business_code',Auth::user()->business_code)->where('section','Deal')->delete();

      notes::where('parent_code',$this->deleteCode)->where('business_code',Auth::user()->business_code)->where('section','Deal')->delete();

      tasks::where('business_code',Auth::user()->business_code)->where('deal_code',$this->deleteCode)->delete();

      appointments::where('deal_code',$this->deleteCode)->where('business_code',Auth::user()->business_code)->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Deal successfully deleted"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //delete stage
   public function delete_stage(){
      $stage = stages::where('stage_code',$this->deleteCode)->where('business_code',Auth::user()->business_code)->first();
      $deals = deals::where('business_code',Auth::user()->business_code)->where('stage',$stage->stage_code)->get();
      foreach($deals as $deal){
         deals::where('business_code',Auth::user()->business_code)->where('deal_code',$deal->deal_code)->delete();

         call_log::where('parent_code',$deal->deal_code)->where('business_code',Auth::user()->business_code)->where('section','Deal')->delete();

         notes::where('parent_code',$deal->deal_code)->where('business_code',Auth::user()->business_code)->where('section','Deal')->delete();

         tasks::where('business_code',Auth::user()->business_code)->where('deal_code',$deal->deal_code)->delete();

         appointments::where('deal_code',$deal->deal_code)->where('business_code',Auth::user()->business_code)->delete();
      }
      $stage->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Pipeline stage successfully deleted"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }
}
