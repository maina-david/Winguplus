<?php

namespace App\Http\Controllers\app\salesflow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class salesflowController extends Controller
{
   /**
      * Create a new controller instance.
      *
      * @return void
      */
   public function __construct()
   {
      $this->middleware('auth');
   }


   /**
    * dashboard controller instance.
   */
   public function dashboard(){
      return view('app.salesflow.dashboard.dashboard');
   }

   //user summary
   public function user_summary(){
      return view('app.salesflow.dashboard.user-summary');
   }
}
