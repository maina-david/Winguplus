<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\jobs\jobs;
use App\Models\wingu\file_manager;
use Livewire\Component;
use Auth;
use Wingu;
use File;

class Files extends Component
{
   public $jobCode;
   public $file_name;
   public $fileCode;
   public $fileID;

   public function render()
   {
      $query = file_manager::where('file_code',$this->jobCode)
                           ->where('business_code',Auth::user()->business_code);
                           if($this->file_name){
                              $query->where('name','like','%'.$this->file_name.'%');
                           }
      $files = $query->orderby('id','desc')->get();

      return view('livewire.jobs.job.files', compact('files'));
   }

   //delete alert
   public function delete_alert($code,$id){
      $this->fileCode = $code;
      $this->fileID = $id;
   }

   //delete file
   public function delete($code,$id){

      $delete = file_manager::where('file_code',$code)->where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$delete->file_code.'/';

      //delete document if already exists
      if($delete->file_name){
         $unlink = $path.$delete->file_name;
         if(File::exists($unlink)) {
            unlink($unlink);
         }
      }

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> a file titled <b><a href="#">'.$delete->name.'</a></b>';
		$module       = 'Jobs Management';
		$section      = 'Job File';
      $action       = 'Delete';
		$activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      //delete
      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"File deleted succesfully"
      ]);

      $this->fileCode = "";

      $this->emit('popModal');
   }

   //close delete
   public function delete_close(){
      $this->fileCode = "";
      $this->fileID = "";
      $this->emit('popModal');
   }
}
