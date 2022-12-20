<?php

namespace App\Http\Controllers\app\assets\license;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\asset\assets;
use App\Models\finance\suppliers\suppliers;
use App\Models\asset\maintenance;
use App\Models\finance\customer\customers;
use App\Models\hr\employees;
use Session;
use Auth;
use Wingu;
use File;
use Helper;

class licensesController extends Controller
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
      $assets = assets::where('business_code',Auth::user()->business_code)->where('category','Licenses')->get();

      return view('app.assets.licenses.index', compact('assets'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $customers = customers::where('business_code',Auth::user()->business_code)->pluck('customer_name','customer_code')->prepend('choose supplier','');

      $employees = employees::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('names','employee_code')
                           ->prepend('choose employee','');

      return view('app.assets.licenses.create', compact('suppliers','customers','employees'));
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
         'asset_name' => 'required',
      ]);

      $code = Helper::generateRandomString(30);
      $asset                    = new assets;
      $asset->asset_code        = $code;
      $asset->category          = 'Licenses';
      $asset->asset_name        = $request->asset_name;
      $asset->asset_type        = $request->asset_type;
      $asset->asset_image       = $request->asset_image;
      $asset->product_key       = $request->product_key;
      $asset->seats             = $request->seats;
      $asset->status            = $request->status;
      $asset->manufacture       = $request->manufacture;
      $asset->licensed_to_name  = $request->licensed_to_name;
      $asset->licensed_to_email = $request->licensed_to_email;
      $asset->reassignable      = $request->reassignable;
      $asset->supplier          = $request->supplier;
      $asset->assigned_to       = $request->assigned_to;
      $asset->employee          = $request->employee;
      $asset->customer          = $request->customer;
      $asset->order_number      = $request->order_number;
      $asset->purches_cost      = $request->purches_cost;
      $asset->purchase_date     = $request->purchase_date;
      $asset->end_of_life       = $request->end_of_life;
      $asset->maintained        = $request->maintained;
      $asset->next_maintenance  = $request->next_maintenance;
      $asset->note              = $request->note;
      $asset->business_code     = Auth::user()->business_code;
      $asset->created_by        = Auth::user()->user_code;
      $asset->updated_by        = Auth::user()->user_code;

      if(!empty($request->asset_image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('asset_image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $asset->asset_image = $fileName;
      }

      $asset->save();

      Session::flash('success','Licenses successfully added');

      return redirect()->route('licenses.assets.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($code)
   {
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
   public function edit($code)
   {
      $edit  = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $customers = customers::where('business_code',Auth::user()->business_code)->pluck('customer_name','customer_code')->prepend('choose supplier','');

      $employees = employees::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('names','employee_code')
                           ->prepend('choose employee','');

      return view('app.assets.licenses.edit', compact('edit','suppliers','employees','customers'));
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
         'asset_name' => 'required',
      ]);

      $asset = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $asset->asset_name = $request->asset_name;
      $asset->asset_type = $request->asset_type;
      $asset->product_key = $request->product_key;
      $asset->status = $request->status;
      $asset->seats = $request->seats;
      $asset->manufacture = $request->manufacture;
      $asset->licensed_to_name = $request->licensed_to_name;
      $asset->licensed_to_email = $request->licensed_to_email;
      $asset->reassignable = $request->reassignable;
      $asset->supplier = $request->supplier;
      $asset->assigned_to = $request->assigned_to;
      $asset->employee = $request->employee;
      $asset->order_number = $request->order_number;
      $asset->purches_cost = $request->purches_cost;
      $asset->purchase_date = $request->purchase_date;
      $asset->end_of_life = $request->end_of_life;
      $asset->next_maintenance = $request->next_maintenance;
      $asset->maintained = $request->maintained;
      $asset->note = $request->note;
      $asset->business_code = Auth::user()->business_code;
      $asset->updated_by = Auth::user()->user_code;
      if(!empty($request->asset_image)){
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = assets::where('id','=',$id)->where('business_code',Auth::user()->business_code)->where('asset_image','!=', "")->count();

         if($check > 0){
				$oldimagename = assets::where('id','=',$id)->where('business_code',Auth::user()->business_code)->select('asset_image')->first();
				$delete = $path.$oldimagename->asset_image;
				if (File::exists($delete)) {
					unlink($delete);
				}
         }

         $file = $request->file('asset_image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $asset->asset_image = $fileName;
      }
      $asset->save();

      Session::flash('success','Licenses successfully updated');

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
      assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->delete();
      maintenance::where('business_code',Auth::user()->business_code)->where('asset_code',$code)->delete();

      Session::flash('success','license successfully deleted');

      return redirect()->back();

   }
}
