<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employee_bank_info;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employee_family_info;
use App\Models\hr\employee_salary;
use App\Models\hr\department;
use App\Models\hr\position as positions;
use App\Models\hr\department_heads as head;
use App\Models\hr\report_to as report;
use App\Models\hr\branches;
use App\Models\wingu\wp_user;
use Session;
use File;
use Auth;
use Helper;
use Wingu;
use Hr;

class employeeController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      return view('app.hr.employee.index');
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      $departments = department::where('business_code',Auth::user()->business_code)->pluck('title','department_code')->prepend('Choose department');
      $branches = branches::where('business_code',Auth::user()->business_code)->pluck('name','branch_code')->prepend('Choose branch','');
      $positions = positions::where('business_code',Auth::user()->business_code)->pluck('name','position_code')->prepend('choose position','');
      $employees = employees::where('business_code',Auth::user()->business_code)->where('status',25)->pluck('names','employee_code');

      return view('app.hr.employee.create', compact('departments','positions','employees','branches'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request, array(
         'names'=>'required',
      ));

      //check if company_email already taken
      if($request->company_email != ""){
         $check = employees::where('business_code',Auth::user()->business_code)->where('company_email',$request->company_email)->count();
         if($check > 0){
            Session::flash('error','The company email is already in use');
            return redirect()->back();
         }
      }

      $employeeCode =  Helper::generateRandomString(20);

      $employee = new employees;
      $employee->employee_code = $employeeCode;
      $employee->names = $request->names;
      $employee->gender = $request->gender;
      $employee->leave_days = $request->leave_days;
      $employee->company_email = $request->company_email;
      $employee->employment_status = $request->employment_status;
      $employee->department = $request->department;
      $employee->position = $request->position;
      $employee->companyID = $request->companyID;
      $employee->branch = $request->branch;
      $employee->company_phone_number = $request->company_phone_number;
      $employee->office_phone_extension = $request->office_phone_extension;
      $employee->source_of_hire = $request->source_of_hire;
      $employee->contract_type = $request->contract_type;
      $employee->hire_date = $request->hire_date;
      $employee->status = $request->status;
      $employee->termination_date = $request->termination_date;
      $employee->current_status = $request->current_status;
      $employee->created_by = Auth::user()->user_code;
      $employee->business_code = Auth::user()->business_code;

      if(!empty($request->image)){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/hr/employee/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //update estimate to system
         $file = $request->image;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE update WITH RANDOM NUMBER
         $fileName = Helper::seoUrl($request->names).'-'.Helper::generateRandomString(4). '.' . $extension;

         // MOVE THE updateED FILES TO THE DESTINATION DIRECTORY
         $file->move($directory, $fileName);

         $employee->image = $fileName;
      }

      $employee->save();

      //assign leader
      $report = count(collect($request->report_to));
         if($report > 0){
         for($i=0; $i < count($request->report_to); $i++ ) {
               $rep = new report;
               $rep->employee = $employeeCode;
               $rep->leader = $request->report_to[$i];
               $rep->business_code = Auth::user()->business_code;
               $rep->created_by = Auth::user()->user_code;
               $rep->save();
         }
      }

      //department head allocation
      $department = count(collect($request->lead_department));
         if($department > 0){
         for($i=0; $i < count($request->lead_department); $i++ ) {
               $leaders = new head;
               $leaders->employee = $employeeCode;
               $leaders->department = $request->lead_department[$i];
               $leaders->business_code = Auth::user()->business_code;
               $leaders->created_by = Auth::user()->user_code;
               $leaders->save();
         }
      }

      //employee personal info
      $personalInfo = new employee_personal_info;
      $personalInfo->employee_code = $employeeCode;
      $personalInfo->created_by = Auth::user()->user_code;
      $personalInfo->business_code = Auth::user()->business_code;
      $personalInfo->save();

      // Employee bank info
      $bank_info = new employee_bank_info;
      $bank_info->employee_code = $employeeCode;
      $bank_info->created_by = Auth::user()->user_code;
      $bank_info->business_code = Auth::user()->business_code;
      $bank_info->save();


      ///primary school information
      $primary_info = new employee_primary_info;
      $primary_info->employee_code = $employeeCode;
      $primary_info->created_by = Auth::user()->user_code;
      $primary_info->business_code = Auth::user()->business_code;
      $primary_info->save();


      ///secondary school information
      $secondary_info = new employee_secondary_info;
      $secondary_info->employee_code = $employeeCode;
      $secondary_info->created_by = Auth::user()->user_code;
      $secondary_info->business_code = Auth::user()->business_code;
      $secondary_info->save();


      ///secondary school information
      $salary = new employee_salary;
      $salary->employee_code = $employeeCode;
      $salary->created_by = Auth::user()->user_code;
      $salary->business_code = Auth::user()->business_code;
      $salary->save();

      if($request->company_email){
         //link to user
         $checkForUser = wp_user::where('email',$request->company_email)->where('business_code',Auth::user()->business_code)->count();
         if($checkForUser == 1){
            $user = wp_user::where('email',$request->company_email)->where('business_code',Auth::user()->business_code)->first();
            $user->employee_code = $employeeCode;
            $user->updated_by = Auth::user()->user_code;
            $user->save();
         }
      }

      //record activity
		$activity     =  Auth::user()->name.' Has added '.$employee->names.' as an employee';
		$module       = 'Human Resource Management';
		$section      = 'Employee';
      $action       = 'Create';
		$activityCode = $employeeCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Employee has been successfully added');

      return redirect()->route('hrm.employee.index');
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($code){
      $employee = employees::join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                     ->join('hr_employee_bank_info','hr_employee_bank_info.employee_code','=','hr_employees.employee_code')
                     ->join('hr_employee_personal_info','hr_employee_personal_info.employee_code','=','hr_employees.employee_code')
                     ->where('hr_employees.business_code',Auth::user()->business_code)
                     ->where('hr_employees.employee_code',$code)
                     ->select('*','hr_employees.employee_code as employee_code','hr_employees.names as employee_name','wp_business.business_code as businessCode')
                     ->first();

      return view('app.hr.employee.show', compact('employee','code'));
   }

   /**
 * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code){
      $employee = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $departments = department::where('business_code',Auth::user()->business_code)->pluck('title','department_code')->prepend('Choose Department','');
      $branches = branches::where('business_code',Auth::user()->business_code)->pluck('name','branch_code')->prepend('Choose department','');
      $positions = positions::where('business_code',Auth::user()->business_code)->pluck('name','position_code')->prepend('Choose Job title','');

      //get leaders
      $employees = employees::where('business_code',Auth::user()->business_code)
                  ->where('status',25)
                  ->get();

      $joinReport = array();
      foreach ($employees as $joint) {
         $joinReport[$joint->employee_code] = $joint->names;
      }

      //join report table
      $getLeaders = report::join('hr_employees','hr_employees.employee_code', '=' ,'hr_employee_report_to.employee')
                  ->where('hr_employee_report_to.employee',$code)
                  ->select('hr_employees.employee_code as reportID')
                  ->get();
      $jointLeaders = array();
      foreach($getLeaders as $gl){
         $jointLeaders[] = $gl->reportID;
      }

      //get departments
      $department = department::where('business_code',Auth::user()->business_code)->get();
      $departments = department::where('business_code',Auth::user()->business_code)
                              ->pluck('title','department_code')
                              ->prepend('choose department','');

      $joinDepartments = array();
      foreach ($department as $dept) {
         $joinDepartments[$dept->department_code] = $dept->title;
      }

      //join department head
      $getHeads = head::join('hr_departments','hr_departments.department_code', '=' ,'hr_employee_department_head.department')
                     ->where('hr_employee_department_head.employee',$code)
                     ->select('hr_departments.department_code as department_code')
                     ->get();

      $jointHeads = array();
      foreach($getHeads as $gh){
         $jointHeads[] = $gh->department_code;
      }

      return view('app.hr.employee.edit', compact('employee','departments','positions','employees','branches','joinReport','jointLeaders','jointHeads','joinDepartments'));
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

      $this->validate($request, array(
         'names'=>'required',
      ));

      $update = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $update->names              = $request->names;
      $update->gender             = $request->gender;
      $update->leave_days         = $request->leave_days;
      $update->company_email      = $request->company_email;
      $update->employment_status  = $request->employment_status;
      $update->department         = $request->department;
      $update->position           = $request->position;
      $update->companyID = $request->companyID;
      $update->branch = $request->branch;
      $update->company_phone_number = $request->company_phone_number;
      $update->office_phone_extension = $request->office_phone_extension;
      $update->source_of_hire = $request->source_of_hire;
      $update->contract_type = $request->contract_type;
      $update->hire_date = $request->hire_date;
      $update->status = $request->status;
      $update->termination_date = $request->termination_date;
      $update->current_status = $request->current_status;
      $update->updated_by = Auth::user()->user_code;
      $update->business_code = Auth::user()->business_code;
      if(!empty($request->image)){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/hr/employee/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
               mkdir($directory, 0777,true);
         }

         //delete estimate if already exists
         if($update->image != ""){
               $delete = $directory.$update->image;
               if (File::exists($delete)) {
               unlink($delete);
               }
         }

         //update estimate to system
         $file = $request->image;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE update WITH RANDOM NUMBER
         $fileName = Helper::seoUrl($request->names).'-'.Helper::generateRandomString(20). '.' . $extension;

         // MOVE THE updateED FILES TO THE DESTINATION DIRECTORY
         $file->move($directory, $fileName);

         $update->image = $fileName;
      }
      $update->save();

      //report to
      $report = count(collect($request->report_to));
      if($report > 0){

         report::where('business_code',Auth::user()->business_code)->where('employee',$code)->delete();

         //upload new category
         for($i=0; $i < count($request->report_to); $i++ ) {
            $rep = new report;
            $rep->employee = $code;
            $rep->leader = $request->report_to[$i];
            $rep->business_code = Auth::user()->business_code;
            $rep->updated_by = Auth::user()->user_code;
            $rep->save();
         }
      }

      $department = count(collect($request->lead_department));
      if($department > 0){

         head::where('business_code',Auth::user()->business_code)->where('employee',$code)->delete();
         //upload new category
         for($i=0; $i < count($request->lead_department); $i++ ) {
            $leaders = new head;
            $leaders->employee = $code;
            $leaders->department = $request->lead_department[$i];
            $leaders->business_code = Auth::user()->business_code;
            $leaders->updated_by = Auth::user()->user_code;
            $leaders->save();
         }
      }

      if($request->company_email){
         //link to user
         $checkForUser = wp_user::where('email',$request->company_email)->where('business_code',Auth::user()->business_code)->count();
         if($checkForUser == 1){
            $user = wp_user::where('email',$request->company_email)->where('business_code',Auth::user()->business_code)->first();
            $user->employee_code = $code;
            $user->updated_by    = Auth::user()->user_code;
            $user->save();
         }
      }

      //record activity
		$activity     =  Auth::user()->name.' Has updated '.$request->names.'s information';
		$module       = 'Human Resource Management';
		$section      = 'Employee';
      $action       = 'Update';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Employee has been updated');

      return redirect()->back();
   }
}
