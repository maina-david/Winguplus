<?php

namespace App\Http\Controllers\app\hr\leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\type;
use App\Models\hr\leaves;
use App\Models\hr\employees;
use App\Mail\sendMessage;
use Calendar;
use Session;
use Helper;
use Mail;
use Auth;


class leaveController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
    * show leave requests
    *
    * @return \Illuminate\Http\Response
    */
   public function index(){
      $date = date('Y-m-d');
      $leaves = leaves::join('hr_employees','hr_employees.employee_code','=','hr_leave.employee_code')
                     ->join('wp_status','wp_status.id','=','hr_leave.status')
                     ->join('hr_leave_type','hr_leave_type.type_code','=','hr_leave.type_code')
                     ->where('hr_leave.business_code',Auth::user()->business_code)
                     ->orderby('hr_leave.id','desc')
                     ->select('*','hr_leave.status as status','wp_status.name as statusName','hr_leave_type.name as leaveName')
                     ->get();

      $current = leaves::where('status',19)->where('business_code',Auth::user()->business_code)->where('start_date','<',$date)->where('end_date','>',$date)->count();

      $pending = leaves::where('status',7)->where('business_code',Auth::user()->business_code)->count();
      $approved = leaves::where('status',19)->where('business_code',Auth::user()->business_code)->count();
      $rejected = leaves::where('status',20)->where('business_code',Auth::user()->business_code)->count();


      return view('app.hr.leave.index', compact('leaves','current','pending','approved','rejected'));
   }

   /**
   * create
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      $types = type::where('business_code',Auth::user()->business_code)->pluck('name','type_code')->prepend('Choose leave type','');
      $employees = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('choose employee','');

      return view('app.hr.leave.create', compact('types','employees'));
   }

   /**
    * store leave
    *
    * @return \Illuminate\Http\Response
    */
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
      $leave->employee_code = $request->employee_code;
      $leave->business_code = Auth::user()->business_code;
      $leave->created_by = Auth::user()->user_code;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Request successful, awaiting approval');

      return redirect()->route('hrm.leave.index');
   }

   /**
    * edit leave
    *
    * @return \Illuminate\Http\Response
   */
   public function edit($code){
      $edit = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $types = type::where('business_code',Auth::user()->business_code)->pluck('name','type_code')->prepend('Choose leave type','');
      $employees = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('choose employee','');
      return view('app.hr.leave.edit', compact('types','employees','edit'));
   }

   /**
    * update leave
    *
    * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code){

      $leave = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->days = Helper::date_difference($request->end_date,$request->start_date);
      $leave->reason = $request->reason;
      $leave->type_code = $request->type_code;
      $leave->employee_code = $request->employee_code;
      $leave->business_code = Auth::user()->business_code;
      $leave->updated_by = Auth::user()->user_code;
      $leave->save();

      Session::flash('success','Leave successfully updated');

      return redirect()->back();
   }

   /**
   * show leave balance
   *
   * @return \Illuminate\Http\Response
   */
   public function balance(){
      return view('app.hr.leave.balance');
   }

   /**
   * show leave balance
   *
   * @return \Illuminate\Http\Response
   */
   public function calendar(){
      $events = [];
      $data = leaves::join('hr_employees','hr_employees.employee_code','=','hr_leave.employee_code')
                     ->join('wp_status','wp_status.id','=','hr_leave.status')
                     ->join('hr_leave_type','hr_leave_type.type_code','=','hr_leave.type_code')
                     ->where('hr_leave.business_code',Auth::user()->business_code)
                     ->select('*','hr_leave_type.name as leaveName')
                     ->get();

      if($data->count()) {
         foreach ($data as $key => $value) {
            $events[] = Calendar::event(
               $value->names.'-'.$value->leaveName,
               true,
               new \DateTime($value->start_date),
               new \DateTime($value->end_date),
               null,
               // Add color and link on event
               [
                  'color' => $value->color,
                  //'url' => 'pass here url and any route',
               ]
            );
         }
      }

      $calendar = Calendar::addEvents($events);

      return view('app.hr.leave.calendar', compact('calendar'));
   }

   /**
   * approve leave
   *
   * @return \Illuminate\Http\Response
   */
   public function approve($code){
      $leave = leaves::where('leave_code',$code)->where('hr_leave.business_code',Auth::user()->business_code)->first();

      $employee = employees::where('employee_code',$leave->employee_code)->where('business_code',Auth::user()->business_code)->first();

      if($employee->leave_days == 0 || $employee->leave_days == ""){
         Session::flash('warning','Please check the leave days allocated to '.$employee->names.' Its currently reading 0 days');
         return redirect()->back();
      }

      $employee->leave_days = $employee->leave_days - $leave->days;
      $employee->save();

      //updated leave
      $leave->status = 19;
      $leave->save();

      //send system email for leave approval
      if($employee->company_email != ""){
         $subject = 'Leave Approval Notification';
         $to = $employee->company_email;
         $content = '<h3>Hi, '.$employee->names.'</h3>
                     <p>Your leave application has been approved</p>
                     <p>Thank you.</p>';
         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Leave successfully approved');

      return redirect()->back();
   }

   /**
   * denay leave
   *
   * @return \Illuminate\Http\Response
   */
   public function denay($code){
      $leave = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $employee = employees::where('employee_code',$leave->employee_code)->where('business_code',Auth::user()->business_code)->first();

      if($employee->leave_days == 0 || $employee->leave_days == ""){
         Session::flash('warning','Please check the leave days allocated to '.$employee->names.' Its currently reading 0 days');
         return redirect()->back();
      }

      //updated leave
      $leave->status = 20;
      $leave->save();

      //send system email for leave approval
      if($employee->company_email != ""){
         $subject = 'Leave Denial Notification';
         $to = $employee->company_email;
         $content = '<h3>Hi, '.$employee->names.'</h3>
                     <p>Your leave application has been denied</p>
                     <p>Thank you.</p>';
         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Leave successfully denied');

      return redirect()->back();
   }

   /**
   * Delete leave
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($code){
      $leave = leaves::where('leave_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $leave->delete();

      Session::flash('success','Leave successfully deleted');

      return redirect()->back();
   }

}

