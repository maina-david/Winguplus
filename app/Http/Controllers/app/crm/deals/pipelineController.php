<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use Auth;
use Session;
use Helper;

class pipelineController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   // list
   public function index(){
      $pipelines = pipeline::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.crm.deals.pipelines.pipeline.index', compact('pipelines'));
   }

   // store
   public function store(Request $request){
      $this->validate($request, [
         'title' => 'required',
      ]);

      $pipeline = new pipeline;
      $pipeline->pipeline_code = Helper::generateRandomString(30);
      $pipeline->title = $request->title;
      $pipeline->description = $request->description;
      $pipeline->business_code = Auth::user()->business_code;
      $pipeline->created_by = Auth::user()->user_code;
      $pipeline->save();
      Session::flash('success','Pipeline successfully added');

      return redirect()->back();
   }

   // edit
   public function edit($code){
      $pipelines = pipeline::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $edit = pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.crm.deals.pipelines.pipeline.edit', compact('edit','pipelines'));
   }

   // update
   public function update(Request $request,$code){
      $this->validate($request, [
         'title' => 'required',
      ]);

      $pipeline = pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $pipeline->title = $request->title;
      $pipeline->description = $request->description;
      $pipeline->business_code = Auth::user()->business_code;
      $pipeline->updated_by = Auth::user()->user_code;
      $pipeline->save();
      Session::flash('success','Pipeline successfully updated');

      return redirect()->back();
   }

   //show pipeline
   public function show($code){
      $pipeline = pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $stages = stages::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();

      return view('app.crm.deals.pipelines.pipeline.show', compact('pipeline','stages'));
   }

   //delete
   public function delete($code){

      pipeline::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      stages::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','Pipeline delete successfully');

      return redirect()->route('crm.pipeline.index');
   }

}
