<?php

namespace App\Http\Controllers\app\events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eventManagerController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //dashboard
   public function dashboard(){
      return view('app.events.dashboard');
   }
}
