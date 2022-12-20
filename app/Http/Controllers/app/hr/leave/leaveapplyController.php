<?php

namespace App\Http\Controllers\app\hr\leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\leaves;
use App\Models\hr\type;
use Auth;
use Session;
use Helper;

class leaveapplyController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //personal list
   public function my_list(){

      $leaves = leaves::join('hr_employees','hr_employees.employee_code','=','hr_leave.employee_code')
                        ->join('wp_status','wp_status.id','=','hr_leave.status')
                        ->join('hr_leave_type','hr_leave_type.type_code','=','hr_leave.type_code')
                        ->where('hr_leave.business_code',Auth::user()->business_code)
                        ->where('hr_leave.employee_code',Auth::user()->employee_code)
                        ->orderby('hr_leave.id','desc')
                        ->select('*','hr_leave.status as status','wp_status.name as statusName','hr_leave_type.name as leaveName')
                        ->get();
                        
      return view('app.hr.leave.application.index', compact('leaves'));
   }

   //application
   public function application(){
      $types = type::where('business_code',Auth::user()->business_code)->pluck('name','type_code')->prepend('Choose leave type','');
      return view('app.hr.leave.application.create', compact('types'));
   }

   // store application
   public function store(Request $request){
      $this->validate($request, [
         'start_date' => 'required',
         'end_date' => 'required',
         'type_code' => 'required',
         'reason' => 'required',
      ]);

      $leave = new leaves;
      $leave->leave_code = Helper::generateRandomString(30);
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->days = Helper::date_difference($request->end_date,$request->start_date);
      $leave->reason = $request->reason;
      $leave->type_code = $request->type_code;
      $leave->status = 7;
      $leave->employee_code = Auth::user()->employee_code;
      $leave->business_code = Auth::user()->business_code;
      $leave->created_by = Auth::user()->user_code;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Application successful, awaiting approval');

      return redirect()->route('hrm.leave.apply.index');
   }

   //edit
   public function edit($code){
      $edit = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $types = type::where('business_code',Auth::user()->business_code)->pluck('name','type_code')->prepend('Choose leave type','');

      return view('app.hr.leave.application.edit', compact('edit','types'));
   }

   // store application
   public function update(Request $request, $code){
      $this->validate($request, [
         'start_date' => 'required',
         'end_date' => 'required',
         'type_code' => 'required',
         'reason' => 'required',
      ]);

      $leave = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->days = Helper::date_difference($request->end_date,$request->start_date);
      $leave->reason = $request->reason;
      $leave->type_code = $request->type_code;
      $leave->employee_code = Auth::user()->employee_code;
      $leave->business_code = Auth::user()->business_code;
      $leave->updated_by = Auth::user()->user_code;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Application successful updated');

      return redirect()->back();
   }

}
