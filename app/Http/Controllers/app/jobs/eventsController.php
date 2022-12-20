<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\jobs\jobs;
use App\Models\jobs\events;
use Mail;
use Helper;
use Auth;
use Session;
use Prm;
use Wingu;

class eventsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($code)
   {
      $events = events::where('business_code',Auth::user()->business_code)
                        ->where('job',$code)
                        ->orderby('id','desc')
                        ->get();

      return view('app.jobs.events.index', compact('events','code'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request){
      $this->validate($request, [
         'title' => 'required',
         'start_date' => 'required',
         'end_date' => 'required',
      ]);

      $event = new events;
      $event->title         = $request->title;
      $event->event_code    = Helper::generateRandomString(30);
      $event->job           = $request->jobcode;
      $event->venue         = $request->venue;
      $event->description   = $request->description;
      $event->start_date    = $request->start_date;
      $event->end_date      = $request->end_date;
      $event->status        = $request->status;
      $event->priority      = $request->priority;
      $event->created_by    = Auth::user()->user_code;
      $event->business_code = Auth::user()->business_code;
      $event->save();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Created</b> a new event <a href="'.route('job.dashboard',$request->jobcode).'">'.$event->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Events';
      $action       = 'Create';
		$activityCode = $event->event_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Event was added successfully');

      return redirect()->back();
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($code,$eventcode)
   {
      $event = events::where('business_code',Auth::user()->business_code)->where('job',$code)->where('event_code',$eventcode)->first();

      return view('app.jobs.events.show', compact('code','event'));
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function results(Request $request,$eventcode)
   {
      $this->validate($request, [
         'results' => 'required'
      ]);

      $event = events::where('business_code',Auth::user()->business_code)->where('event_code',$eventcode)->first();
      $event->results = $request->results;
      $event->save();

      Session::flash('success','Event results updated');

      return redirect()->back();
   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($jobcode,$eventcode)
   {
      $edit = events::where('business_code',Auth::user()->business_code)
                    ->where('job',$jobcode)
                    ->where('event_code',$eventcode)
                    ->first();

      $code = $jobcode;

      return view('app.jobs.events.edit', compact('code','edit'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request,$eventcode)
   {
      $this->validate($request, [
         'title' => 'required',
         'start_date' => 'required',
         'end_date' => 'required',
      ]);

      $event = events::where('event_code',$eventcode)->where('business_code',Auth::user()->business_code)->first();
      $event->title         = $request->title;
      $event->venue         = $request->venue;
      $event->description   = $request->description;
      $event->start_date    = $request->start_date;
      $event->end_date      = $request->end_date;
      $event->status        = $request->status;
      $event->priority      = $request->priority;
      $event->updated_by    = Auth::user()->updated_by;
      $event->business_code = Auth::user()->business_code;
      $event->save();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Updated</b> an event <a href="'.route('job.dashboard',$request->jobcode).'">'.$event->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Events';
      $action       = 'Edit';
		$activityCode = $event->event_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Event was updated successfully');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($jobcode,$eventcode)
   {
      $event = events::where('event_code',$eventcode)->where('job',$jobcode)->where('business_code',Auth::user()->business_code)->first();
      $event->delete();

      //recored activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>deleted</b> <a href="#">'.$event->title.'</a>';
		$module       = 'Jobs Management';
		$section      = 'Events';
      $action       = 'Delete';
		$activityCode = $event->event_code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success', 'Event was success deleted');

      return redirect()->back();
   }
}
