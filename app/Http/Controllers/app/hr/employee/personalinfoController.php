<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employees;
use App\Models\wingu\country;
use Session;
use Wingu;
use Auth;
use Helper;
class personalinfoController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
      $edit = employee_personal_info::where('hr_employee_personal_info.employee_code',$code)
                           ->join('hr_employees','hr_employees.employee_code','=','hr_employee_personal_info.employee_code')
                           ->select('*','hr_employees.employee_code as empid')
                           ->first();

      $country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose nationality country','0');
      $employee = employees::where('business_code',Auth::user()->business_code)->where('employee_code',$code)->first();

      return view('app.hr.employee.personal',compact('edit','employee','country'));
   }

   public function update(Request $request, $code){

      $person = employee_personal_info::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $person->personal_email = $request->personal_email;
      $person->personal_number = $request->personal_number;
      $person->nationalID = $request->nationalID;
      $person->passport_number = $request->passport_number;
      $person->nationality = $request->nationality;
      $person->home_address = $request->home_address;
      $person->current_home_location = $request->current_home_location;
      $person->region_of_birth = $request->region_of_birth;
      $person->marital_status = $request->marital_status;
      $person->nssf_number = $request->nssf_number;
      $person->nhif_number = $request->nhif_number;
      $person->dob = $request->dob;
      $person->religion = $request->religion;
      $person->helb_loan_amount = $request->helb_loan_amount;
      $person->hospital_of_choice = $request->hospital_of_choice;
      $person->business_code = Auth::user()->business_code;
      $person->updated_by = Auth::user()->user_code;
      $person->save();

      $employee = employees::where('business_code',Auth::user()->business_code)->where('employee_code',$code)->first();

      //recored activity
		$activity     =  Auth::user()->name.' Has updated '.$employee->names.'s Personal information';
		$module       = 'Human Resource Management';
		$section      = 'Employee';
      $action       = 'Update';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Personal information has been successfully updated');

      return redirect()->back();
   }

   
}
