<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employee_institution_info;
use App\Models\hr\employees;
use Session;
use Auth;
use Helper;

class academicinformationController extends Controller
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
		$institution = employee_institution_info::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->get();

		//return $institution;
		$edit = employee_primary_info::join('hr_employee_secondary_info','hr_employee_secondary_info.employee_code','=','hr_employee_primary_info.employee_code')
                                    ->where('hr_employee_primary_info.employee_code',$code)
                                    ->select('*','hr_employee_primary_info.employee_code as empid')
                                    ->first();

		$employee = employees::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();

		return view('app.hr.employee.academic', compact('edit','institution','code','employee'));
	}

	public function update(Request $request, $code){

		///primary information
		$primary = employee_primary_info::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$primary->pri_school_name = $request->pri_school_name;
		$primary->pri_year_of_study = $request->pri_year_of_study;
		$primary->pri_results = $request->pri_results;
		$primary->business_code = Auth::user()->business_code;
		$primary->updated_by = Auth::user()->id;
		$primary->save();


		///secondary information
		$secondary = employee_secondary_info::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$secondary->sec_school_name = $request->sec_school_name;
		$secondary->sec_year_of_study = $request->sec_year_of_study;
		$secondary->sec_results = $request->sec_results;
		$secondary->business_code = Auth::user()->business_code;
		$secondary->updated_by = Auth::user()->id;
		$secondary->save();

		Session::flash('success','Academic information has been successfully updated');

		return redirect()->back();
	}


	public function post_institution(Request $request){
		// University/Collage/Institution //
		for($i=0; $i < count($request->institution_name); $i++ ) {

			$institution = new employee_institution_info;
         $institution->institution_code = Helper::generateRandomString(20);
			$institution->school_name = $request->institution_name[$i];
			$institution->result_type = $request->dip_degere[$i];
			$institution->field_of_study = $request->uni_field[$i];
			$institution->year_of_study = $request->uni_date[$i];
			$institution->results = $request->uni_result[$i];
			$institution->employee_code = $request->employee_code[$i];
			$institution->year_of_completion = $request->date_of_competion[$i];
			$institution->business_code = Auth::user()->business_code;
			$institution->created_by = Auth::user()->user_code;
			$institution->save();
		}

		Session::flash('success','Institution information has been successfully updated');

		return redirect()->back();
	}

	public function delete_institution($code){
		$inst = employee_institution_info::where('institution_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$inst->delete();
		Session::flash('success', 'The Institution was successfully deleted !');

		return redirect()->back();
	}
}
