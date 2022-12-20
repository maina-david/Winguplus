<?php

namespace App\Http\Controllers\app\assets\asset;

use App\Http\Controllers\Controller;
use App\Models\asset\assets;
use Illuminate\Http\Request;
use App\Models\asset\events;
use Helper;
use Auth;
use Session;

class repairController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * add repair log
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request,$code)
   {
      $this->validate($request, [
         'action_date' => 'required',
      ]);

      $repair = new events;
      $repair->code            = Helper::generateRandomString(30);
      $repair->asset_code      = $code;
      $repair->status          = 34;
      $repair->action_date     = $request->action_date;
      $repair->due_action_date = $request->due_action_date;
      $repair->employee        = $request->employee;
      $repair->cost            = $request->cost;
      $repair->note            = $request->note;
      $repair->supplier        = $request->supplier;
      $repair->created_by      = Auth::user()->user_code;
      $repair->business_code   = Auth::user()->business_code;
      $repair->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$code)->first();
      $asset->current_status = 34;
      $asset->save();

      Session::flash('success','Log successfully add');

      return redirect()->back();
   }


   /**
   * update repair log
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $asset, $code){
      $edit = events::where('business_code',Auth::user()->business_code)->where('code',$code)->first();
      $edit->action_date     = $request->action_date;
      $edit->due_action_date = $request->due_action_date;
      $edit->employee        = $request->employee;
      $edit->cost            = $request->cost;
      $edit->note            = $request->note;
      $edit->supplier        = $request->supplier;
      $edit->updated_by      = Auth::user()->user_code;
      $edit->save();

      Session::flash('success','Log successfully updated');

      return redirect()->back();
   }

   /**
   * Delete repair log
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($asset, $code){

      events::where('business_code',Auth::user()->business_code)->where('code',$code)->deleted();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$asset)->first();
      $asset->current_status = "";
      $asset->save();

      Session::flash('success','Log successfully deleted');

      return redirect()->back();
   }

}
