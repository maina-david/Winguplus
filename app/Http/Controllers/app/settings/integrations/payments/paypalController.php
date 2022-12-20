<?php

namespace App\Http\Controllers\app\settings\integrations\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Finance;
use Session;

class paypalController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $code
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $edit = business_payment_integrations::where('integration_code',$code)->where('business_code',Auth::user()->business_code)->where('integration_code','paypal')->first();

      return view('app.settings.integrations.payment.paypal', compact('edit'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $code
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $code)
   {
      $this->validate($request, [
         'paypal_email' => 'required',
         'currency_code' => 'required',
         'paypal_conversion_rate' => 'required',
         'callback_url' => 'required',
      ]);

      $edit = business_payment_integrations::where('integration_code',$code)->where('business_code',Auth::user()->business_code)->where('integration_code','paypal')->first();
      $edit->paypal_email = $request->paypal_email;
      $edit->currency_code = $request->currency_code;
      $edit->paypal_conversion_rate = $request->paypal_conversion_rate;
      $edit->callback_url = $request->callback_url;
      $edit->cancel_url = $request->cancel_url;
      $edit->live_or_sandbox = $request->live_or_sandbox;
      $edit->wingustore_callback_url = $request->wingustore_callback_url;
      $edit->wingustore_cancel_url = $request->wingustore_cancel_url;
      $edit->save();

      Session::flash('success','Paypal information has been successfully updated');

      return redirect()->back();
   }
}
