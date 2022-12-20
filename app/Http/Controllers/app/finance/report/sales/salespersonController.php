<?php

namespace App\Http\Controllers\app\finance\report\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class salespersonController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //customer sales
   public function salesbysalesperson(Request $request){
      $to = $request->to;
      $from = $request->from;

      $sales = invoices::join('hr_employees','hr_employees.employee_code','=','fn_invoices.sales_person')
										->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                              ->groupBy('fn_invoices.sales_person')
										->select('hr_employees.names as salesperson','fn_invoices.sales_person as salespersonID','hr_employees.employee_code as employeeID','wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $others = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                              ->whereNull('fn_invoices.sales_person')
                              ->groupBy('fn_invoices.sales_person')
										->select('wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $otherCounts = invoices::whereBetween('invoice_date',[$from, $to ])
                              ->whereNull('sales_person')
                              ->where('business_code',Auth::user()->business_code)
                              ->count();

      $total  = invoices::where('business_code',Auth::user()->business_code)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->get();

      $totalCount = invoices::where('business_code',Auth::user()->business_code)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->count();

      return view('app.finance.reports.sales.salesperson', compact('to','from','sales','others','otherCounts','total','totalCount'));
   }

   public function print($to,$from){
      $sales = invoices::join('hr_employees','hr_employees.employee_code','=','fn_invoices.sales_person')
										->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                              ->groupBy('fn_invoices.sales_person')
										->select('hr_employees.names as salesperson','fn_invoices.sales_person as salespersonID','hr_employees.employee_code as employeeID','wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $others = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                              ->whereNull('fn_invoices.sales_person')
                              ->groupBy('fn_invoices.sales_person')
										->select('wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $otherCounts = invoices::whereBetween('invoice_date',[$from, $to ])
                              ->whereNull('sales_person')
                              ->where('business_code',Auth::user()->business_code)
                              ->count();

      $total  = invoices::where('business_code',Auth::user()->business_code)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->get();

      $totalCount = invoices::where('business_code',Auth::user()->business_code)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->business_code)->templateID)->template_name.'/reports/sales/salesperson', compact('to','from','sales','others','otherCounts','total','totalCount'));

		return $pdf->stream('salesperson.pdf');
   }
}
