<?php

namespace App\Http\Controllers\app\crm\deals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\hr\employees;
use App\Models\crm\leads\event;
use App\Mail\sendMessage;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\appointments;
use App\Models\wingu\wp_user;
use Mail;
use Session;
use Auth;
use Wingu;
use Crm;
use Helper;

class appointmentsController extends Controller
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
      $deal = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.deal_code',$code)
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->orderby('crm_deals.id','desc')
                     ->select('*','crm_deals.created_at as create_date')
                     ->first();

      $stages = stages::where('pipeline_code',$deal->pipeline)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();
      $appointments = appointments::where('deal_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose users','');
      $customer = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$deal->contact)->first();
      $owner = wp_user::where('business_code',Auth::user()->business_code)->where('user_code',$deal->owner)->first();

      return view('app.crm.deals.deal.show', compact('deal','stages','appointments','users','owner','customer'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
   //
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
         'title' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'owner' => 'required',
         'start_date' => 'required',
         'start_time' => 'required',
         'deal_code' => 'required',
      ]);

      $event = new appointments;
      $event->appointment_code = Helper::generateRandomString(30);
      $event->title            = $request->title;
      $event->priority         = $request->priority;
      $event->status           = $request->status;
      $event->owner            = $request->owner;
      $event->start_date       = $request->start_date;
      $event->start_time       = $request->start_time;
      $event->end_date         = $request->end_date;
      $event->end_time         = $request->end_time;
      $event->description      = $request->description;
      $event->deal_code        = $request->deal_code;
      $event->business_code    = Auth::user()->business_code;
      $event->created_by       = Auth::user()->user_code;
      $event->save();

      if ($request->send_invitation == 'yes') {
         $lead = Crm::lead($request->lead_code);

         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.$lead->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->title.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/></span>
         -------------------------------------------------';
         $subject = $request->title;
         $to = $lead->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }


      Session::flash('success','Appointment successfully added');

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
         'title' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'owner' => 'required',
         'start_date' => 'required',
         'start_time' => 'required',
         'deal_code' => 'required',
      ]);

      $event = appointments::where('appointment_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $event->title         = $request->title;
      $event->priority      = $request->priority;
      $event->status        = $request->status;
      $event->owner         = $request->owner;
      $event->start_date    = $request->start_date;
      $event->start_time    = $request->start_time;
      $event->end_date      = $request->end_date;
      $event->end_time      = $request->end_time;
      $event->description   = $request->description;
      $event->updated_by    = Auth::user()->user_code;
      $event->deal_code     = $request->deal_code;
      $event->business_code = Auth::user()->business_code;
      $event->save();

      if ($request->send_invitation == 'yes') {
         $lead = Crm::lead($request->lead_code);
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.$lead->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->title.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/></span>
         -------------------------------------------------';
         $subject = $request->title;
         $to = $lead->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Appointment successfully updated');

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
      appointments::where('appointment_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','Appointment successfully deleted');

      return redirect()->back();

   }
}
