<?php
namespace App\Http\Controllers\app\crm\dashboard;

use App\Charts\Crm\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\crm\deals\appointments;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use Auth;
use DB;
use Wingu;
use Helper;
class dashboardController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application personal dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function dashboard(){
      return view('app.crm.dashboard.dashboard');
   }


   /**
    * Show the application manager dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function manager_dashboard()
   {
      return view('app.crm.dashboard.manager_dashboard');
   }
}
