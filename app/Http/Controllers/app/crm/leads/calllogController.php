<?php

namespace App\Http\Controllers\app\crm\leads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\call_logs;
use App\Models\finance\customer\customers;
use App\Models\crm\leads\status;
use Auth;
use Session;
use Helper;

class calllogController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}


   /**
   * call log
   *
   * @return \Illuminate\Http\Response
   */
   public function calllog($code){
      $logs = call_logs::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->orderby('id','desc')->get();
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->where('category','Lead')->first();
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose status', '');

      return view('app.crm.leads.show', compact('lead','code','logs','status'));
   }


   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store_calllog(Request $request){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customer_code' => 'required',
      ]);

      $note = new call_logs;
      $note->log_code       = Helper::generateRandomString(30);
      $note->subject        = $request->subject;
      $note->note           = $request->note;
      $note->customer_code  = $request->customer_code;
      $note->phone_number   = $request->phone_number;
      $note->contact_person = $request->contact_person;
      $note->hours = $request->hours;
      $note->minutes = $request->minutes;
      $note->seconds = $request->seconds;
      $note->call_type = $request->call_type;
      $note->status = $request->status;
      $note->created_by = Auth::user()->user_code;
      $note->business_code = Auth::user()->business_code;
      $note->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update_calllog(Request $request, $code){
      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customer_code' => 'required',
      ]);

      $note = call_logs::where('business_code',Auth::user()->business_code)->where('log_code',$code)->first();
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customer_code = $request->customer_code;
      $note->phone_number = $request->phone_number;
      $note->contact_person = $request->contact_person;
      $note->hours = $request->hours;
      $note->minutes = $request->minutes;
      $note->seconds = $request->seconds;
      $note->call_type = $request->call_type;
      $note->status = $request->status;
      $note->updated_by = Auth::user()->user_code;
      $note->business_code = Auth::user()->business_code;
      $note->save();

      Session::flash('success','Call log successfully updated');

      return redirect()->back();
   }

   public function delete($id){
      call_logs::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();

      Session::flash('success','call log is successfully delete');

      return redirect()->back();
   }

}
