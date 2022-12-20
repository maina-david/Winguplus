<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\events;
use App\Mail\sendMessage;
use App\Models\wingu\wp_user;
use Mail;
use Session;
use Auth;
use Wingu;
use Finance;
use Helper;

class eventsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code)
   {
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->first();
      return view('app.crm.leads.show', compact('lead','code'));
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
         'event_name' => 'required',
         'start_time' => 'required',
      ]);

      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $event->event_name     = $request->event_name;
      $event->priority       = $request->priority;
      $event->status         = $request->status;
      $event->owner          = $request->owner;
      $event->start_date     = $request->start_date;
      $event->start_time     = $request->start_time;
      $event->end_date       = $request->end_date;
      $event->end_time       = $request->end_time;
      $event->description    = $request->description;
      $event->updated_by     = Auth::user()->user_code;
      $event->customer_code  = $request->customer_code;
      $event->business_code  = Auth::user()->business_code;
      $event->save();

      // /return Finance::client($request->customer_code)->email;

      if ($request->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Finance::client($request->customer_code)->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->event_name.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/></span>
         -------------------------------------------------<br><br>'.$request->description;
         $subject = 'Meeting invitation - '.$request->event_name;
         $to = Finance::client($request->customer_code)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Event successfully updated');

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
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $event->delete();

      Session::flash('success','Event successfully deleted');

      return redirect()->back();

   }
}
