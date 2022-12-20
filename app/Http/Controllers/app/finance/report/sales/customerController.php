<?php
namespace App\Http\Controllers\app\finance\report\sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class customerController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //customer sales
   public function salesbycustomer(Request $request){
      $to = $request->to;
      $from = $request->from;
      $sales = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
										->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to])
                              ->groupBy('fn_invoices.customer')
										->select('customer_name','customer_code','wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $countInvoice = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$from, $to ])->count();

      return view('app.finance.reports.sales.customer', compact('to','from','sales','countInvoice'));
   }

   public function print($to,$from){
      $sales = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
										->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
                              ->whereBetween('fn_invoices.invoice_date',[$from, $to])
                              ->groupBy('fn_invoices.customer')
										->select('customer_name','customer_code','wp_business.currency as currency',DB::raw('sum(total) total'))
										->orderby('fn_invoices.invoice_date','desc')
                              ->get();

      $countInvoice = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$from, $to ])->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/reports/sales/customer', compact('to','from','sales','countInvoice'));

		return $pdf->stream('customer.pdf');
   }
}
