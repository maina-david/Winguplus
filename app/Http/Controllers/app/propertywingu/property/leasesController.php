<?php
namespace App\Http\Controllers\app\propertywingu\property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\property\utilities;
use App\Models\property\listings;
use App\Models\property\lease_utility;
use App\Models\finance\tax;
use Helper;
use Auth;
use Session;
use Response;
class leasesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index($code){
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $leases = lease::join('property_tenants','property_tenants.tenant_code','=','property_lease.tenant')
                     ->join('property','property.property_code','=','property_lease.property')
                     ->where('property_lease.property',$code)
                     ->where('property_lease.business_code',Auth::user()->business_code)
                     ->select('property.property_code as property_code','property_lease.lease_code as leaseCode','property_tenants.tenant_code as tenantCode','property_lease.lease_code as code','property_lease.lease_type as type','property_tenants.tenant_name as tenant_name','next_invoice','last_invoiced','billing_schedule','lease_end_date','lease_start_date','property_lease.status as status','property_lease.unit as unit')
                     ->orderby('property_lease.id','desc')
                     ->get();

      return view('app.propertywingu.property.show', compact('property','leases','code'));
   }

   public function create($code){
      $property = property::where('business_code',Auth::user()->business_code)->where('property_code',$code)->first();
      $units = property::where('business_code',Auth::user()->business_code)
               ->where('parent',$code)
               ->whereNull('tenant')
               ->orderby('property.id','desc')
               ->pluck('serial','property_code')
               ->prepend('Choose unit','');
      $tenants = tenants::where('business_code',Auth::user()->business_code)->orderby('id','Desc')->get();
      $utilities = utilities::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $taxes = tax::where('business_code',Auth::user()->business_code)->get();

      return view('app.propertywingu.property.lease.create', compact('property','units','tenants','utilities','taxes','code'));
   }

   public function store(Request $request){
      $this->validate($request, [
         'property_code' => 'required',
         'unitID' => 'required',
         'lease_type' => 'required',
         'lease_start_date' => 'required',
         'tenant' => 'required',
         'rent_amount' => 'required',
         'billing_schedule' => 'required',
         'first_invoice_date' => 'required',
         'due_day' => 'required',
      ]);

      $lease = new lease();
      $lease->property_code = $request->property_code;
      $lease->unitID = $request->unitID;
      $lease->lease_code = Helper::generateRandomString(10);
      $lease->lease_type = $request->lease_type;
      $lease->lease_start_date = $request->lease_start_date;
      $lease->lease_end_date = $request->lease_end_date;
      $lease->tenantID = $request->tenant;
      $lease->deposit = $request->deposit;
      $lease->tax_rate = $request->tax_rate;
      $lease->rent_amount = $request->rent_amount;
      $lease->billing_schedule = $request->billing_schedule;
      $lease->first_invoice_date = $request->first_invoice_date;
      $lease->due_day = $request->due_day;
      $lease->escalation_rate = $request->escalation_rate;
      $lease->escalation_period = $request->escalation_period;
      $lease->service_charge = $request->service_charge;
      $lease->define_service_charge = $request->define_service_charge;
      $lease->parking_price = $request->parking_price;
      $lease->parking_spaces = $request->parking_spaces;
      $lease->include_utility = $request->include_utility;
      $lease->agreement = $request->agreement;
      $lease->statusID = 15;
      $lease->created_by = Auth::user()->id;
      $lease->business_code = Auth::user()->business_code;
      if($request->escalating_items != ""){
         $items = $request->escalating_items;
         $Itemimpload = implode(", ", $items);
         $lease->escalating_items = substr($Itemimpload,0);
      }
      $lease->save();

      //update property
      $property = property::where('business_code',Auth::user()->business_code)->where('id',$request->unitID)->first();
      $property->tenantID = $request->tenant;
      $property->leaseID = $lease->id;
      $property->status = 48;
      $property->listing_status = NULL;
      $property->save();

      //add utility
      if($request->include_utility == 'Yes'){
         $utility = count(collect($request->utilityID));
         if($utility > 0){
            if(isset($_POST['utilityID'])){
               for($i=0; $i < count($request->utilityID); $i++ ) {
                  $util = new lease_utility;
                  $util->business_code	 = Auth::user()->business_code;
                  $util->created_by = Auth::user()->id;
                  $util->leaseID = $lease->id;
                  $util->utilityID = $request->utilityID[$i];
                  $util->utility_No = $request->utility_No[$i];
                  $util->last_reading = $request->current_reading[$i];
                  $util->initial_price = $request->current_price[$i];
                  $util->save();
               }
            }
         }
      }

      //check if property is listed
      $checkListing = listings::where('property_code',$request->unitID)->where('business_code',Auth::user()->business_code)->where('status',15)->count();
      if($checkListing != 0){
         $unlist = listings::where('property_code',$request->unitID)->where('business_code',Auth::user()->business_code)->where('status',15)->first();
         $unlist->status = 48;
         $unlist->end_date = date('Y-m-d');
         $unlist->updated_by = Auth::user()->id;
         $unlist->save();
      }

      Session::flash('success', 'Lease successfully added');

      return redirect()->route('property.leases',$request->property_code);
   }

}
