<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\pipeline;
use Auth;
use Session;
use Helper;

class stagesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //list
   public function store(Request $request){
      $this->validate($request, [
         'title' => 'required',
         'pipeline_code' => 'required',
      ]);

      $stage = new stages;
      $stage->stage_code    = Helper::generateRandomString(30);
      $stage->title         = $request->title;
      $stage->description   = $request->description;
      $stage->business_code = Auth::user()->business_code;
      $stage->pipeline_code = $request->pipeline_code;
      $stage->created_by    = Auth::user()->user_code;
      $stage->save();

      Session::flash('success','Pipeline stage successfully added');

      return redirect()->back();
   }

   //edit
   public function edit($code){

      $edit = stages::where('stage_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $pipeline = pipeline::where('pipeline_code',$edit->pipeline_code)->where('business_code',Auth::user()->business_code)->first();
      $stages = stages::where('pipeline_code',$edit->pipeline_code)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();

      return view('app.crm.deals.pipelines.stages.edit', compact('pipeline','edit','stages'));
   }

   //update
   public function update(Request $request, $code){
      $this->validate($request, [
         'title' => 'required',
         'pipeline_code' => 'required',
      ]);

      $stage = stages::where('stage_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $stage->title         = $request->title;
      $stage->description   = $request->description;
      $stage->business_code = Auth::user()->business_code;
      $stage->pipeline_code = $request->pipeline_code;
      $stage->updated_by    = Auth::user()->user_code;
      $stage->save();

      Session::flash('success','Pipeline stage successfully updated');

      return redirect()->back();
   }

   //delete
   public function delete($code){
      $delete = stages::where('stage_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $delete->delete();

      Session::flash('success','Pipeline stage successfully updated');

      return redirect()->route('crm.pipeline.show',$delete->pipeline_code);
   }

   //position
   public function position(Request $request){
      $this->validate($request, [
         'positions'=>'required'
      ]);

      foreach ($request->positions as $position){

         $index = $position[0];
         $newPosition = $position[1];

         $stage = stages::where('stage_code',$index)->where('business_code',Auth::user()->business_code)->first();
         $stage->position = $newPosition;
         $stage->updated_by = Auth::user()->user_code;
         $stage->save();
      }

      return response()->json('success');
   }
}
