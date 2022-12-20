<?php

namespace App\Http\Controllers\app\assets\asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\asset\assets;
use App\Models\finance\suppliers\suppliers;
use App\Models\asset\maintenance;
use App\Models\hr\branches;
use Auth;
use Session;
use Helper;

class maintenancesController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request,$code)
   {
      $this->validate($request,[
         'supplier'        => 'required',
         'title'           => 'required',
         'start_date'      => 'required',
         'completion_date' => 'required',
      ]);

      $maintenanceCode = Helper::generateRandomString(30);

      $maintenance = new maintenance;
      $maintenance->maintenance_code = $maintenanceCode;
      $maintenance->supplier = $request->supplier;
      $maintenance->maintenance_type = $request->maintenance_type;
      $maintenance->title = $request->title;
      $maintenance->start_date = $request->start_date;
      $maintenance->completion_date = $request->completion_date;
      $maintenance->warranty_improvement = $request->warranty_improvement;
      $maintenance->cost = $request->cost;
      $maintenance->note = $request->note;
      $maintenance->asset_code = $code;
      $maintenance->created_by    = Auth::user()->user_code;
      $maintenance->business_code = Auth::user()->business_code;
      $maintenance->save();


      $update = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $update->next_inspection_date = $request->next_inspection_date;
      $update->save();

      Session::flash('success','Maintenance successfully added');

      Return redirect()->route('assets.maintenances.index',$code);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($asset,$edit)
   {
      $edit = maintenance::where('business_code',Auth::user()->business_code)
                        ->where('maintenance_code',$edit)
                        ->where('asset_code',$asset)
                        ->first();

      $details  = assets::where('asset_code',$asset)->where('business_code',Auth::user()->business_code)->first();
      $code = $asset;

      $branches = branches::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('name','branch_code')->prepend('Chooose branch','');
      

      return view('app.assets.assets.view', compact('details','edit','code','branches'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request,$asset,$edit)
   {
      $this->validate($request,[
         'supplier'        => 'required',
         'title'           => 'required',
         'start_date'      => 'required',
         'completion_date' => 'required',
      ]);

      $maintenance = maintenance::where('business_code',Auth::user()->business_code)
                                 ->where('maintenance_code',$edit)
                                 ->where('asset_code',$asset)
                                 ->first();

      $maintenance->supplier             = $request->supplier;
      $maintenance->maintenance_type     = $request->maintenance_type;
      $maintenance->title                = $request->title;
      $maintenance->start_date           = $request->start_date;
      $maintenance->completion_date      = $request->completion_date;
      $maintenance->warranty_improvement = $request->warranty_improvement;
      $maintenance->cost                 = $request->cost;
      $maintenance->note                 = $request->note;
      $maintenance->updated_by           = Auth::user()->user_code;
      $maintenance->business_code        = Auth::user()->business_code;
      $maintenance->save();

      $update = assets::where('asset_code',$asset)->where('business_code',Auth::user()->business_code)->first();
      $update->next_inspection_date = $request->next_inspection_date;
      $update->save();

      Session::flash('success','Maintenance successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($asset,$code)
   {
      maintenance::where('business_code',Auth::user()->business_code)
                                 ->where('maintenance_code',$code)
                                 ->where('asset_code',$asset)
                                 ->delete();

      Session::flash('success','Maintenance successfully deleted');

      return redirect()->back();
   }
}
