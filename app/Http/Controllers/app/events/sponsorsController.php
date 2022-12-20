<?php

namespace App\Http\Controllers\app\events;

use App\Http\Controllers\Controller;
use App\Models\events\events;
use Illuminate\Http\Request;
use Auth;

class sponsorsController extends Controller
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
      $event = events::where('event_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.events.events.sponsors', compact('code','event'));
   }
}
