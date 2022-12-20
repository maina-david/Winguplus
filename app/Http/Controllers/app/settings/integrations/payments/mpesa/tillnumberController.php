<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class tillnumberController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Get the integration view
   */
   public function till_number($code){
      //get the phone number integration
      $integration = business_payment_integrations::where('code',$code)
                           ->where('business_code',Auth::user()->business_code)
                           ->where('integration_code','mpesatillnumber')
                           ->first();

      return view('app.settings.integrations.payment.mpesa.tillnumber', compact('integration'));
   }

   /**
   * update integration details
   */
   public function update_till_number(Request $request,$code){
      $this->validate($request,[
         'till_number' => 'required',
         'mpesa_name' => 'required',
      ]);

      $update = business_payment_integrations::where('code',$code)
                        ->where('business_code',Auth::user()->business_code)
                        ->where('integration_code','mpesatillnumber')
                        ->first();
      $update->till_number = $request->till_number;
      $update->mpesa_name = $request->mpesa_name;
      $update->business_code = Auth::user()->business_code;
      $update->updated_by = Auth::user()->user_code;
      $update->save();

      Session::flash('success','Mpesa Till number integration successfully updated');

      return redirect()->back();
   }
}
