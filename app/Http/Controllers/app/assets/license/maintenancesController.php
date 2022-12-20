<?php

namespace App\Http\Controllers\app\assets\license;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\asset\assets;
use App\Models\finance\suppliers\suppliers;
use App\Models\asset\maintenance;
use Session;
use Auth;
use Wingu;
use File;
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
         'supplier' => 'required',
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
      $maintenance->created_by = Auth::user()->user_code;
      $maintenance->business_code = Auth::user()->business_code;
      $maintenance->save();

      Session::flash('success','Maintenance successfully added');

      return redirect()->route('licenses.maintenances.index',$code);
   }

   public function show($code){
      $details  = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $maintenances = maintenance::where('business_code',Auth::user()->business_code)
                                 ->where('asset_code',$code)
                                 ->orderby('id','desc')
                                 ->get();

      return view('app.assets.licenses.view', compact('details','suppliers','maintenances'));
   }

   /**
    * Show the form for editing the specified resource.
 *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($asset,$code)
   {
      $edit = maintenance::where('business_code',Auth::user()->business_code)
                        ->where('maintenance_code',$code)
                        ->where('asset_code',$asset)
                        ->first();

      $details  = assets::where('asset_code',$asset)->where('business_code',Auth::user()->business_code)->first();

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      return view('app.assets.licenses.view', compact('details','suppliers','edit'));
   }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request,$asset,$code)
     {
        $this->validate($request,[
           'supplier' => 'required',
        ]);

        $maintenance = maintenance::where('business_code',Auth::user()->business_code)
                 ->where('maintenance_code',$code)
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
