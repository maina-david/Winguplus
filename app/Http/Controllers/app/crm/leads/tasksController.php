<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\crm\leads\tasks;
use App\Models\wingu\wp_user;
Use Auth;
use Wingu;
use Session;
use Helper;

class tasksController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code)
   {
      //check if user is linked to a business and allow access
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->first();
      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose user');
      $tasks = tasks::where('business_code',Auth::user()->business_code)->where('lead_code',$code)->orderby('id','desc')->get();

      return view('app.crm.leads.show', compact('lead','code','users','tasks'));
   }


   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request,[
         'title'  => 'required',
      ]);

      $task = new tasks;
      $task->task_code     = Helper::generateRandomString(30);
      $task->title         = $request->title;
      $task->start_date    = $request->start_date;
      $task->due_date      = $request->due_date;
      $task->assigned_to   = $request->assigned_to;
      $task->priority      = $request->priority;
      $task->status        = $request->status;
      $task->category      = $request->category;
      $task->lead_code     = $request->lead_code;
      $task->description   = $request->description;
      $task->created_by    = Auth::user()->user_code;
      $task->business_code = Auth::user()->business_code;
      $task->save();

      Session::flash('success','Task added successfully');

      return redirect()->back();
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
     //
   }


   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code)
   {
      $this->validate($request,[
         'title'  => 'required',
      ]);

      $task = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $task->title = $request->title;
      $task->start_date = $request->date;
      $task->due_date = $request->due_date;
      $task->assigned_to = $request->assigned_to;
      $task->priority = $request->priority;
      $task->status = $request->status;
      $task->category = $request->category;
      $task->description = $request->description;
      $task->updated_by = Auth::user()->user_code;
      $task->business_code = Auth::user()->business_code;
      $task->save();

      Session::flash('success','Task updated successfully');

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
      tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->delete();

      Session::flash('success','Task deleted successfully');

      return redirect()->back();
   }
}
