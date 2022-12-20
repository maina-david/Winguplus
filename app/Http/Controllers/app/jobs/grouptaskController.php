<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\project\group;
use App\Models\project\tasks;
use Auth;
use Helper;
use Session;
use Prm;
use Wingu;

class grouptaskController extends Controller
{

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'project' => 'required'
      ]);

      $group = new group;
      $code = Helper::generateRandomString(20);
      $group->group_code    = $code;
      $group->name          = $request->name;
      $group->project       = $request->project;
      $group->priority      = $request->priority;
      $group->visibility    = $request->visibility;
      $group->description   = $request->description;
      $group->created_by    = Auth::user()->user_code;
      $group->business_code = Auth::user()->business_code;
      $group->save();;

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>created</b> a new task group <b>'.$group->name.'</b>';
		$module       = 'Project Management';
		$section      = 'Project';
      $action       = 'Task group';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Task group successfully added');

      return redirect()->back();
   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $data = group::where('group_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return response()->json(['data' => $data]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request,$code)
   {
      $this->validate($request, [
         'name'    => 'required',
         'project' => 'required'
      ]);

      $group = group::where('group_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $group->name          = $request->name;
      $group->project       = $request->project;
      $group->priority      = $request->priority;
      $group->visibility    = $request->visibility;
      $group->description   = $request->description;
      $group->updated_by    = Auth::user()->user_code;
      $group->business_code = Auth::user()->business_code;
      $group->save();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated '.$group->name.' task group</b>';
		$module       = 'Project Management';
		$section      = 'Task group';
      $action       = 'Edit';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Task group successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($code)
   {
      //delete tasks
      tasks::where('group',$code)->where('business_code',Auth::user()->business_code)->delete();

      //delete group
      $group  = group::where('group_code',$code)->where('business_code',Auth::user()->business_code)->first();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted '.$group->name.' task group</b>';
		$module       = 'Project Management';
		$section      = 'Task group';
      $action       = 'Delete';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Task group successfully deleted');

      return redirect()->back();
   }
}
