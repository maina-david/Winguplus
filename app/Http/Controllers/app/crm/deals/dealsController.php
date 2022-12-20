<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use App\Models\crm\call_log;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use App\Models\crm\notes;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\appointments;
use App\Models\crm\deals\tasks;
use App\Models\wingu\wp_user;
use Auth;
use Session;
use Helper;

class dealsController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   //list
   public function index(){
      $deals = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->orderby('crm_deals.id','desc')
                     ->get();

      return view('app.crm.deals.deal.index', compact('deals'));
   }

   //grid
   public function grid(){
      return view('app.crm.deals.deal.grid');
   }

   //create deal
   public function create(){
      $pipelines = pipeline::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('title','pipeline_code')
                           ->prepend('choose pipeline','');

      $users = wp_user::where('business_code',Auth::user()->business_code)->orderby('id','desc')
                     ->pluck('name','user_code')
                     ->prepend('choose user','');

      $customers = customers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('customer_name','customer_code')
                           ->prepend('choose customers','');

      return view('app.crm.deals.deal.create', compact('pipelines','users','customers'));
   }

   //get stages
   public function stages($code){
      $stages = stages::where('pipeline_code',$code)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();
      return \Response::json($stages);
   }

   //store
   public function store(Request $request){
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deals = new deals;
      $deals->deal_code = Helper::generateRandomString(30);
      $deals->title = $request->title;
      $deals->pipeline = $request->pipeline;
      $deals->stage = $request->stage;
      $deals->value = $request->value;
      $deals->contact = $request->contact;
      $deals->owner = $request->owner;
      $deals->account = $request->account;
      $deals->status = $request->status;
      $deals->close_date = $request->close_date;
      $deals->description = $request->description;
      $deals->business_code = Auth::user()->business_code;
      $deals->created_by = Auth::user()->user_code;
      $deals->save();

      Session::flash('success','Deal successfully added');

      return redirect()->route('crm.deals.index');
   }

   //edit
   public function edit($code){
      $edit = deals::where('business_code',Auth::user()->business_code)->where('deal_code',$code)->first();

      $pipelines = pipeline::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('title','pipeline_code')
                           ->prepend('choose pipeline','');

      $users = wp_user::where('business_code',Auth::user()->business_code)->orderby('id','desc')
                     ->pluck('name','user_code')
                     ->prepend('choose user','');

      $customers = customers::where('business_code',Auth::user()->business_code)
                           ->OrderBy('id','DESC')
                           ->pluck('customer_name','customer_code')
                           ->prepend('choose customers','');

      return view('app.crm.deals.deal.edit', compact('pipelines','users','customers','edit'));
   }

   //show
   public function show($code){
      $deal = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.deal_code',$code)
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->select('*','crm_deals.created_at as create_date')
                     ->orderby('crm_deals.id','desc')
                     ->first();

      $customer = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$deal->contact)->first();

      $owner = wp_user::where('business_code',Auth::user()->business_code)->where('user_code',$deal->owner)->first();

      $stages = stages::where('pipeline_code',$deal->pipeline)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();

      $TotalCallLogs = call_log::where('parent_code',$code)->where('business_code',Auth::user()->business_code)
                              ->where('section','Deal')
                              ->orderby('id','desc')
                              ->count();

      $TotalNotes = notes::where('parent_code',$code)
                        ->where('business_code',Auth::user()->business_code)
                        ->where('section','Deal')
                        ->count();

      $TotalTasks = tasks::where('business_code',Auth::user()->business_code)->where('deal_code',$code)->count();

      $TotalAppointments = appointments::where('deal_code',$code)->where('business_code',Auth::user()->business_code)->count();

      return view('app.crm.deals.deal.show', compact('deal','stages','TotalCallLogs','TotalNotes','TotalTasks','TotalAppointments','customer','owner'));
   }

   //update
   public function update(Request $request,$code){
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deals = deals::where('business_code',Auth::user()->business_code)->where('deal_code',$code)->first();

      $deals->title = $request->title;
      $deals->pipeline = $request->pipeline;
      $deals->stage = $request->stage;
      $deals->value = $request->value;
      $deals->contact = $request->contact;
      $deals->owner = $request->owner;
      $deals->account = $request->account;
      $deals->status = $request->status;
      $deals->close_date = $request->close_date;
      $deals->description = $request->description;
      $deals->business_code = Auth::user()->business_code;
      $deals->updated_by = Auth::user()->user_code;
      $deals->save();

      Session::flash('success','Deal successfully updated');

      return redirect()->back();
   }

   //delete
   public function delete($id){
      deals::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();
      Session::flash('success','Deal successfully deleted');
      return redirect()->back();
   }

   //stage change
   public function stage_change(Request $request){

      //update deal
      $update = deals::where('business_code',Auth::user()->business_code)->where('deal_code',$request->deal_code)->first();
      $update->stage = $request->stage_code;
      $update->updated_by = Auth::user()->user_code;
      $update->save();

      $stage = stages::where('business_code',Auth::user()->business_code)->where('stage_code',$request->stage_code)->first();

      //record activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>moved</b> deal#<i>'.$update->title.'</i> to <i>'.$stage->title.'</i> stage</a>';
		$module       = 'CRM';
		$section      = 'Deals';
      $action       = 'Edit';
		$activityCode = $request->deal_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);
   }


}
