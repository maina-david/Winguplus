<?php

namespace App\Http\Controllers\app\jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class myTaskController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //list
   public function list(){
      return view('app.jobs.tasks.my_task_list');
   }
}
