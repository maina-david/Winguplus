<?php
namespace App\Http\Controllers\app\hr\travel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\hr\employees;
use App\Models\hr\department;
use App\Models\hr\travel;
use App\Models\hr\travel_employee;
use App\Models\hr\travel_departments;
use Session;
use Auth;
use Helper;
class travelController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Travel lsit requests
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){

      $travels = travel::join('fn_customers','fn_customers.customer_code','=','hr_travels.customer_code')
                        ->join('wp_status','wp_status.id','=','hr_travels.status')
                        ->where('hr_travels.business_code',Auth::user()->business_code)
                        ->select('*','wp_status.name as statusName','travel_code')
                        ->orderby('hr_travels.id','desc')
                        ->get();
      $count = 1;

      return view('app.hr.travel.index', compact('travels','count'));
   }

    /**
   * Travel lsit requests
   *
   * @return \Illuminate\Http\Response
   */
  public function my_travels(){

   $travels = travel::join('hr_employees','hr_employees.id','=','hr_travels.employeeID')
                     ->join('hr_departments','hr_departments.id','=','hr_travels.departmentID')
                     ->join('customers','customers.id','=','hr_travels.customerID')
                     ->join('status','status.id','=','hr_travels.status')
                     ->where('hr_travels.business_code',Auth::user()->business_code)
                     ->where('hr_travels.employeeID',Auth::user()->employeeID)
                     ->select('*','hr_travels.id as travel_code','hr_departments.title as department','status.name as statusName')
                     ->orderby('hr_travels.id','desc')
                     ->get();
   $count = 1;

   return view('app.hr.travel.mytravels', compact('travels','count'));
}

   /**
   * Create travel
   */
   public function create(){
      $employees = employees::where('business_code',Auth::user()->business_code)
                           ->where('status',25)
                           ->orderby('id','desc')
                           ->pluck('names','employee_code');

      $customers = customers::where('business_code',Auth::user()->business_code)
                              ->orderby('id','desc')
                              ->pluck('customer_name','customer_code');

      $departments = department::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('title','department_code');

      return view('app.hr.travel.create', compact('employees','customers','departments'));
   }

   /**
   * store travel
   */
   public function store(Request $request){
      $this->validate($request, [
         'employee' => 'required',
         'place_of_visit' => 'required',
         'date_of_arrival' => 'required',
         'departure_date' => 'required',
         'purpose_of_visit' => 'required',
         'customer' => 'required',
         'bill_customer' => 'required',
         'duration' => 'required'
      ]);

      $travel = new travel;
      $code = Helper::generateRandomString(30);
      $travel->travel_code       = $code;
      $travel->place_of_visit    = $request->place_of_visit;
      $travel->date_of_arrival   = $request->date_of_arrival;
      $travel->departure_date    = $request->departure_date;
      $travel->duration          = $request->duration;
      $travel->purpose_of_visit  = $request->purpose_of_visit;
      $travel->customer_code     = $request->customer;
      $travel->bill_customer     = $request->bill_customer;
      $travel->status            =  7;
      $travel->business_code     = Auth::user()->business_code;
      $travel->created_by        = Auth::user()->user_code;
      $travel->save();

      $employees = count(collect($request->employee));
      if($employees > 0){
         //upload new category
         for($i=0; $i < count($request->employee); $i++ ) {
            $rep = new travel_employee;
            $rep->travel_code   = $code;
            $rep->employee_code = $request->employee[$i];
            $rep->business_code = Auth::user()->business_code;
            $rep->save();
         }
      }

      //department
      $department = count(collect($request->department));
      if($department > 0){
         //upload new category
         for($i=0; $i < count($request->department); $i++ ) {
            $depart = new travel_departments;
            $depart->travel_code     = $code;
            $depart->department_code = $request->department[$i];
            $depart->business_code   = Auth::user()->business_code;
            $depart->save();
         }
      }

      Session::flash('success','Travel request added');

      return redirect()->route('hrm.travel.index');
   }


   /**
   * Edit travel
   */
   public function edit($code){
      $customers = customers::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('customer_name','customer_code')
                           ->prepend('Choose customer','');

      $travel = travel::join('fn_customers','fn_customers.customer_code','=','hr_travels.customer_code')
                        ->where('travel_code',$code)
                        ->where('hr_travels.business_code',Auth::user()->business_code)
                        ->select('*','hr_travels.customer_code as customer')
                        ->first();

      //departments
      $getDepartments = department::where('business_code',Auth::user()->business_code)
                                ->orderby('id','desc')
                                ->select('title','department_code')
                                ->get();

      $departments = array();
      foreach($getDepartments as $depart) {
         $departments[$depart->department_code] = $depart->title;
      }

      //join travel departments
      $getDepartmentJoint = travel_departments::join('hr_departments','hr_departments.department_code','=','hr_travel_departments.department_code')
                                             ->where('travel_code',$code)
                                             ->select('hr_travel_departments.department_code')
                                             ->get();

      $joinDepartments = array();
      foreach($getDepartmentJoint as $departJoin){
         $joinDepartments[] = $departJoin->department_code;
      }

      //Employees
      $employees = employees::where('business_code',Auth::user()->business_code)
                              ->where('status',25)
                              ->orderby('id','desc')
                              ->pluck('names','employee_code');

      //join travel employee
      $getjoint = travel_employee::join('hr_employees','hr_employees.employee_code','=','hr_travel_employees.employee_code')
                                 ->where('travel_code',$code)
                                 ->select('hr_travel_employees.employee_code')
                                 ->get();
      $joinEmployees = array();
      foreach($getjoint as $gj){
         $joinEmployees[] = $gj->employee_code;
      }

      return view('app.hr.travel.edit', compact('employees','customers','travel','departments','joinDepartments','employees','joinEmployees'));
   }

   /**
   * Update travel
   */
   public function update(Request $request, $code){
      $this->validate($request, [
         'employee' => 'required',
         'place_of_visit' => 'required',
         'date_of_arrival' => 'required',
         'departure_date' => 'required',
         'purpose_of_visit' => 'required',
         'customer' => 'required',
         'bill_customer' => 'required',
         'duration' => 'required'
      ]);

      $travel = travel::where('business_code',Auth::user()->business_code)->where('travel_code',$code)->first();
      $travel->place_of_visit = $request->place_of_visit;
      $travel->date_of_arrival = $request->date_of_arrival;
      $travel->departure_date = $request->departure_date;
      $travel->duration = $request->duration;
      $travel->purpose_of_visit = $request->purpose_of_visit;
      $travel->customer_code = $request->customer;
      $travel->bill_customer = $request->bill_customer;
      $travel->business_code = Auth::user()->business_code;
      $travel->updated_by = Auth::user()->user_code;
      $travel->save();

      $employees = count(collect($request->employee));
      if($employees > 0){
         travel_employee::where('travel_code',$code)->delete();
         //upload new category
         for($i=0; $i < count($request->employee); $i++ ) {
            $rep = new travel_employee;
            $rep->travel_code = $code;
            $rep->employee_code = $request->employee[$i];
            $rep->business_code = Auth::user()->business_code;
            $rep->save();
         }
      }

      //department
      $department = count(collect($request->department));
      if($department > 0){
         travel_departments::where('travel_code',$code)->delete();
         //upload new category
         for($i=0; $i < count($request->department); $i++ ) {
            $depart = new travel_departments;
            $depart->travel_code = $code;
            $depart->department_code = $request->department[$i];
            $depart->business_code = Auth::user()->business_code;
            $depart->save();
         }
      }

      Session::flash('success','Travel request updated');

      return redirect()->back();
   }

   /**
   * delete travel
   */
   public function delete($code){
      //check and see if the the travel linked to an expense
      travel::where('business_code',Auth::user()->business_code)->where('travel_code',$code)->delete();

      Session::flash('success','Travel successfully deleted');

      return redirect()->route('hrm.travel.index');
   }
}
