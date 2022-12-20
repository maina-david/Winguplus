<?php

namespace App\Http\Controllers\app\events;

use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\products\product_information;
use App\Models\events\events;
use Illuminate\Http\Request;
use Helper;
use Auth;
use Wingu;
use Session;
use File;
use DB;
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
   public function index()
   {
      $events = events::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.events.events.event.index', compact('events'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('app.events.events.event.create');
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
      ]);

      $eventCode = Helper::generateRandomString(30);

      $event = new events;
      $event->business_code     = Auth::user()->business_code;
      $event->event_code        = $eventCode;
      $event->title             = $request->title;
      $event->tagline           = $request->tagline;
      $event->available_tickets = $request->available_tickets;
      $event->type              = $request->type;
      $event->start_date        = $request->start_date;
      $event->start_time        = $request->start_time;
      $event->end_date          = $request->end_date;
      $event->end_time          = $request->end_time;
      $event->location          = $request->location;
      $event->map               = $request->map;
      $event->details           = $request->details;
      if(!empty($request->cover_image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/events/'.$eventCode.'/events/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('cover_image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $event->cover_image  = $fileName;
      }
      $event->created_by        = Auth::user()->user_code;
      $event->save();

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new event <a href="'.route('events.show',$eventCode).'">'.$request->product_name.'</a>';
		$module       = 'Event Manager';
		$section      = 'Events';
      $action       = 'Create';
		$activityCode = $eventCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Event successfully added.');

      return redirect()->route('events.show',$eventCode);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($code)
   {
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.events.events.event.details', compact('event','code'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.events.events.event.edit', compact('event','code'));
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
      ]);

      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $event->title             = $request->title;
      $event->tagline           = $request->tagline;
      $event->available_tickets = $request->available_tickets;
      $event->type              = $request->type;
      $event->start_date        = $request->start_date;
      $event->start_time        = $request->start_time;
      $event->end_date          = $request->end_date;
      $event->end_time          = $request->end_time;
      $event->location          = $request->location;
      $event->map               = $request->map;
      $event->details           = $request->details;
      if(!empty($request->cover_image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/events/'.$code.'/events/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         if($event->cover_image != ""){
				$delete = $path.$event->cover_image;
				if (File::exists($delete)) {
					unlink($delete);
				}
         }

         $file = $request->file('cover_image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $event->cover_image = $fileName;
      }

      $event->updated_by        = Auth::user()->user_code;
      $event->save();

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> event <a href="'.route('events.show',$code).'">'.$request->product_name.'</a>';
		$module       = 'Event Manager';
		$section      = 'Events';
      $action       = 'Edit';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Event successfully updated.');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }

   /**
   * speakers
   *
   * @param  int  $code
   * @return \Illuminate\Http\Response
   */
   public function speakers($code){
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.events.events.speakers', compact('code','event'));
   }

   /**
   * tickets
   *
   * @param  int  $code
   * @return \Illuminate\Http\Response
   */
   public function tickets($code){
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.events.events.tickets.index', compact('code','event'));
   }

   /**
   * tickets sold
   *
   * @param  string  $code
   * @return \Illuminate\Http\Response
   */
   public function ticket_sold($code){
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return view('app.events.events.tickets.sold', compact('code','event'));
   }


   /**
   * event attendance
   *
   * @param  string  $code
   * @return \Illuminate\Http\Response
   */
   public function attendance($code){
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return view('app.events.events.tickets.attendance', compact('code','event'));
   }

}
