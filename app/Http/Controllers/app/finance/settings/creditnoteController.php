<?php

namespace App\Http\Controllers\app\finance\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\creditnote\creditnote_settings;
use Session;
use Auth;
use Wingu;

class creditnoteController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $check = creditnote_settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::creditnote_setting_setup();
      }

      $settings = creditnote_settings::where('business_code',Auth::user()->business_code)->first();
      $count = 1;

      return view('app.finance.creditnote.settings.index', compact('settings','count'));

   }

   public function update_generated_number(Request $request, $id){
      $this->validate($request, [
         'number' => 'required',
         'prefix' => 'required',
      ]);

      $settings = creditnote_settings::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $settings->number = $request->number;
      $settings->prefix = $request->prefix;
      $settings->created_by = Auth::user()->user_code;
      $settings->save();

      //record activity
      $activity     = Auth::user()->name.' Has made changes to the Credit Note Number and Credit Note Prefix';
		$module       = 'Credit note';
		$section      = 'Settings';
      $action       = 'Update';
		$activityCode = $id;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Credit Note settings Updated successfully');

      return redirect()->back();
   }

   public function update_defaults(Request $request, $id){
      $settings = creditnote_settings::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $settings->default_terms_conditions = $request->default_terms_conditions;
      $settings->default_footer = $request->default_footer;
      $settings->default_customer_notes = $request->default_customer_notes;
      $settings->created_by = Auth::user()->user_code;
      $settings->save();

      //record activity
      $activity     = Auth::user()->name.' Has made changes to the Credit Note Terms and condition, Credit Note Footer and Customer Footer';
      $module       = 'Credit note';
      $section      = 'Settings';
      $action       = 'Update';
      $activityCode = $id;

      Wingu::activity($activity,$module,$section,$action,$activityCode);


      Session::flash('success','Credit Note settings Updated successfully');

      return redirect()->back();
   }

   public function update_tabs(Request $request, $id){

      $settings = creditnote_settings::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $settings->show_discount_tab = $request->show_discount_tab;
      $settings->show_tax_tab = $request->show_tax_tab;
      $settings->created_by = Auth::user()->user_code;
      $settings->save();

      //record activity
      $activity     = Auth::user()->name.' Has made changes to the Credit Note Show Discount tab on Credit Note & Show Tax tab on Credit Note';
      $module       = 'Credit note';
      $section      = 'Settings';
      $action       = 'Update';
      $activityCode = $id;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Credit Note settings Updated successfully');

      return redirect()->back();
   }

}
