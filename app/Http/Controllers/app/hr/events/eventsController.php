<?php

namespace App\Http\Controllers\app\hr\events;

use App\Http\Controllers\Controller;
use App\Models\hr\events;
use Illuminate\Http\Request;
use Session;
use Helper;
use Auth;

class eventsController extends Controller
{
   /**
 * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {

      return view('app.hr.events.index');
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('app.hr.events.create');
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
         'event_for' => 'required',
         'start_date' => 'required',
         'end_date' => 'required',
      ]);

      $event = new events;
      $event->event_code = Helper::generateRandomString(30);
      $event->business_code = Auth::user()->business_code;
      $event->title = $request->title;
      $event->event_for = $request->event_for;
      $event->status = $request->status;
      $event->note = $request->note;
      $event->start_date = $request->start_date;
      $event->end_date = $request->end_date;
      $event->created_by = Auth::user()->user_code;
      $event->save();

      Session::flash('success','Event created successfully');

      return redirect()->route('hrm.events');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
       $edit = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

       return view('app.hr.events.edit', compact('edit'));
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
          'event_for' => 'required',
          'start_date' => 'required',
          'end_date' => 'required',
       ]);

       $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
       $event->title = $request->title;
       $event->event_for = $request->event_for;
       $event->status = $request->status;
       $event->note = $request->note;
       $event->start_date = $request->start_date;
       $event->end_date = $request->end_date;
       $event->updated_by = Auth::user()->user_code;
       $event->save();

       Session::flash('success','Event updated successfully');

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
      $delete =  events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $delete->delete();

      Session::flash('success','Event deleted successfully');

       return redirect()->back();
    }
}
