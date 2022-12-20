<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\payments\payment_methods;
use App\Models\hr\employees;
use App\Models\hr\employee_bank_info as bank;
use App\Models\hr\employee_salary as salary;
use App\Models\finance\payments\payment_type;
use Auth;
use Session;

class peopleController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $employees = employees::join('hr_employee_salary','hr_employee_salary.employee_code','=','hr_employees.employee_code')
                  ->join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                  ->where('hr_employees.business_code',Auth::user()->business_code)
                  ->where('hr_employees.status',25)
                  ->orderby('hr_employees.employee_code','desc')
                  ->select('*','hr_employees.employee_code as employee_code')
                  ->get();
      $count = 1;

      return view('app.hr.payroll.people.index', compact('employees','count'));
   }

   public function show($code){
      $details = employees::join('hr_employee_bank_info','hr_employee_bank_info.employee_code','=','hr_employees.employee_code')
                  ->join('hr_employee_salary','hr_employee_salary.employee_code','=','hr_employees.employee_code')
                  ->where('hr_employees.employee_code',$code)
                  ->select('*','hr_employees.employee_code as employee_code')
                  ->first();
      $payments = payment_methods::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $mainPaymentType = payment_methods::where('business_code',0)->orderby('id','desc')->get();
      return view('app.hr.payroll.people.show', compact('details','payments','mainPaymentType'));
   }

   public function update(Request $request,$code){

      //bank info
      $bank = bank::Where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $bank->account_number = $request->account_number;
      $bank->bank_name = $request->bank_name;
      $bank->bank_branch = $request->bank_branch;
      $bank->save();

      //salary
      $salary = salary::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $salary->payment_method = $request->payment_method;
      $salary->salary_amount = $request->salary_amount;
      $salary->mpesa_number = $request->mpesa_number;
      $salary->payment_basis = $request->payment_basis;
      $salary->save();

      Session::flash('success','Payroll payment information successfully updated');

      return redirect()->back();
   }
}
