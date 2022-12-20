<?php

namespace App\Http\Controllers\app\settings\integrations\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\invoice\invoice_settings;
use App\Models\wingu\payment_integrations;
use Session;
use Auth;
use Helper;
use Finance;
use Wingu;

class paymentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      //create creditnote settings for the account
      $check = creditnote_settings::where('business_code',Auth::user()->business_code)->count();
         if($check != 1){
         Finance::creditnote_setting_setup();
      }

      //create invoice settings for the account
      $check = invoice_settings::where('business_code',Auth::user()->business_code)->count();
			if($check != 1){
				Finance::invoice_setting_setup();
			}

      $businessIntegrations = business_payment_integrations::join('wp_payment_integrations','wp_payment_integrations.integration_code','=','wp_business_payment_integrations.integration_code')
                              ->join('wp_status','wp_status.id','=','wp_business_payment_integrations.status')
                              ->where('wp_business_payment_integrations.business_code',Auth::user()->business_code)
                              ->orderby('wp_business_payment_integrations.id','desc')
                              ->select('*','wp_business_payment_integrations.status as paymentStatus','wp_status.name as statusName','wp_payment_integrations.name as integration_name')
                              ->get();

      $integrations = payment_integrations::where('status',15)->pluck('name','integration_code')->prepend('Choose your preferred payment integrations','');

      return view('app.settings.integrations.payment.index', compact('businessIntegrations','integrations'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'integration' => 'required',
         'status' => 'required',
      ]);

      //check if this payment is already assigned
      $check = business_payment_integrations::where('business_code',Auth::user()->business_code)->where('integration_code',$request->integration)->count();

      if ($check != 0) {
         Session::flash('error','This integration is already assigned to you account');

         return redirect()->back();
      }

      $integration                   = new business_payment_integrations;
      $integration->integration_code             = Helper::generateRandomString(30);
      $integration->business_code    = Auth::user()->business_code;
      $integration->integration_code = $request->integration;
      $integration->status           = $request->status;
      $integration->created_by       = Auth::user()->user_code;
      $integration->save();

      Session::flash('success','Payment gateway successfully added');

      return redirect()->back();
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function status($code,$status)
   {
      $update = business_payment_integrations::where('business_code',Auth::user()->business_code)->where('integration_code',$code)->first();
      $update->status = $status;
      $update->save();

      Session::flash('success','Status Successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($code)
   {
      business_payment_integrations::where('business_code',Auth::user()->business_code)->where('integration_code',$code)->delete();

      Session::flash('success','Integration Successfully deleted');

      return redirect()->back();
   }
}
