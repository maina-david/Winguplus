<?php

namespace App\Http\Controllers\app\assets\asset;

use App\Http\Controllers\Controller;
use App\Models\asset\assets;
use Illuminate\Http\Request;
use App\Models\asset\events;
use Helper;
use Auth;
use Session;

class checkoutcheckinController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * check out asset
   *
   * @return \Illuminate\Http\Response
   */
   public function check_out_store(Request $request)
   {
      $this->validate($request, [
         'action_date' => 'required',
      ]);

      $checkout = new events;
      $checkout->code            = Helper::generateRandomString(30);
      $checkout->asset_code      = $request->assetID;
      $checkout->status          = $request->status;
      $checkout->action_date     = $request->action_date;
      $checkout->due_action_date = $request->due_action_date;
      $checkout->check_out_to    = $request->check_out_to;
      $checkout->branch          = $request->branch;
      $checkout->employee        = $request->employee;
      $checkout->site_location   = $request->site_location;
      $checkout->department      = $request->department;
      $checkout->note            = $request->note;
      $checkout->created_by      = Auth::user()->user_code;
      $checkout->business_code   = Auth::user()->business_code;
      $checkout->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$request->assetID)->first();
      $asset->employee       = $request->employee;
      $asset->company_branch = $request->branch;
      $asset->current_status = $request->status;
      $asset->department     = $request->department;
      $asset->save();

      Session::flash('success','asset successfully checked out');

      return redirect()->back();
   }

   //update create checkout
   public function check_out_update(Request $request, $code)
   {
      $this->validate($request, [
         'action_date' => 'required',
      ]);

      $checkout = events::where('business_code',Auth::user()->business_code)->where('code',$code)->first();
      $checkout->status          = $request->status;
      $checkout->action_date     = $request->action_date;
      $checkout->due_action_date = $request->due_action_date;
      $checkout->check_out_to    = $request->check_out_to;
      $checkout->branch          = $request->branch;
      $checkout->employee        = $request->employee;
      $checkout->site_location   = $request->site_location;
      $checkout->department      = $request->department;
      $checkout->note            = $request->note;
      $checkout->updated_by      = Auth::user()->user_code;
      $checkout->business_code   = Auth::user()->business_code;
      $checkout->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$request->assetID)->first();
      $asset->employee = $request->employee;
      $asset->save();

      Session::flash('success','asset successfully checked out');

      return redirect()->back();
   }

   /**
   * check in
   *
   * @return \Illuminate\Http\Response
   */
   //create checkout
   public function check_in_store(Request $request)
   {
      $this->validate($request, [
         'action_date' => 'required',
      ]);

      $checkin = new events;
      $checkin->code           = Helper::generateRandomString(30);
      $checkin->asset_code     = $request->asset_code;
      $checkin->status         = $request->status;
      $checkin->action_date    = $request->action_date;
      $checkin->site_location  = $request->site_location;
      $checkin->note           = $request->note;
      $checkin->created_by     = Auth::user()->user_code;
      $checkin->business_code  = Auth::user()->business_code;
      $checkin->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$request->asset_code)->first();
      $asset->current_status = $request->status;
      $asset->employee       = "";
      $asset->save();

      Session::flash('success','asset successfully checked out');

      return redirect()->back();
   }

  //update create checkout
  public function check_in_update(Request $request, $code)
  {
     $this->validate($request, [
        'action_date' => 'required',
     ]);

     $checkout = events::where('business_code',Auth::user()->business_code)->where('code',$code)->first();
     $checkout->action_date   = $request->action_date;
     $checkout->site_location = $request->site_location;
     $checkout->note          = $request->note;
     $checkout->updated_by    = Auth::user()->user_code;
     $checkout->business_code = Auth::user()->business_code;
     $checkout->save();

     Session::flash('success','asset successfully checked in');

     return redirect()->back();
  }

   /**
   * delete events
   *
   * @param string $code
   */
   public function delete($assetCode,$code){
      $delete = events::where('business_code',Auth::user()->business_code)->where('code',$code)->first();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->employee       = "";
      $asset->company_branch = "";
      $asset->current_status = "";
      $asset->department     = "";
      $asset->save();

      $delete->delete();

      Session::flash('success','Event successfully deleted');

      return redirect()->back();
   }
}
