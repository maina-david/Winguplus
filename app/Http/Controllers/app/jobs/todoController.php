<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\project\project_tasks;
use Auth;
class todoController extends Controller
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
      $tasks = project_tasks::join('project_tasks_allocation','project_tasks_allocation.taskID','=','project_tasks.id')
               ->where('project_tasks_allocation.employeeID', Auth::user()->employeeID)
               ->OrderBy('project_tasks_allocation.created_at','DESC')
               ->select('*','project_tasks.id as taskID')
               ->paginate(10);
      return view('app.jobs.todo.index', compact('tasks'));
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
     //
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
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
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
   public function update(Request $request, $id)
   {
     //
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
}
