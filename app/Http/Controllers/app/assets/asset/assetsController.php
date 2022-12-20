<?php

namespace App\Http\Controllers\app\assets\asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\asset\assets;
use App\Models\finance\customer\customers;
use App\Models\finance\suppliers\suppliers;
use App\Models\asset\maintenance;
use App\Models\asset\car_make;
use App\Models\asset\car_model;
use App\Models\asset\car_type;
use App\Models\asset\events;
use App\Models\hr\employees;
use App\Models\hr\branches;
use App\Models\hr\department;
use App\Models\asset\types;
use App\Models\wingu\file_manager;
use Session;
use Auth;
use Image;
use Wingu;
use Helper;
use File;

class assetsController extends Controller
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
      return view('app.assets.assets.index');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $makes = car_make::pluck('name','id')->prepend('choose make','');

      $carTypes = car_type::pluck('name','id')->prepend('choose car type','');

      return view('app.assets.assets.create', compact('makes','carTypes'));
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
      $asset = new assets;
      $asset->asset_code = $code;
      $asset->category = 'Asset';
      $asset->asset_name = $request->asset_name;
      $asset->asset_type = $request->asset_type;
      $asset->status = $request->status;
      $asset->asset_tag = $request->asset_tag;
      $asset->serial = $request->serial;
      $asset->supplier = $request->supplier;
      $asset->asset_model = $request->asset_model;
      $asset->assigned_to =$request->assigned_to;
      $asset->order_number = $request->order_number;
      $asset->purches_cost = $request->purches_cost;
      $asset->purchase_date = $request->purchase_date;
      $asset->next_inspection_date = $request->next_inspection_date;
      $asset->insurance_expiry_date = $request->insurance_expiry_date;
      $asset->warranty = $request->warranty;
      $asset->warranty_expiration = $request->warranty_expiration;
      $asset->default_location = $request->default_location;
      $asset->requestable = $request->requestable;
      $asset->note = $request->note;
      $asset->brand = $request->brand;
      $asset->has_inurance_cover = $request->has_inurance_cover;
      $asset->last_audit = $request->last_audit;
      $asset->end_of_life = $request->end_of_life;
      $asset->depreciable_assets = $request->depreciable_assets;
      $asset->asset_color = $request->asset_color;
      $asset->link_to_expence = $request->link_to_expence;
      $asset->mileage = $request->mileage;
      $asset->asset_condition = $request->asset_condition;
      $asset->oil_change = $request->oil_change;
      $asset->licence_plate = $request->licence_plate;
      $asset->vehicle_type = $request->vehicle_type;
      $asset->vehicle_make = $request->vehicle_make;
      $asset->vehicle_model = $request->vehicle_model;
      $asset->company_branch = $request->company_branch;
      $asset->maintained = $request->maintained;
      $asset->department = $request->department;
      $asset->manufacture = $request->manufacture;
      $asset->next_maintenance = $request->next_maintenance;
      $asset->vehicle_year_of_manufacture = $request->vehicle_year_of_manufacture;
      $asset->vehicle_color = $request->vehicle_color;
      $asset->longitude = $request->lng;
      $asset->latitude = $request->lat;
      $asset->business_code = Auth::user()->business_code;
      $asset->created_by = Auth::user()->user_code;
      if(!empty($request->asset_image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('asset_image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $asset->asset_image = $fileName;
      }
      $asset->save();

      //store images
      if($request->hasFile('images')){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('images');
         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(16). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            //$file->move($directory, $fileName);

            //resize image
            $resize_image = Image::make($file->getRealPath());
            $resize_image->resize(750, 750, function($constraint){
            $constraint->aspectRatio();
            })->save($directory . '/' . $fileName);

            $upload = new file_manager;
            $upload->file_code     = $code;
            $upload->folder 	     = 'Assets';
            $upload->section 	     = 'Asset';
            $upload->name 		     = $request->asset_name;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->file_mime     = $file->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      Session::flash('success','asset successfully added');

      return redirect()->route('assets.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($code){
      $events = events::join('wp_status','wp_status.id','as_assets_event.status')
                        ->where('business_code',Auth::user()->business_code)
                        ->where('asset_code',$code)
                        ->where('status',38)
                        ->orwhere('status',43)
                        ->orderby('as_assets_event.id','desc')
                        ->get();

      $details  = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $maintenances = maintenance::where('business_code',Auth::user()->business_code)
                                 ->where('asset_code',$code)
                                 ->orderby('id','desc')
                                 ->get();

      $files = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      $branches = branches::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('name','branch_code')->prepend('Chooose branch','');

      $business = Wingu::business();

      $customers = customers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('customer_name','customer_code')->prepend('Chooose customer','');

      return view('app.assets.assets.view', compact('details','maintenances','events','code','files','branches','business','customers'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $makes = car_make::pluck('name','id')->prepend('choose make','');

      $carTypes = car_type::pluck('name','id')->prepend('choose car type','');

      $edit  = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $galleries = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

      return view('app.assets.assets.edit', compact('edit','makes','carTypes','galleries'));
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

      $asset  = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $asset->asset_name = $request->asset_name;
      $asset->asset_type = $request->asset_type;
      $asset->status = $request->status;
      $asset->asset_tag = $request->asset_tag;
      $asset->serial = $request->serial;
      $asset->supplier = $request->supplier;
      $asset->asset_model = $request->asset_model;
      $asset->assigned_to =$request->assigned_to;
      $asset->order_number = $request->order_number;
      $asset->purches_cost = $request->purches_cost;
      $asset->purchase_date = $request->purchase_date;
      $asset->next_inspection_date = $request->next_inspection_date;
      $asset->insurance_expiry_date = $request->insurance_expiry_date;
      $asset->warranty = $request->warranty;
      $asset->warranty_expiration = $request->warranty_expiration;
      $asset->default_location = $request->default_location;
      $asset->requestable = $request->requestable;
      $asset->note = $request->note;
      $asset->brand = $request->brand;
      $asset->has_inurance_cover = $request->has_inurance_cover;
      $asset->last_audit = $request->last_audit;
      $asset->end_of_life = $request->end_of_life;
      $asset->depreciable_assets = $request->depreciable_assets;
      $asset->asset_color = $request->asset_color;
      $asset->link_to_expence = $request->link_to_expence;
      $asset->mileage = $request->mileage;
      $asset->asset_condition = $request->asset_condition;
      $asset->oil_change = $request->oil_change;
      $asset->licence_plate = $request->licence_plate;
      $asset->vehicle_type = $request->vehicle_type;
      $asset->vehicle_make = $request->vehicle_make;
      $asset->vehicle_model = $request->vehicle_model;
      $asset->company_branch = $request->company_branch;
      $asset->maintained = $request->maintained;
      $asset->department = $request->department;
      $asset->manufacture = $request->manufacture;
      $asset->next_maintenance = $request->next_maintenance;
      $asset->vehicle_year_of_manufacture = $request->vehicle_year_of_manufacture;
      $asset->vehicle_color = $request->vehicle_color;
      $asset->longitude = $request->lng;
      $asset->latitude = $request->lat;
      $asset->business_code = Auth::user()->business_code;
      $asset->updated_by = Auth::user()->user_code;

      if(!empty($request->asset_image)){
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = assets::where('asset_code',$code)->where('business_code',Auth::user()->business_code)->first();

         if($check->asset_image){
				$delete = $path.$check->asset_image;
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

      //store images
      if($request->hasFile('images')){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('images');
         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(16). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            //$file->move($directory, $fileName);

            //resize image
            $resize_image = Image::make($file->getRealPath());
            $resize_image->resize(750, 750, function($constraint){
            $constraint->aspectRatio();
            })->save($directory . '/' . $fileName);

            $upload = new file_manager;
            $upload->file_code     = $code;
            $upload->folder 	     = 'Assets';
            $upload->section 	     = 'Asset';
            $upload->name 		     = $request->asset_name;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->file_mime     = $file->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      Session::flash('success','Asset successfully updated');

      return redirect()->back();
   }

   public function retrive_model($id){
      $model = car_model::where('makeID',$id)->get();
      return \Response::json($model);
   }

   //add files
   public function add_file(Request $request, $code){
      //store images
      if($request->hasFile('images')){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('images');
         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(16). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            //$file->move($directory, $fileName);

            if(Helper::like_match('%image%',$file->getClientMimeType())){
               //resize image
               $resize_image = Image::make($file->getRealPath());
               $resize_image->resize(750, 750, function($constraint){
               $constraint->aspectRatio();
               })->save($directory .'/'. $fileName);
            }else{
               $file->move($directory, $fileName);
            }

            $upload = new file_manager;
            $upload->file_code     = $code;
            $upload->folder 	     = 'Assets';
            $upload->section 	     = 'Asset';
            $upload->name 		     = $request->file_name;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->file_mime     = $file->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      Session::flash('success','Asset successfully updated');

      return redirect()->back();
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($id)
   {
      assets::where('id',$id)->where('business_code',Auth::user()->business_code)->delete();
      maintenance::where('business_code',Auth::user()->business_code)->where('assetID',$id)->delete();

      Session::flash('success','license successfully deleted');

      return redirect()->route('assets.index');
   }

   /**
   * Remove image
   *
   * @param  string  $code
   */
   public function remove_image($id){

      $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/assets/';

      $file = file_manager::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      if($file->asset_image){
         $delete = $path.$file->file_name;
         if (File::exists($delete)) {
            unlink($delete);
         }
      }

      $file->delete();

      Session::flash('success','Image successfully deleted');

      return redirect()->back();
   }


   /**
   * store lease
   *
   * @return \Illuminate\Http\Response
   */
   public function lease_store(Request $request,$assetCode)
   {
      $this->validate($request, [
         'action_date' => 'required',
      ]);

      $lease = new events;
      $lease->code            = Helper::generateRandomString(30);
      $lease->asset_code      = $assetCode;
      $lease->status          = 39;
      $lease->action_date     = $request->action_date;
      $lease->due_action_date = $request->due_action_date;
      $lease->customer        = $request->allocated_to;
      $lease->note            = $request->note;
      $lease->created_by      = Auth::user()->user_code;
      $lease->updated_by      = Auth::user()->user_code;
      $lease->business_code   = Auth::user()->business_code;
      $lease->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->customer       = $request->allocated_to;
      $asset->current_status = 39;
      $asset->save();

      Session::flash('success','asset successfully leased out');

      return redirect()->route('assets.leases',$assetCode);
   }


   /**
   * store missing log
   *
   */
   public function missing_asset(Request $request,$assetCode){
      $this->validate($request,[
         'action_date' => 'required'
      ]);

      $event = new events;
      $event->code            = Helper::generateRandomString(30);
      $event->asset_code      = $assetCode;
      $event->site_location = $request->site_location;
      $event->status          = 32;
      $event->action_date     = $request->action_date;
      $event->note            = $request->note;
      $event->created_by      = Auth::user()->user_code;
      $event->updated_by      = Auth::user()->user_code;
      $event->business_code   = Auth::user()->business_code;
      $event->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->current_status = 32;
      $asset->save();

      Session::flash('success','asset recorded successfully');

      return redirect()->route('assets.other.events.missing',$assetCode);
   }

   /**
   * store dispose log
   *
   */
   public function dispose_asset(Request $request,$asset){
      $this->validate($request,[
         'action_date' => 'required'
      ]);

      $event = new events;
      $event->code            = Helper::generateRandomString(30);
      $event->asset_code      = $assetCode;
      $event->status          = 40;
      $event->action_to       = $request->action_to;
      $event->action_date     = $request->action_date;
      $event->note            = $request->note;
      $event->created_by      = Auth::user()->user_code;
      $event->updated_by      = Auth::user()->user_code;
      $event->business_code   = Auth::user()->business_code;
      $event->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->current_status = 40;
      $asset->save();

      Session::flash('success','asset log recorded successfully');

      return redirect()->route('assets.other.events.dispose',$assetCode);
   }

   /**
   * store donate log
   *
   */
   public function donate_asset(Request $request,$assetCode){
      $this->validate($request,[
         'action_date' => 'required'
      ]);

      $event = new events;
      $event->code            = Helper::generateRandomString(30);
      $event->asset_code      = $assetCode;
      $event->status          = 41;
      $event->action_to       = $request->action_to;
      $event->action_date     = $request->action_date;
      $event->note            = $request->note;
      $event->cost            = $request->cost;
      $event->deductible      = $request->deductible;
      $event->created_by      = Auth::user()->user_code;
      $event->updated_by      = Auth::user()->user_code;
      $event->business_code   = Auth::user()->business_code;
      $event->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->current_status = 41;
      $asset->save();

      Session::flash('success','asset log recorded successfully');

      return redirect()->route('assets.other.events.donate',$assetCode);
   }

   /**
   * store sell log
   *
   */
   public function sell_asset(Request $request,$assetCode){
      $this->validate($request,[
         'action_date' => 'required'
      ]);

      $event = new events;
      $event->code            = Helper::generateRandomString(30);
      $event->asset_code      = $assetCode;
      $event->status          = 42;
      $event->action_to       = $request->action_to;
      $event->action_date     = $request->action_date;
      $event->note            = $request->note;
      $event->cost            = $request->cost;
      $event->created_by      = Auth::user()->user_code;
      $event->updated_by      = Auth::user()->user_code;
      $event->business_code   = Auth::user()->business_code;
      $event->save();

      $asset = assets::where('business_code',Auth::user()->business_code)->where('asset_code',$assetCode)->first();
      $asset->current_status = 42;
      $asset->save();

      Session::flash('success','asset log recorded successfully');

      return redirect()->route('assets.other.events.sell',$assetCode);
   }
}
