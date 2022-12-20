<?php

namespace App\Http\Controllers\app\finance\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\payments\payment_methods;
use Auth;
use Session;
use Helper;

class paymentModeController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $methods = payment_methods::where('business_code',Auth::user()->business_code)->get();

      return view('app.finance.payments.settings.index', compact('methods'));
   }

   public function store(Request $request){

      $mode = new payment_methods;
      $mode->method_code = Helper::generateRandomString(30);
      $mode->name = $request->name;
      $mode->description = $request->description;
      $mode->created_by = Auth::user()->user_code;
      $mode->business_code = Auth::user()->business_code;
      $mode->save();

      Session::flash('success','Payment mode successfully updated');

      return redirect()->back();
   }

   public function update(Request $request,$code){
      $edit = payment_methods::where('business_code',Auth::user()->business_code)->where('method_code',$code)->first();

      $edit->name = $request->name;
      $edit->description = $request->description;
      $edit->updated_by = Auth::user()->user_code;
      $edit->business_code = Auth::user()->business_code;
      $edit->save();

      Session::flash('success','Payment mode successfully updated');

      return redirect()->back();
   }

   public function delete($code){

      //check if in use in payments
      $payment = invoice_payments::where('business_code',Auth::user()->business_code)->where('payment_method',$code)->count();

      if($payment == 0){

         $delete = payment_methods::where('method_code',$code)->where('business_code',Auth::user()->business_code)->delete();

         Session::flash('success','payment mode successfully deleted');

         return redirect()->back();
      }else{
         Session::flash('error','You have recorded transactions on this payment mode. Hence, this mode cannot be deleted.');

			return redirect()->back();
      }

   }

   public function express_store(Request $request){
      $mode = new payment_methods;
      $mode->method_code = Helper::generateRandomString(30);
      $mode->name = $request->name;
      $mode->created_by = Auth::user()->id;
      $mode->business_code = Auth::user()->business_code;
      $mode->save();
   }


   public function express_list(){
      $method = payment_methods::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'name as text']);
      return ['results' => $method];
   }
}
