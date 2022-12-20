<?php

namespace App\Http\Controllers\app\dashboard;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\wingu\business_modules;
use App\Models\hr\branches;
use Wingu;
use Auth;
use  Helper;
use Finance;

class dashboardController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function dashboard()
   {
      //check if account has no branches
      $checkBranches = branches::where('business_code',Auth::user()->business_code)->count();
      if($checkBranches == 0){
         $branches = new branches;
         $branches->branch_code = Helper::generateRandomString(20);
         $branches->name = 'Main branch';
         $branches->is_main = 'Yes';
         $branches->business_code = Auth::user()->business_code;
         $branches->created_by = Auth::user()->user_code;
         $branches->save();
      }

      //settings
      $check = creditnote_settings::where('business_code',Auth::user()->business_code)->count();
			if($check != 1){
			Finance::creditnote_setting_setup();
		}

      //modules
      $modules = business_modules::join('wp_modules','wp_modules.module_code','=','wp_business_modules.module_code')
                        ->where('business_code',Auth::user()->business_code)
                        ->get();

      if($modules->count() == 0){
         return  redirect()->route('winguplus.apps');
      }

      return view('app.dashboard.dashboard', compact('modules'));
   }
}
