<?php

namespace App\Http\Controllers\app\propertywingu\property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\finance\customer\customers as landlords;
use App\Models\property\tenants\tenants;
use App\Models\property\type;
use App\Models\property\lease;
use Auth;
use Session;
use Helper;
class unitsController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($code)
   {
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $units = property::where('business_code',Auth::user()->business_code)
               ->where('parent',$code)
               ->orderby('property.id','desc')
               ->select('*', 'property.id as propID')
               ->get();
      return view('app.propertywingu.property.units.index', compact('property','units','code'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($code)
   {
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $landlords = landlords::where('business_code',Auth::user()->business_code)
                     ->where('is_landlord','Yes')
							->select('*','fn_customers.created_at as date_added')
							->OrderBy('fn_customers.customer_code','DESC')
							->get();
      $tenants = tenants::where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
      $type = type::pluck('name','code')->prepend('choose property type');

      return view('app.propertywingu.property.units.create', compact('property','landlords','tenants','type','code'));
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
         'property_type' => 'required',
         'parent_code'   => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('business_code',Auth::user()->business_code)->where('property_code',$request->parent_code)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $property = new property;
      $property->business_code   = Auth::user()->business_code;
      $property->created_by      = Auth::user()->user_code;
      $property->property_code   = Helper::generateRandomString(30);
      $property->parent          = $request->parent_code;
      $property->serial          = $request->serial;
      $property->property_type   = $request->property_type;
      $property->ownwership_type = $request->ownwership_type;
      $property->landlord        = $request->landlord;
      $property->year_built      = $request->year_built;
      $property->bedrooms        = $request->bedrooms;
      $property->bathrooms       = $request->bathrooms;
      $property->size            = $request->size;
      $property->price           = $request->price;
      if($request->features != ""){
         $features = $request->features;
         $featImplode = implode(", ", $features);
         $property->features = substr($featImplode, 0);
      }
      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->save();

      Session::flash('success','The unit have been successfully added');

      return redirect()->route('propertywingu.property.units',$request->parent_code);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function bulk($code)
   {
      //check if user is linked to a business and allow access
      $check = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->count();
      if($check == 1 ){

         $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
         $landlords = landlords::where('is_landlord','Yes')->where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
         $tenants = tenants::where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
         $type = type::pluck('name','code')->prepend('choose unite type');

         return view('app.propertywingu.property.units.bulk', compact('property','landlords','tenants','type','code'));

      }else{
         return view('errors.403');
      }
   }


   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store_bulk(Request $request)
   {
      $this->validate($request, [
         'total_units' => 'required',
         'parentID' => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('business_code',Auth::user()->business_code)->where('id',$request->parentID)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $range = $request->total_units;
      $start = 1;

      for ($i = $start; $i <= $range; $i++) {
         $property = new property;
         $property->business_code = Auth::user()->business_code;
         $property->updated_by = Auth::user()->user_code;
         $property->parent = $request->parentID;
         if($request->prefix != ""){
            $property->serial = $request->prefix.$i;
         }else{
            $property->serial = Helper::generateRandomString(9);
         }
         $property->landlordID = $request->landlord;
         $property->property_type = $request->property_type;
         $property->year_built = $request->year_built;
         $property->bedrooms   = $request->bedrooms;
         $property->bathrooms  = $request->bathrooms;
         $property->ownwership_type = $request->ownwership_type;
         $property->size = $request->size;
         $property->price = $request->price;
         if($request->features != ""){
            $features = $request->features;
            $featimpload = implode(", ", $features);
            $property->features = substr($featimpload, 0);
         }
         $property->smoking = $request->smoking;
         $property->laundry = $request->laundry;
         $property->furnished = $request->furnished;
         $property->description = $request->description;
         $property->save();
      }

      Session::flash('success','The '.$range.' units have been successfully added');

      return redirect()->route('property.units',$request->parentID);
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
   public function edit($code,$unit_code)
   {
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $landlords = landlords::where('business_code',Auth::user()->business_code)->orderby('id','Desc')
                              ->select('customer_code','fn_customers.customer_name as landlord')
                              ->where('is_landlord','Yes')
                              ->pluck('landlord','landlord')
                              ->prepend('choose landlord','');

      $unit = property::where('business_code',Auth::user()->business_code)->where('property_code',$unit_code)->first();

      $type = type::pluck('name','id')->prepend('choose unite type');

      return view('app.propertywingu.property.units.edit', compact('property','landlords','unit','type','code'));
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
         'parent_code' => 'required',
         'serial'      => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $property->business_code   = Auth::user()->business_code;
      $property->updated_by      = Auth::user()->user_code;
      $property->parent          = $request->parent;
      $property->serial          = $request->serial;
      $property->property_type   = $request->property_type;
      $property->landlord        = $request->landlord;
      $property->year_built      = $request->year_built;
      $property->bedrooms        = $request->bedrooms;
      $property->ownwership_type = $request->ownwership_type;
      $property->bathrooms       = $request->bathrooms;
      $property->size            = $request->size;
      $property->price           = $request->price;
      if($request->features != ""){
         $features               = $request->features;
         $featImplode            = implode(", ", $features);
         $property->features     = substr($featImplode, 0);
      }
      $property->smoking         = $request->smoking;
      $property->laundry         = $request->laundry;
      $property->furnished       = $request->furnished;
      $property->description     = $request->description;
      $property->save();

      Session::flash('success','The unit has been successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($pid,$uid)
   {
      //check if unit is linked to a lease
      $check = lease::where('unit',$uid)->where('property',$pid)->where('business_code',Auth::user()->business_code)->count();

      if($check != 0){
         Session::flash('warning','This unit is linked to a lease and you can not delete it');

         return redirect()->route('propertywingu.property.units',$pid);
      }

      property::where('business_code',Auth::user()->business_code)->where('parent',$pid)->where('property_code',$uid)->delete();

      Session::flash('success','Unit successfully deleted');

      return redirect()->route('property.units',$pid);
   }
}
