<?php
namespace App\Http\Controllers\app\crm\deals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\tasks;
use App\Models\finance\customer\customers;
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
      $deal = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.deal_code',$code)
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->orderby('crm_deals.id','desc')
                     ->select('*','crm_deals.created_at as create_date')
                     ->first();

      $stages = stages::where('pipeline_code',$deal->pipeline)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();
      $tasks = tasks::where('business_code',Auth::user()->business_code)->where('deal_code',$code)->orderby('id','desc')->get();
      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose users','');
      $customer = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$deal->contact)->first();
      $owner = wp_user::where('business_code',Auth::user()->business_code)->where('user_code',$deal->owner)->first();

      return view('app.crm.deals.deal.show', compact('deal','stages','tasks','users','customer','owner'));
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
         'task'  => 'required',
         'date'  => 'required',
         'time'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'deal_code' => 'required',
         'description' => 'required',
      ]);

      $task = new tasks;
      $task->task_code     = Helper::generateRandomString(30);
      $task->task          = $request->task;
      $task->date          = $request->date;
      $task->time          = $request->time;
      $task->assigned_to   = $request->assigned_to;
      $task->priority      = $request->priority;
      $task->status        = $request->status;
      $task->category      = $request->category;
      $task->deal_code     = $request->deal_code;
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
         'task'  => 'required',
         'date'  => 'required',
         'time'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'deal_code' => 'required',
         'description' => 'required',
      ]);

      $task = tasks::where('business_code',Auth::user()->business_code)->where('task_code',$code)->first();
      $task->task          = $request->task;
      $task->date          = $request->date;
      $task->time          = $request->time;
      $task->assigned_to   = $request->assigned_to;
      $task->priority      = $request->priority;
      $task->status        = $request->status;
      $task->category      = $request->category;
      $task->deal_code     = $request->deal_code;
      $task->description   = $request->description;
      $task->updated_by    = Auth::user()->user_code;
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
