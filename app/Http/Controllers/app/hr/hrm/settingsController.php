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
class settingsController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function leave_types(){
      return view('app.hr.hrm.settings');
   }
}
