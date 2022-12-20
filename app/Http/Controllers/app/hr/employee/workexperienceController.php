<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\jobs_experience;
use App\Models\hr\employees;
use Helper;
use Session;
use Auth;
class workexperienceController extends Controller
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
		$experiences = jobs_experience::where('employee_code',$code)->where('business_code',Auth::user()->business_code)->get();
		$employee = employees::where('business_code',Auth::user()->business_code)->where('employee_code',$code)->first();

		return view('app.hr.employee.experience', compact('experiences','employee'));
	}

	public function store(Request $request){
		$size = count(collect($request->prev_company));
		if($size > 0){
			for($i=0; $i < count($request->prev_company); $i++ ) {
				$experience = new jobs_experience;
            $experience->experience_code = Helper::generateRandomString(20);
				$experience->previous_company_name = $request->prev_company[$i];
				$experience->job_title = $request->prev_job_title[$i];
				$experience->date_started = $request->prev_from[$i];
				$experience->date_stopped = $request->prev_to[$i];
				$experience->job_description = $request->prev_job_description[$i];
				$experience->employee_code = $request->employee_code[$i];
				$experience->business_code = Auth::user()->business_code;
				$experience->created_by = Auth::user()->user_code;
				$experience->save();
			}

			Session::flash('success','Previous Work experience information has been successfully updated');
		}else{
			Session::flash('error','Please add a previous work experience');
		}

		return redirect()->back();
	}

	public function edit_institution($id){

	}

	public function delete($code){
		$experience = jobs_experience::where('experience_code',$code)->where('business_code',Auth::user()->business_code)->first();
		$experience->delete();

		Session::flash('success', 'Delete was successful !');

		return redirect()->back();
	}
}
