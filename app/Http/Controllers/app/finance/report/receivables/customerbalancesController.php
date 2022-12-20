<?php

namespace App\Http\Controllers\app\finance\report\receivables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class customerbalancesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function balance(Request $request){
      $to = $request->to;
      $from = $request->from;
      $balances  = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                           ->groupBy('fn_invoices.customer')
                           ->select('customer_name as customerName','customer_code','wp_business.currency as currency',DB::raw('sum(balance) total'))
                           ->orderby('fn_invoices.id','desc')
                           ->get();


      return view('app.finance.reports.receivables.customer_balances', compact('to','from','balances'));
   }

   public function print($to,$from){
      $balances  = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                           ->groupBy('fn_invoices.customer')
                           ->select('customer_name as customerName','customer_code','wp_business.currency as currency',DB::raw('sum(balance) total'))
                           ->orderby('fn_invoices.id','desc')
                           ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/reports/receivables/balance', compact('to','from','balances'));

		return $pdf->stream('balance.pdf');
   }
}
