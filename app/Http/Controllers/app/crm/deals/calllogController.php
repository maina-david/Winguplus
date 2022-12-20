<?php

namespace App\Http\Controllers\app\crm\deals;
use App\Http\Controllers\Controller;
use App\Models\crm\call_log;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\finance\customer\customers;
use App\Models\wingu\wp_user;
use Auth;
use Session;
use Helper;

class calllogController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   //index
   public function index($code){
      $deal = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.deal_code',$code)
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->orderby('crm_deals.id','desc')
                     ->select('*','crm_deals.created_at as create_date')
                     ->first();

      $customer = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$deal->contact)->first();
      $owner = wp_user::where('business_code',Auth::user()->business_code)->where('user_code',$deal->owner)->first();
      $stages = stages::where('pipeline_code',$deal->pipeline)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();
      $callLogs = call_log::where('parent_code',$code)->where('business_code',Auth::user()->business_code)->where('section','Deal')->orderby('id','desc')->get();

      return view('app.crm.deals.deal.show', compact('deal','stages','callLogs','customer','owner'));
   }

   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request, $code){
      $this->validate($request,[
         'phone_number' => 'required',
         'contact_person' => 'required',
         'hours' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
      ]);

      $callLogs = new call_log;
      $callLogs->log_code       = Helper::generateRandomString(30);
      $callLogs->subject        = $request->subject;
      $callLogs->note           = $request->note;
      $callLogs->parent_code    = $code;
      $callLogs->phone_number   = $request->phone_number;
      $callLogs->contact_person = $request->contact_person;
      $callLogs->hours          = $request->hours;
      $callLogs->minutes        = $request->minutes;
      $callLogs->seconds        = $request->seconds;
      $callLogs->call_type      = $request->call_type;
      $callLogs->created_by     = Auth::user()->user_code;
      $callLogs->business_code  = Auth::user()->business_code;
      $callLogs->section        = 'Deal';
      $callLogs->save();

      Session::flash('success','Call successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code){

      $this->validate($request,[
         'phone_number' => 'required',
         'contact_person' => 'required',
         'hours' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
      ]);

      $callLogs = call_log::where('business_code',Auth::user()->business_code)->where('log_code',$code)->first();
      $callLogs->subject = $request->subject;
      $callLogs->note = $request->note;
      $callLogs->parent_code = $request->deal_code;
      $callLogs->phone_number = $request->phone_number;
      $callLogs->contact_person = $request->contact_person;
      $callLogs->hours = $request->hours;
      $callLogs->minutes = $request->minutes;
      $callLogs->seconds = $request->seconds;
      $callLogs->call_type = $request->call_type;
      $callLogs->updated_by = Auth::user()->user_code;
      $callLogs->business_code = Auth::user()->business_code;
      $callLogs->section = 'Deal';
      $callLogs->save();

      Session::flash('success','Call successfully updated');

      return redirect()->back();
   }

   /**
   * delete
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($code){
      call_log::where('business_code',Auth::user()->business_code)->where('section','Deal')->where('log_code',$code)->delete();

      Session::flash('success','Call successfully deleted');

      return redirect()->back();
   }

}
