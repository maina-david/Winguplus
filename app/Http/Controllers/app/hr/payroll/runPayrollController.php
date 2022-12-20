<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\payroll;
use App\Models\hr\payroll_allocations;
use App\Models\hr\payroll_people;
use App\Models\hr\payroll_items;
use App\Models\hr\department;
use App\Models\hr\branches;
use Helper;
use Auth;
use Session;
use Wingu;
class runPayrollController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * payrolls
   **/
   public function index(){
      $payrolls = payroll::join('wp_business','wp_business.business_code','=','hr_payroll.business_code')
                        ->where('hr_payroll.business_code',Auth::user()->business_code)
                        ->select('payroll_code','payroll_date','total_net_pay','total_gross_pay','total_deductions','currency','branch_code')
                        ->orderby('hr_payroll.id','desc')
                        ->get();
      $count = 1;
      return view('app.hr.payroll.payroll.index', compact('payrolls','count'));
   }

   /**
   * Payroll process
   **/
   public function create(){
      $branches = branches::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.hr.payroll.payroll.create', compact('branches'));
   }

   /**
   * submit Payroll process
   **/
   public function run(Request $request){
      $this->validate($request,[
         'branch' => 'required',
         'payroll_date' => 'required',
      ]);

      $checkPayroll = payroll::where('business_code',Auth::user()->business_code)->where('payroll_date','payroll_date')->where('payroll_type',$request->payroll_type)->count();
      if($checkPayroll != 0){
         Session::flash('warning','You already have a payroll processes with the same parameters that you have provided');

         return redirect()->back();
      }
      $branch = $request->branch;
      $type = $request->payroll_type;
      $payroll_date = $request->payroll_date;

      return redirect()->route('hrm.payroll.process.review',[$payroll_date,$type,$branch]);
   }

   /**
   * review payroll information
   **/
   public function review($payroll_date,$type,$branch){
      if($branch == 'All') {
         $results = employees::join('hr_employee_personal_info','hr_employee_personal_info.employee_code','=','hr_employees.employee_code')
                        ->join('hr_employee_salary','hr_employee_salary.employee_code','=','hr_employees.employee_code')
                        ->join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                        ->where('hr_employees.business_code',Auth::user()->business_code)
                        ->where('payment_basis',$type)
                        ->select('hr_employees.employee_code as empID','wp_business.currency as symbol','hr_employees.names as employee_name','hr_employees.image as avator','wp_business.business_code as business_code','salary_amount','total_additions','total_deductions','payment_basis')
                        ->orderby('hr_employees.id','desc')
                        ->get();
      }else{
         $results = employees::join('hr_employee_personal_info','hr_employee_personal_info.employee_code','=','hr_employees.id')
                        ->join('hr_employee_salary','hr_employee_salary.employee_code','=','hr_employees.employee_code')
                        ->join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                        ->where('hr_employees.business_code',Auth::user()->business_code)
                        ->where('hr_employees.branch',$branch)
                        ->where('payment_basis',$type)
                        ->select('hr_employees.employee_code as empID','wp_business.currency as symbol','hr_employees.names as employee_name','hr_employees.image as avator','wp_business.business_code as business_code','salary_amount','total_additions','total_deductions','payment_basis')
                        ->orderby('hr_employees.id','desc')
                        ->get();
      }

      $currency = WIngu::business()->currency;

      return view('app.hr.payroll.payroll.review', compact('payroll_date','type','branch','currency','results'));
   }

   /**
   * runpayroll
   **/
   public function process(Request $request){
      $this->validate($request,[
         'type' => 'required',
         'branch' => 'required',
         'payroll_date' => 'required',
      ]);

      $code = Helper::generateRandomString(12);
      //payroll
      $payroll = new payroll;
      $payroll->business_code    = Auth::user()->business_code;
      $payroll->payroll_code     = $code;
      $payroll->branch_code      = $request->branch;
      $payroll->total_net_pay    = $request->net_pay;
      $payroll->total_gross_pay  = $request->gross_pay;
      $payroll->total_additions  = $request->total_additions;
      $payroll->total_deductions = $request->total_deductions;
      $payroll->total_salary     = $request->salary_amount;
      $payroll->payroll_date     = $request->payroll_date;
      $payroll->payroll_type     = $request->type;
      $payroll->created_by       = Auth::user()->user_code;
      $payroll->save();

      //payroll people
      $peoples = $request->people_employee_code;

      foreach ($peoples as $i => $people){
         $people                = new payroll_people();
         $people->payroll_code  = $code;
         $people->employee_code = $request->people_employee_code[$i];
         $people->business_code = Auth::user()->business_code;
         $people->salary        = $request->people_salary[$i];
         // $people->addition   = $request->people_additions[$i];
         $people->gross_pay     = $request->people_gross_pay[$i];
         $people->deduction     = $request->people_deduction[$i];
         $people->net_pay       = $request->people_net_pay[$i];
         $people->payment_type  = $request->people_type[$i];
         // $people->balance       = $request->people_net_pay[$i];
         $people->created_by    = Auth::user()->user_code;
         $people->save();

         //payroll items
         //deduction
         $deductions = payroll_allocations::Join('hr_payroll_deductions','hr_payroll_deductions.deduction_code','=','hr_payroll_allocations.deduction')
                                          ->where('hr_payroll_deductions.business_code',Auth::user()->business_code)
                                          ->where('category','Deduction')
                                          ->where('employee',$request->people_employee_code[$i])
                                          ->get();

         foreach($deductions as $deduc){
            $deduction                = new payroll_items();
            $deduction->payroll_code  = $code;
            $deduction->business_code = Auth::user()->business_code;
            $deduction->item          = $deduc->title;
            $deduction->employee_code = $request->people_employee_code[$i];
            $deduction->amount        = $deduc->amount;
            // $deduction->item_category = 'Deduction';
            $deduction->created_by    = Auth::user()->user_code;
            $deduction->save();
         }

         //additions
         $additions = payroll_allocations::join('hr_payroll_benefits','hr_payroll_benefits.benefit_code','=','hr_payroll_allocations.benefit')
                                       ->where('hr_payroll_benefits.business_code',Auth::user()->business_code)
                                       ->where('employee',$request->people_employee_code[$i])
                                       ->where('category','Benefits')
                                       ->get();

         foreach($additions as $add){
            $add = new payroll_items();
            $add->payroll_code = $code;
            $add->business_code = Auth::user()->business_code;
            $add->employee_code = $request->people_employee_code[$i];
            $add->item = $add->title;
            $add->amount = $add->amount;
            // $add->item_category = 'Benefits';
            $add->created_by = Auth::user()->user_code;
            $add->save();
         }

      }

      return redirect()->route('hrm.payroll.index');
   }

   /**
   * payroll details
   **/
   public function payroll_details($code){
      $payroll = payroll::where('payroll_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $payslips = payroll_people::join('hr_employees','hr_employees.employee_code','=','hr_payroll_people.employee_code')
                           ->join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                           ->where('payroll_code',$code)
                           ->select('*','currency','hr_employees.employee_code as employee_code')
                           ->get();
      $count = 1;
      return view('app.hr.payroll.payroll.details', compact('payroll','count','payslips'));
   }

   /**
   * payroll payslips
   **/
   public function payslip($employee,$payroll_code){
      $currency = Wingu::business()->currency;

      $person = payroll_people::join('hr_employees','hr_employees.employee_code','=','hr_payroll_people.employee_code')
                           ->join('hr_employee_personal_info','hr_employee_personal_info.employee_code','=','hr_employees.employee_code')
                           ->join('hr_payroll','hr_payroll.payroll_code','=','hr_payroll_people.payroll_code')
                           ->where('hr_employees.business_code',Auth::user()->business_code)
                           ->where('hr_payroll_people.payroll_code',$payroll_code)
                           ->where('hr_payroll_people.employee_code',$employee)
                           ->select('personal_number','names','payroll_date','net_pay','salary','hr_payroll_people.payroll_code as payroll_code')
                           ->first();

      $check_deductions = payroll_items::where('payroll_code',$payroll_code)
               ->where('employee_code',$employee)
               ->count();

      $deductions = payroll_items::where('payroll_code',$payroll_code)
               ->where('employee_code',$employee)
               ->get();

      $check_benefits = payroll_items::where('payroll_code',$payroll_code)
                        ->where('employee_code',$employee)
                        ->count();

      $benefits = payroll_items::where('payroll_code',$payroll_code)
               ->where('employee_code',$employee)
               ->get();

      return view('app.hr.payroll.payroll.payslip', compact('person','check_deductions','deductions','benefits','check_benefits','currency'));
   }

   /**
   * delete payslip
   **/
   public function payslip_delete($employee_code,$id){
      payroll_items::where('business_code',Auth::user()->business_code)->where('employee_code',$employee_code)->where('payroll_code',$id)->delete();
      payroll_people::where('business_code',Auth::user()->business_code)->where('employee_code',$employee_code)->where('payroll_code',$id)->delete();

      Session::flash('success','Payslip successfully deleted');

      return redirect()->back();
   }

   /**
   * delete payroll
   **/
   public function delete_payroll($id){
      payroll::where('id',$id)->where('business_code',Auth::user()->business_code)->delete();
      payroll_items::where('business_code',Auth::user()->business_code)->where('payroll_code',$id)->delete();
      payroll_people::where('business_code',Auth::user()->business_code)->where('payroll_code',$id)->delete();

      Session::flash('success','Payroll successfully deleted');

      return redirect()->back();
   }
}
