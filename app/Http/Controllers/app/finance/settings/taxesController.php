<?php

namespace App\Http\Controllers\app\finance\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\tax;
use Wingu;
use Auth;
use Session;
use Helper;

class taxesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $taxes = tax::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $count = 1;
      return view('app.finance.taxes.index', compact('taxes','count'));
   }

   /**
   * store tax
   *
   */
   public function store(Request $request){
      $this->validate($request, [
         'tax_name' => 'required',
         'tax_rate' => 'required',
      ]);

      $code = Helper::generateRandomString(30);
      $tax = new tax;
      $tax->tax_code = $code;
      $tax->name = $request->tax_name;
      $tax->rate = $request->tax_rate;
      $tax->compound = $request->tax_rate / 100;
      $tax->description = $request->description;
      $tax->business_code = Auth::user()->business_code;
      $tax->created_by = Auth::user()->user_code;
      $tax->save();

      //recorded activity
		$activity     = Auth::user()->name.' Has added a new tax rate';
		$module       = 'Finance';
		$section      = 'Tax';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Tax rate successfully added');

      return redirect()->route('finance.settings.taxes');
   }

   /**
   * edit tax
   *
   */
   public function edit($code){
      $data = tax::where('tax_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return response()->json(['data' => $data]);
   }

   /**
   * update tax
   *
   */
   public function update(Request $request){
      $this->validate($request, [
         'name' => 'required',
         'rate' => 'required',
      ]);

      $tax = tax::where('tax_code',$request->taxCode)->where('business_code',Auth::user()->business_code)->first();
      $tax->name = $request->name;
      $tax->rate = $request->rate;
      $tax->compound = $request->rate/100;
      $tax->description = $request->description;
      $tax->business_code = Auth::user()->business_code;
      $tax->updated_by = Auth::user()->user_code;
      $tax->save();

      //recorded activity
		$activity     = Auth::user()->name.' Has made a tax rate update';
		$module       = 'Finance';
		$section      = 'Tax';
      $action       = 'Edit';
		$activityCode = $request->taxCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Tax rate successfully updated');

      return redirect()->route('finance.settings.taxes');
   }

   /**
   * delete tax
   *
   */
   public function delete($code){
      tax::where('tax_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      //record activity
		$activities = Auth::user()->name.' Has deleted a tax rate';
		$section = 'Finance';
		$type = 'Tax rates';
      $adminID = Auth::user()->user_code;
      $business_code = Auth::user()->business_code;
		$activityID = $code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      Session::flash('success','Tax rate successfully deleted');

      return redirect()->back();
   }

   /**
   * express tax
   *
   */
   public function store_express(Request $request){

      $code = Helper::generateRandomString(30);
      $tax = new tax;
      $tax->tax_code = $code;
      $tax->name = $request->tax_name;
      $tax->rate = $request->rate;
      $tax->compound = $request->rate/100;
      $tax->business_code = Auth::user()->business_code;
      $tax->created_by = Auth::user()->user_code;
      $tax->save();

      //recorded activity
		$activity     = Auth::user()->name.' Has added a new tax rate';
		$module       = 'Finance';
		$section      = 'Tax';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);
   }

   /**
   * express list
   *
   */
   public function express_list(){
      $taxes = tax::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'rate as text']);
      return ['results' => $taxes];
   }
}
