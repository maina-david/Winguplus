<?php
namespace App\Http\Controllers\app\propertywingu\property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\type;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\wingu\country;
use App\Models\wingu\documents;
use App\Models\property\lease;
use App\Models\property\listings;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\property\tenants\tenants;
use App\Models\property\invoice\invoice_settings;
use Auth;
use Session;
use Wingu;
use Helper;
use File;
use Propertywingu;

class propertyController extends Controller
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
      $properties = property::whereNull('parent')
                            ->where('business_code', Auth::user()->business_code)
                            ->orderby('id','Desc')
                            ->get();

      return view('app.propertywingu.property.index', compact('properties'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $landlords = customers::join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->whereNull('category')
                           ->select('*','fn_customers.created_at as date_added')
                           ->OrderBy('fn_customers.id','DESC')
                           ->get();
      $country = country::pluck('name','name')->prepend('Choose county','');
      $types = type::where('status',15)->get();

      return view('app.propertywingu.property.create', compact('landlords','country','types'));
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
         'title' => 'required',
         'street_address' => 'required',
         'city' => 'required',
         'state' => 'required',
         'country' => 'required',
      ]);

      $code = Helper::generateRandomString(30);

      $property = new property;
      $property->business_code            = Auth::user()->business_code;
      $property->title                    = $request->title;
      $property->serial                   = Helper::generateRandomString(30);
      $property->property_code            = $code;
      $property->landlord                 = $request->landlord;
      $property->year_built               = $request->year_built;
      $property->property_type            = $request->property_type;
      $property->city                     = $request->city;
      $property->street_address           = $request->street_address;
      $property->state                    = $request->state;
      $property->zip_code                 = $request->zip_code;
      $property->country                  = $request->country;
      $property->bedrooms                 = $request->bedrooms;
      $property->bathrooms                = $request->bathrooms;
      $property->size                     = $request->size;
      $property->geolocation              = $request->geolocation;
      $property->latitude                 = $request->lat;
      $property->longitude                = $request->lng;
      $property->price                    = $request->price;
      $property->land_size                = $request->land_size;
      $property->parking_size             = $request->parking_size;
      $property->management_name          = $request->management_name;
      $property->management_email         = $request->management_email;
      $property->management_phonenumber   = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;

      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 1);
      }

      if($request->amenities != ""){
         $amenities = $request->amenities;
         $amenimpload = implode(", ", $amenities);

         $property->amenities = substr($amenimpload, 1);
      }

      $property->smoking     = $request->smoking;
      $property->laundry     = $request->laundry;
      $property->furnished   = $request->furnished;
      $property->description = $request->description;
      $property->status      = $request->status;
      $property->created_by  = Auth::user()->user_code;
      if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/property/'.$code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $property->image = $fileName;
      }

      $property->save();

      //check if property has settings
      $check = invoice_settings::where('property',$code)->where('business_code',Auth::user()->business_code)->count();
      if($check != 1){
         Propertywingu::make_invoice_settings($code);
		}

      Session::flash('success','Property added successfully');

      return redirect()->route('property.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function show($code)
   {
      $year = date('Y');
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $business = business::where('business_code',Auth::user()->business_code)->first();

      $outstandingInvoices = invoices::where('property',$code)->where('business_code',Auth::user()->business_code)->where('invoice_type','Rent')->sum('balance');
      $outstandingUtility= invoices::where('property',$code)->where('business_code',Auth::user()->business_code)->where('invoice_type','Utility')->sum('balance');
      $payed = invoices::where('property',$code)
                        ->whereYear('invoice_date', '=', $year)
                        ->where('business_code',Auth::user()->business_code)
                        ->where('invoice_type','Rent')
                        ->sum('balance');

      $tenants = lease::where('business_code',Auth::user()->business_code)
                        ->where('property',$code)
                        ->where('status',15)
                        ->groupby('tenant')
                        ->get();

      $activeLease = lease::where('business_code',Auth::user()->business_code)
                        ->where('property',$code)
                        ->where('status',15)
                        ->count();

      $vacant = property::where('business_code',Auth::user()->business_code)->whereNull('tenant')->where('parent',$code)->count();

      $occupied = property::where('business_code',Auth::user()->business_code)->where('tenant','!=',"")->where('parent',$code)->count();

      $owner = property::where('business_code',Auth::user()->business_code)
                        ->where('landlord','!=',"")
                        ->where('parent',$code)
                        ->groupby('landlord')
                        ->get();

      $units = property::where('business_code',Auth::user()->business_code)->where('parent',$code)->count();

      return view('app.propertywingu.property.details', compact('property','outstandingInvoices','business','outstandingUtility','payed','units','tenants','owner','vacant','occupied','activeLease','code'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
      $landlords = customers::where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
      $tenants = tenants::where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
      $country = country::pluck('name','name')->prepend('Choose county','');
      $type = type::pluck('name','id')->prepend('Choose type','');
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();

      return view('app.propertywingu.property.edit', compact('landlords','tenants','country','type','property','code'));
   }

   /**
   * Display all vacant units
   *
   */
   public function vacant($id)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->business_code)
                           ->where('business_code',Auth::user()->code)
                           ->first();

      $property = property::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $units = property::where('business_code',Auth::user()->business_code)
                     ->where('parentID',$id)
                     ->whereNull('tenantID')
                     ->orderby('property.id','desc')
                     ->select('*', 'property.id as propID','property.property_type as typeID')
                     ->get();
      $count = 1;
      $propertyID = $id;

      return view('app.propertywingu.property.units.vacant', compact('property','units','count','business','propertyID'));
   }

   /**
   * Display all occupied units
   *
   */
   public function occupied($id)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->business_code)
                           ->where('business_code',Auth::user()->code)
                           ->first();

      $property = property::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $units = property::join('property_tenants','property_tenants.id','=','property.tenantID')
               ->join('property_lease','property_lease.id','=','property.leaseID')
               ->where('property.business_code',Auth::user()->business_code)
               ->where('property.parentID',$id)
               ->where('property.tenantID','!=', '')
               ->orderby('property.id','desc')
               ->select('*', 'property.id as propID')
               ->get();
      $count = 1;
      $propertyID = $id;

      return view('app.propertywingu.property.units.occupied', compact('property','units','count','business','propertyID'));
   }

   /**
   * Display all occupied units
   *
   */
   public function tenants($code){

      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();

      $tenants = property::join('property_tenants','property_tenants.tenant_code','=','property.tenant')
                  ->join('property_lease','property_lease.unit','=','property.property_code')
                  ->where('property.parent',$code)
                  ->whereNull('property_lease.status')
                  ->orderby('property_tenants.id','desc')
                  ->get();

      return view('app.propertywingu.property.tenants.index', compact('property','tenants','code'));
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
         'property_type' => 'required',
         'title' => 'required',
         'street_address' => 'required',
         'city' => 'required',
         'state' => 'required',
         'country' => 'required',
      ]);

      $property = property::where('property_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $property->title = $request->title;
      $property->landlord = $request->landlord;
      $property->year_built = $request->year_built;
      $property->property_type = $request->property_type;
      $property->city = $request->city;
      $property->street_address = $request->street_address;
      $property->state = $request->state;
      $property->zip_code = $request->zip_code;
      $property->country = $request->country;
      $property->bedrooms = $request->bedrooms;
      $property->bathrooms = $request->bathrooms;
      $property->size = $request->size;
      $property->geolocation = $request->geolocation;
      $property->latitude = $request->lat;
      $property->longitude = $request->lng;
      $property->land_size = $request->land_size;
      $property->parking_size = $request->parking_size;
      $property->price = $request->price;
      $property->management_name = $request->management_name;
      $property->management_email = $request->management_email;
      $property->management_phonenumber = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;

      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 0);
      }

      if($request->amenities != ""){
            $amenities = $request->amenities;
            $amenimpload = implode(", ", $amenities);

            $property->amenities = substr($amenimpload, 0);
      }

      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->status = $request->status;
      $property->business_code = Auth::user()->business_code;
      $property->updated_by = Auth::user()->user_code;

      if(!empty($request->image)){
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/property/'.$property->property_code.'/';

         if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = property::where('id','=',$id)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();

         if ($check > 0){
            $oldimagename = property::where('id','=',$id)->where('business_code',Auth::user()->business_code)->select('image')->first();
            $delete = $path.$oldimagename->image;
            if (File::exists($delete)) {
               unlink($delete);
            }
         }

         $file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $property->image = $fileName;
      }

      $property->save();

      Session::flash('success','Property updated successfully');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function information($id)
   {
      $property = property::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      return view('app.propertywingu.property.information', compact('property'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update_information(Request $request, $id)
   {
      $this->validate($request, [
            'management_name' => 'required',
            'management_email' => 'required',
            'management_phonenumber' => 'required',
            'management_postaladdress' => 'required',
      ]);

      $property = property::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $property->business_code = Auth::user()->business_code;
      $property->userID = Auth::user()->user_code;
      $property->management_name = $request->management_name;
      $property->management_email = $request->management_email;
      $property->management_phonenumber = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;
      $property->bank_name = $request->bank_name;
      $property->bank_branch = $request->bank_branch;
      $property->bank_account_number = $request->bank_account_number;
      $property->bank_account_name = $request->bank_account_name;
      $property->paybill_number = $request->paybill_number;
      $property->paybill_name = $request->paybill_name;
      $property->invoice_number = $request->invoice_number;
      $property->invoice_prefix = $request->invoice_prefix;
      $property->credit_note_number = $request->credit_note_number;
      $property->credit_note_prefix = $request->credit_note_prefix;
      $property->save();

      Session::flash('success','Information successfully updated');

      return redirect()->back();
   }

   //remove property image
   public function remove_image($id){
      $property = property::where('id','=',$id)->where('business_code',Auth::user()->business_code)->first();
      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/property/'.$property->property_code.'/';

      //delete image from folder
      $oldimagename = property::where('id','=',$id)->where('business_code',Auth::user()->business_code)->select('image')->first();
      $delete = $path.$oldimagename->image;
      if (File::exists($delete)) {
         unlink($delete);
      }

      //update image
      $property ->image = NULL;
      $property->save();

      Session::flash('success','Image successfully removed');

      return redirect()->back();
   }

   /**
    * Delete Property
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function delete($code){
      //check if property is listed
      $checkListing = listings::where('property',$code)->where('business_code',Auth::user()->business_code)->count();

      //check if has leases
      $checkLease = lease::where('property',$code)->where('business_code',Auth::user()->business_code)->count();

      if($checkListing == 0 && $checkLease == 0){
         $property = property::where('property_code',$code)->where('business_code',Auth::user()->business_code)->first();
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/property/'.$property->property_code.'/';

         //delete image from folder
         $oldimagename = property::where('property_code','=',$code)->where('business_code',Auth::user()->business_code)->select('image')->first();
         $delete = $path.$oldimagename->image;
         if (File::exists($delete)) {
            unlink($delete);
         }

         //update image
         $property->delete();

         Session::flash('success','Property successfully deleted');

         return redirect()->route('property.index');
      }

      Session::flash('warning','Make sure their no Leases linked to the property and the property is not listed in the marketing section');

      return redirect()->back();
   }

}
