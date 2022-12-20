<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\wingu\file_manager;
use Livewire\WithFileUploads;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;
use File;

class Sponsors extends Component
{
   use WithFileUploads;

   public $eventCode,$editCode;
   public $sponsor_name,$logo;

   public function render()
   {
      $sponsors = file_manager::where('file_code',$this->eventCode)->where('business_code',Auth::user()->business_code)->get();

      return view('livewire.events.events.sponsors', compact('sponsors'));
   }

   //reset
   public function restFields(){
      $this->sponsor_name = "";
      $this->logo = "";
      $this->editCode = "";
   }

   //store file
   public function save_sponsor(){
      $this->validate([
         'sponsor_name' => 'required',
         'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $path = base_path().'app/public/account/businesses/'.Wingu::business()->business_code.'/events/';

      $folder = 'public/account/businesses/'.Wingu::business()->business_code.'/events/';

      if(!file_exists($path)) {
         mkdir($path, 0777,true);
      }

      // GET THE FILE EXTENSION
      $extension = $this->logo->getClientOriginalExtension();
      // RENAME THE UPLOAD WITH RANDOM NUMBER
      $fileName = Helper::generateRandomString(30). '.' . $extension;

      $this->logo->storeAs($folder, $fileName);

      $sponsor = new file_manager;
      $sponsor->file_code     = $this->eventCode;
      $sponsor->business_code = Auth::user()->business_code;
      $sponsor->file_name     = $fileName;
      $sponsor->name          = $this->sponsor_name;
      $sponsor->section       = 'Event Manager';
      $sponsor->folder        = 'Sponsors';
      $sponsor->created_by    = Auth::user()->user_code;
      $sponsor->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added a sponsor';
      $module     = 'Event Manager';
      $section    = 'Sponsors';
      $action     = 'Create';
      $activityID = $this->eventCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Sponsor added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit
   public function edit($id){
      $edit = file_manager::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $this->editCode     = $id;
      $this->sponsor_name = $edit->name;
   }

   //update
   public function update(){
      $this->validate([
         'sponsor_name' => 'required',
      ]);

      $sponsor = file_manager::where('id',$this->editCode)->where('business_code',Auth::user()->business_code)->first();

      if($this->logo){
         $this->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         $path = base_path().'app/public/account/businesses/'.Wingu::business()->business_code.'/events/';

         //delete logo
         $unlinkPath = public_path('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$sponsor->file_name);
         unlink($unlinkPath);

         $folder = 'public/account/businesses/'.Wingu::business()->business_code.'/events/';

         if(!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         // GET THE FILE EXTENSION
         $extension = $this->logo->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;

         $this->logo->storeAs($folder, $fileName);
         $sponsor->file_name     = $fileName;
      }

      $sponsor->file_code     = $this->eventCode;
      $sponsor->name          = $this->sponsor_name;
      $sponsor->section       = 'Event Manager';
      $sponsor->folder        = 'Sponsors';
      $sponsor->updated_by    = Auth::user()->user_code;
      $sponsor->save();

      //recorded activity
      $activities = Auth::user()->name.' Has updated <a class="font-bold" href="#>'.$this->sponsor_name.'</a> sponsor details';
      $module     = 'Event Manager';
      $section    = 'Sponsors';
      $action     = 'Create';
      $activityID = $this->eventCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Sponsor added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }

   //confirm delete
   public function confirm_delete($code){
      $this->editCode = $code;
   }

   //delete
   public function delete(){
      $delete = file_manager::where('id',$this->editCode)->where('business_code',Auth::user()->business_code)->first();

      //delete logo
      $unlinkPath = public_path('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$delete->file_name);
      unlink($unlinkPath);

      $activities = Auth::user()->name.' Has delete a sponsor logo  <a class="font-bold" href="#>'.$delete->name.'</a>';
      $module     = 'Event Manager';
      $section    = 'Sponsors';
      $action     = 'Delete';
      $activityID = $this->eventCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Sponsor deleted successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

}
