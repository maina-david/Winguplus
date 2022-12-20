<?php

namespace App\Http\Controllers\app\jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class goalsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function goals($code)
   {
      return view('app.jobs.goals.goals', compact('code'));
   }

}
