<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\payroll_allocations;
use App\Models\hr\employee_salary as salary;
use App\Models\hr\deductions;
use App\Models\limitless\business;
use Session;
use File;
use Auth;
use Input;
use Helper;
use Hr;

class deductionsController extends Controller
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
      $deductions = deductions::where('business_code',Auth::user()->business_code)
                              ->orderby('id','desc')
                              ->pluck('title','deduction_code')
                              ->prepend('choose deduction','');
      $employee = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $allocations = payroll_allocations::join('hr_payroll_deductions','hr_payroll_deductions.deduction_code','=','hr_payroll_allocations.deduction')
                              ->where('hr_payroll_allocations.employee',$code)
                              ->where('hr_payroll_allocations.business_code',Auth::user()->business_code)
                              ->select('*','hr_payroll_allocations.id as deductID')
                              ->get();

      return view('app.hr.employee.deductions', compact('employee','deductions','allocations'));
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
   public function allocate(Request $request)
   {
      $this->validate($request, [
         'deduction' => 'required',
         'type' => 'required',
         'employee' => 'required'
      ]);

      if($request->rate == "" && $request->amount == ""){
         Session::flash('error', 'You need to provide either the rate or amount');

         return redirect()->back();
      }

      if($request->rate != "" && $request->amount != ""){
         Session::flash('error', 'Please choose either rate or amount');

         return redirect()->back();
      }

      $employee = employees::join('hr_employee_salary','hr_employee_salary.employee_code','=','hr_employees.employee_code')
                           ->where('hr_employees.business_code',Auth::user()->business_code)
                           ->where('hr_employees.employee_code',$request->employee)
                           ->first();



      if($request->rate != ""){
         $amount = $employee->salary_amount * ($request->rate/100);
         $rate = $request->rate;
      }

      if($request->amount != ""){
         $rate = ($request->amount / $employee->salary_amount ) * 100;
         $amount = $request->amount;
      }

      $allocations = new payroll_allocations;
      $allocations->business_code = Auth::user()->business_code;
      $allocations->created_by = Auth::user()->user_code;
      $allocations->employee = $request->employee;
      $allocations->deduction = $request->deduction;
      $allocations->rate = $rate;
      $allocations->amount = $amount;
      $allocations->category = 'Deduction';
      $allocations->save();

      //update deductions
      $salary = salary::where('employee_code',$request->employee)->where('business_code',Auth::user()->business_code)->first();
      $salary->total_deductions = Hr::calculate_deduction($request->employee);
      $salary->save();

      Session::flash('success','Deduction successfully allocated');

      return redirect()->back();

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      $delete = payroll_allocations::where('business_code',Auth::user()->business_code)->where('category','Deduction')->where('id',$id)->first();

      //update deductions
      $salary = salary::where('employee_code',$delete->employee)->where('business_code',Auth::user()->business_code)->first();
      $salary->total_deductions = $salary->total_deductions - $delete->amount;
      $salary->save();

      $delete->delete();

      Session::flash('success','Deduction successfully deleted');

      return redirect()->back();
   }
}
