<?php

namespace App\Http\Controllers\app\settings\integrations\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_gateways;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;

class pesapalController extends Controller
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
      //
   }

   /**
    * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function edit($code)
   {
      $edit = business_payment_integrations::where('integration_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.settings.integrations.payment.pesapal', compact('edit','code'));
   }

   /**
    * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function update(Request $request, $code)
   {
      $this->validate($request, [
         'customer_key' => 'required',
         'customer_secret' => 'required',
         'callback_url' => 'required',
         'ipn' => 'required',
         'live_or_sandbox' => 'required',

      ]);

      $edit = business_payment_integrations::where('integration_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $edit->customer_key = $request->customer_key;
      $edit->customer_secret = $request->customer_secret;
      $edit->ipn = $request->ipn;
      $edit->callback_url = $request->callback_url;
      $edit->status = $request->status;
      $edit->live_or_sandbox = $request->live_or_sandbox;
      $edit->currency_code = $request->currency_code;
      $edit->save();

      Session::flash('success','Pesapal information has been successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function destroy($id)
   {
      //
   }
}
