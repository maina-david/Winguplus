<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\payments\payment_methods;
use App\Models\hr\employee_salary as salary;
use App\Models\hr\employees;
use App\Models\hr\employee_bank_info as bank;
use App\Models\hr\payroll_allocations;
use Session;
use Auth;
use Hr;

class salaryController extends Controller
{

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $code
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $employee = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $edit = salary::join('hr_employee_bank_info','hr_employee_bank_info.employee_code','=','hr_employee_salary.employee_code')
                     ->where('hr_employee_salary.employee_code',$code)
                     ->where('hr_employee_salary.business_code',Auth::user()->business_code)
                     ->select('*','hr_employee_salary.employee_code as employee_code')
                     ->first();

      $paymentsMethods = payment_methods::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $mainPaymentMethods = payment_methods::where('business_code','admin')->orderby('id','desc')->get();

      return view('app.hr.employee.salary', compact('edit','employee','paymentsMethods','mainPaymentMethods'));

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $code
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $code)
   {
      $this->validate($request,[
         'payment_basis' => 'required',
         'salary_amount' => 'required',
      ]);

      //salary
      $salary = salary::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();

      if($request->salary_amount != $salary->salary_amount){

         //update allocated deduction
         $allocations = payroll_allocations::where('employee',$request->employee_code)
                        ->where('business_code',Auth::user()->business_code)
                        ->where('category','Deduction')
                        ->get();

         foreach($allocations as $allocaion){
            $allocateUpdate = payroll_allocations::where('employee',$request->employee_code)
                                 ->where('id',$allocaion->id)
                                 ->where('category','Deduction')
                                 ->where('business_code',Auth::user()->business_code)
                                 ->first();

            $amount = $request->salary_amount * ($allocateUpdate->rate/100);
            $allocateUpdate->amount = $amount;
            $allocateUpdate->save();
         }
      }
      $salary->payment_method = $request->payment_method;
      $salary->payment_basis = $request->payment_basis;
      $salary->salary_amount = $request->salary_amount;
      $salary->mpesa_number = $request->mpesa_number;
      $salary->updated_by = Auth::user()->business_code;
      $salary->save();

      //bank info
      $bank = bank::Where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $bank->account_number = $request->account_number;
      $bank->bank_name = $request->bank_name;
      $bank->bank_branch = $request->bank_branch;
      $bank->updated_by = Auth::user()->business_code;
      $bank->save();

      //update deductions
      $salary = salary::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $salary->total_deductions = Hr::calculate_deduction($code);
      $salary->save();

      Session::flash('success','Salary information successfully updated');

      return redirect()->back();
   }
}
