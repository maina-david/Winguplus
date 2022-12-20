<?php

namespace App\Http\Livewire\Events\Events;

use App\Models\events\speakers as WingucrowdSpeakers;
use Livewire\WithFileUploads;
use Livewire\Component;
use Helper;
use Wingu;
use Auth;
use File;
class Speakers extends Component
{
   use WithFileUploads;

   public $eventCode,$editCode;
   public $name,$bio,$designation,$linkedin,$twitter,$facebook,$medium,$youtube,$instagram,$speaker_image;
   public function render()
   {
      $speakers = WingucrowdSpeakers::where('event_code',$this->eventCode)->where('business_code',Auth::user()->business_code)->get();

      return view('livewire.events.events.speakers', compact('speakers'));
   }

   public function restFields(){

      $this->name          = "";
      $this->designation   = "";
      $this->bio           = "";
      $this->linkedin      = "";
      $this->twitter       = "";
      $this->facebook      = "";
      $this->medium        = "";
      $this->youtube       = "";
      $this->instagram     = "";
   }

   //store speaker
   public function add_speaker(){

      $this->validate([
         'name' => 'required',
      ]);

      $speaker = new WingucrowdSpeakers;

      if($this->speaker_image){

         $this->validate([
            'speaker_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

         $speaker->image         = $fileName;
      }

      $speakerCode = Helper::generateRandomString(30);
      $speaker->business_code = Auth::user()->business_code;
      $speaker->event_code    = $this->eventCode;
      $speaker->speaker_code  = $speakerCode;
      $speaker->name          = $this->name;
      $speaker->designation   = $this->designation;
      $speaker->bio           = $this->bio;
      $speaker->linkedin      = $this->linkedin;
      $speaker->twitter       = $this->twitter;
      $speaker->facebook      = $this->facebook;
      $speaker->medium        = $this->medium;
      $speaker->youtube       = $this->youtube;
      $speaker->instagram     = $this->instagram;
      $speaker->created_by    = Auth::user()->user_code;
      $speaker->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added a speaker';
      $module     = 'Event Manager';
      $section    = 'Speakers';
      $action     = 'Create';
      $activityID = $speakerCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Speaker added successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit
   public function edit($code){
      $this->editCode = $code;
      $edit =  WingucrowdSpeakers::where('speaker_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->name        = $edit->name;
      $this->designation = $edit->designation;
      $this->bio         = $edit->bio;
      $this->linkedin    = $edit->linkedin;
      $this->twitter     = $edit->twitter;
      $this->facebook    = $edit->facebook;
      $this->medium      = $edit->medium;
      $this->youtube     = $edit->youtube;
      $this->instagram   = $edit->instagram;
   }

   //update
   public function update(){
      $this->validate([
         'name' => 'required',
      ]);

      $edit =  WingucrowdSpeakers::where('speaker_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();

      if($this->speaker_image){
         $this->validate([
            'speaker_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         $path = base_path().'app/public/account/businesses/'.Wingu::business()->business_code.'/events/';

         if($edit->image){
            //delete logo
            $unlinkPath = public_path('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$edit->image);
            unlink($unlinkPath);
         }

         $folder = 'public/account/businesses/'.Wingu::business()->business_code.'/events/';

         if(!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         // GET THE FILE EXTENSION
         $extension = $this->speaker_image->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;

         $this->speaker_image->storeAs($folder, $fileName);
         $edit->image     = $fileName;
      }

      $edit->name          = $this->name;
      $edit->designation   = $this->designation;
      $edit->bio           = $this->bio;
      $edit->linkedin      = $this->linkedin;
      $edit->twitter       = $this->twitter;
      $edit->facebook      = $this->facebook;
      $edit->medium        = $this->medium;
      $edit->youtube       = $this->youtube;
      $edit->instagram     = $this->instagram;
      $edit->save();

      $activities = Auth::user()->name.' Has updated <a class="font-bold" href="#>'.$this->name.'</a> details';
      $module     = 'Event Manager';
      $section    = 'Speakers';
      $action     = 'Edit';
      $activityID = $this->eventCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Speaker updated successfully"
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
      $delete = WingucrowdSpeakers::where('speaker_code',$this->editCode)->where('business_code',Auth::user()->business_code)->first();

      if($delete->image){
         //delete logo
         $unlinkPath = public_path('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$delete->image);
         unlink($unlinkPath);
      }

      $activities = Auth::user()->name.' Has delete a speaker  <a class="font-bold" href="#>'.$delete->name.'</a>';
      $module     = 'Event Manager';
      $section    = 'Speakers';
      $action     = 'Delete';
      $activityID = $this->eventCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      $delete->delete();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Speaker deleted successfully"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }
}
