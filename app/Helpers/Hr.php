<?php
namespace App\Helpers;
use App\Models\hr\employees;
use App\Models\hr\type;
use App\Models\hr\leaves;
use App\Models\hr\department;
use App\Models\hr\branches;
use App\Models\hr\payroll_settings;
use App\Models\hr\employee_family_info;
use App\Models\hr\payroll_allocations;
use App\Models\hr\position as positions;
use App\Models\crm\leads\sources;
use App\Models\hr\report_to;
use App\Models\hr\department_heads;
use Auth;
class Hr
{
	//=======================================  Employee   ===========================================
	//===============================================================================================
	public static function employee($code){
		$employee = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $employee;
	}

	public static function check_employee($code){
		$count = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//check if employee repors to someone
	public static function check_if_has_leader($code){
		$check = report_to::where('business_code',Auth::user()->business_code)->where('employee',$code)->count();
		return $check;
	}

	//get the employee heads
	public static function get_employee_leaders($code){
		$leaders = report_to::join('hr_employees','hr_employees.id','=','hr_employee_report_to.leader')
									->where('hr_employee_report_to.business_code',Auth::user()->business_code)
									->where('hr_employee_report_to.employee',$code)
									->get();
		return $leaders;
	}

	//check if employee is head of a department
	public static function check_if_heads_departments($code){
		$check = department_heads::where('business_code',Auth::user()->business_code)->where('employee',$code)->count();
		return $check;
	}

	//get the employee departments
	public static function get_heading_departments($code){
		$departments = department_heads::join('hr_departments','hr_departments.department_code','=','hr_employee_department_head.department')
                              ->where('hr_employee_department_head.business_code',Auth::user()->business_code)
                              ->where('hr_employee_department_head.employee',$code)
                              ->get();
		return $departments;
	}

	public static function employee_children_count($code){
		$children = employee_family_info::where('business_code',Auth::user()->business_code)
							->where('employee_code',$code)
							->where('relationship','Child')
							->count();
		return $children;
	}

	//count employees
	public static function count_employee(){
		$count = employees::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//=======================================  leave type   =========================================
	//===============================================================================================
	public static function check_leave_type($id){
		$check = type::where('business_code',Auth::user()->business_code)->where('id',$id)->count();
		return $check;
	}

	public static function leave_type($id){
		$type = type::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
		return $type;
	}

	//=======================================  department   =========================================
	//department links
	public static function department_links($id){
		$links = department::where('parentID',$id)->where('business_code',Auth::user()->business_code)->get();
		return $links;
	}


	//=======================================  payroll   =========================================
	//setup payroll
	public static function payroll_setting_setup(){
		$create = new payroll_settings;
		$create->business_code = Auth::user()->business_code;
		$create->created_by = Auth::user()->user_code;
		$create->save();
	}

	//calculate deductions
	public static function calculate_deduction($code){
		$deductions = payroll_allocations::where('employee',$code)->where('business_code',Auth::user()->business_code)->sum('amount');
		return $deductions;
	}


	//=======================================  position   ===========================================
	//===============================================================================================
	public static function position($code){
		$position = positions::where('business_code',Auth::user()->business_code)->where('position_code',$code)->first();
		return $position;
	}

	public static function check_position($id){
		$position = positions::where('business_code',Auth::user()->business_code)->where('id',$id)->count();
		return $position;
	}

	//=======================================  department   =========================================
	//===============================================================================================
	//check department
	public static function check_department($code){
		$department = department::where('business_code',Auth::user()->business_code)->where('department_code',$code)->count();
		return $department;
	}

	//get department
	public static function department($code){
		$department = department::where('business_code',Auth::user()->business_code)->where('department_code',$code)->first();
		return $department;
	}

	//=======================================  branch   ===========================================
	//===============================================================================================

	//check branch
	public static function check_branch($code){
		$check = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$code)->count();
		return $check;
	}

	//check branch
	public static function branch($code){
		$branch = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$code)->first();
		return $branch;
	}

	//check if account has branches
	public static function count_branches(){
		$count = branches::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//check if branch has main branch
	public static function check_main_branch(){
		$count = branches::where('business_code',Auth::user()->business_code)->where('main_branch','Yes')->count();
		return $count;
	}

	//make main branch
	public static function add_main_branch(){
		//update all branches with no as main branch value
		branches::where('business_code',Auth::user()->business_code)
							->update(['is_main' => 'No']);

		//get one branch and make it main
		$getBranches = branches::where('business_code',Auth::user()->business_code)->limit(1)->get();

		foreach($getBranches as $branch){
			$update = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$branch->branch_code)->first();
			$update->is_main = 'Yes';
			$update->save();
		}
	}

	//get main branch
	public static function get_main_branch(){
		$main = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->first();
		return $main;
	}

	//create main branch
	public static function create_branch(){
		$branches = new branches;
      $branches->branch_name = 'Main branch';
		$branches->is_main = 'Yes';
      $branches->business_code = Auth::user()->business_code;
      $branches->created_by = Auth::user()->user_code;
      $branches->save();
	}

	//=======================================  source   ===========================================
	//===============================================================================================
	public static function source($id){
		$sources = sources::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
		return $sources;
	}

	//check source
	public static function check_source($id){
		$check = sources::where('business_code',Auth::user()->business_code)->where('id',$id)->count();
		return $check;
	}
}
