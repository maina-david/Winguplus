<?php

namespace App\Http\Controllers\app\hr\organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\department;
use App\Models\hr\employees;
use Auth;
use Session;
use Helper;
class departmentsController extends Controller
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
      $departments = department::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.hr.organization.departments.index', compact('departments'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $employees = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('Choose an employee');
      $departments = department::where('business_code',Auth::user()->business_code)->whereNull('parent_code')->orderby('id','desc')->get();

      return view('app.hr.organization.departments.create', compact('employees','departments'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'title' => 'required',
      ]);

      $department = new department;
      $department->department_code = Helper::generateRandomString(30);
      $department->title           = $request->title;
      $department->code            = $request->code;
      $department->parent_code     = $request->parent_code;
      $department->description     = $request->description;
      $department->business_code   = Auth::user()->business_code;
      $department->created_by      = Auth::user()->user_code;
      $department->department_head = $request->department_head;
      $department->save();

      Session::flash('success','Department successfully added');

      return redirect()->route('hrm.departments');
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
   public function edit($code)
   {
      $edit = department::where('department_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $employees = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('Choose an employee','');
      $departments = department::where('business_code',Auth::user()->business_code)->pluck('title','department_code')->prepend('choose department','');

      return view('app.hr.organization.departments.edit', compact('employees','departments','edit'));
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
      $this->validate($request, [
         'title' => 'required',
      ]);

      $department = department::where('department_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $department->title           = $request->title;
      $department->parent_code     = $request->parent_code;
      $department->code            = $request->code;
      $department->description     = $request->description;
      $department->business_code   = Auth::user()->business_code;
      $department->updated_by      = Auth::user()->user_code;
      $department->department_head = $request->department_head;
      $department->save();

      Session::flash('success','Department successfully updated');

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
      department::where('department_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','Department successfully deleted');

      return redirect()->back();
   }
}
