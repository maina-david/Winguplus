<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\business;
use App\Models\country;
use App\Models\activity_log;
use Session;
use Auth;
use Helper;

class settingsController extends Controller
{
   //account
   public function account(){
      $account = business::where('businessID',Auth::user()->businessID)->first();
      $country = country::pluck('name','name')->prepend('choose country','');
      return view('app.settings.account', compact('account','country'));
   }

   //update account
   public function update_account(Request $request){
      $this->validate($request,[
         'name' => 'required',
         'country' => 'required',
         'business_location' => 'required',
         'phone_number' => 'required',
      ]);

      $business = business::where('businessID',Auth::user()->businessID)->first();
      $business->name = $request->name;
      $business->country = $request->country;
      $business->business_location = $request->business_location;
      $business->phone_number = $request->phone_number;
      $business->save();

      //recorord activity
		$activities = Auth::user()->name.' Has updated the business details';
		$section = 'Settings';
		$action = 'Update';
      $businessID = Auth::user()->businessID;
		$activityID = $business->id;

		Helper::activity($activities,$section,$action,$activityID,$businessID);

      Session::flash('success','Business details updated successfully');

      return redirect()->back();
   }

   //activity_log
   public function activity_log(){
      $activities = activity_log::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

      return view('app.settings.activity', compact('activities'));
   }
}
