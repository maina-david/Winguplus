<?php
namespace App\Http\Controllers\app\finance\settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\lpo\lpo_settings;
use Session;
use Auth;
use Wingu;
use Finance;

class lpoController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $check = lpo_settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::lpo_setting_setup();
      }

      $settings = lpo_settings::where('business_code',Auth::user()->business_code)->first();
      $count = 1;

      return view('app.finance.purchaseorders.settings.index', compact('settings','count'));
   }

   public function update_generated_number(Request $request, $id){
      $this->validate($request, [
         'number' => 'required',
         'prefix' => 'required',
      ]);

      $settings = lpo_settings::where('business_code',Auth::user()->business_code)->first();
      $settings->number = $request->number;
      $settings->prefix = $request->prefix;
      $settings->save();

      //recorord activity
		$activities = Auth::user()->name.' Has made changes to the PO Number and lpo Prefix';
		$section = 'Settings';
		$type = 'lpo Settings';
      $adminID = Auth::user()->user_code;
      $business_code = Auth::user()->business_code;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','PO settings Updated successfully');

      return redirect()->back();
   }

   public function update_defaults(Request $request, $id){
      $settings = lpo_settings::where('business_code',Auth::user()->business_code)->first();
      $settings->default_terms_conditions = $request->default_terms_conditions;
      $settings->default_footer = $request->default_footer;
      $settings->default_customer_notes = $request->default_customer_notes;
      $settings->save();

      //recorord activity
		$activities = Auth::user()->name.' Has made changes to the PO Terms and condition, PO Footer and Customer Footer';
		$section = 'Settings';
		$type = 'lpo Settings';
      $adminID = Auth::user()->user_code;
      $business_code = Auth::user()->business_code;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','lpo settings Updated successfully');

      return redirect()->back();
   }

   public function update_tabs(Request $request, $id){

      $settings = lpo_settings::where('business_code',Auth::user()->business_code)->first();
      $settings->show_discount_tab = $request->show_discount_tab;
      $settings->show_tax_tab = $request->show_tax_tab;
      $settings->save();

      //recorord activity
		$activities = Auth::user()->name.' Has made changes to the PO Show Discount tab on lpo & Show Tax tab on Quote';
		$section = 'Settings';
		$type = 'Invoice';
      $adminID = Auth::user()->user_code;
      $business_code = Auth::user()->business_code;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','PO settings Updated successfully');

      return redirect()->back();
   }

}
