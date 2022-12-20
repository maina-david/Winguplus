<?php

namespace App\Http\Controllers\app\hr\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\leaves;
use App\Models\hr\type;
use App\Charts\Hr\Reports;
use Wingu;
use Auth;
use DB;
class dashboardController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function dashboard()
   {
      $year = date('Y');

      $employees = employees::where('business_code',Auth::user()->business_code)->count();
      $activeEmployees = employees::where('business_code',Auth::user()->business_code)->where('status',25)->count();
      $leaveRequests = leaves::where('business_code',Auth::user()->business_code)->count();

      /*
      * leave report
      * */
      $leaveReport = new Reports;

      $types = type::where('business_code',Auth::user()->business_code)->pluck('name');
      $approved =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('status',19)
                        ->select(DB::raw('count(*) as total'))
                        ->where('business_code',Auth::user()->business_code)
                        ->groupBy('type_code')
                        ->pluck('total');

      $denied =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('status',20)
                        ->select(DB::raw('count(*) as total'))
                        ->where('business_code',Auth::user()->business_code)
                        ->groupBy('type_code')
                        ->pluck('total');

      $pending =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('status',7)
                        ->select(DB::raw('count(*) as total'))
                        ->where('business_code',Auth::user()->business_code)
                        ->groupBy('type_code')
                        ->pluck('total');

      $leaveReport->labels($types->values());
      $leaveReport->dataset('Denied', 'bar', $denied->values())->backgroundColor('rgba(221,5,5,0.4)');
      $leaveReport->dataset('Approved', 'bar', $approved->values())->backgroundColor('rgba(17,147,30,0.4)');
      $leaveReport->dataset('Pending', 'bar', $pending->values())->backgroundColor('rgba(40,95,255,0.4)');

      return view('app.hr.hrm.dashboard',compact('employees','activeEmployees','leaveRequests','leaveReport'));
   }
}
