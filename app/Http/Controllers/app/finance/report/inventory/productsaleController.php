<?php

namespace App\Http\Controllers\app\finance\report\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class productsaleController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //customer sales
   public function report(Request $request){
      $to = $request->to;
      $from = $request->from;

      $products = invoice_products::join('fn_product_information','fn_product_information.product_code','=','fn_invoice_products.product_code')
                                 ->join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                                 ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
                                 ->where('fn_product_information.business_code',Auth::user()->business_code)
                                 ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                                 ->groupBy('fn_invoice_products.product_code')
                                 ->where('type','product')
                                 ->select('fn_product_information.product_code as product_code','fn_product_information.sku_code as sku','wp_business.currency as code','fn_product_information.product_name as name',DB::raw('sum(selling_price) total'))
                                 ->get();

      return view('app.finance.reports.inventory.productsales', compact('to','from','products'));
   }

   public function extract($to,$from){
      $products = invoice_products::join('fn_product_information','fn_product_information.product_code','=','fn_invoice_products.product_code')
                        ->join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                        ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
                        ->where('fn_product_information.business_code',Auth::user()->business_code)
                        ->whereBetween('fn_invoices.invoice_date',[$from, $to ])
                        ->groupBy('fn_invoice_products.product_code')
                        ->where('type','product')
                        ->select('fn_product_information.product_code as product_code','fn_product_information.sku_code as sku','wp_business.currency as code','fn_product_information.product_name as name',DB::raw('sum(selling_price) total'))
                        ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/reports/inventory/productsales', compact('to','from','products'));

      $name = 'productSales'.$from.'#'.$to;
		return $pdf->stream($name.'.pdf');
   }
}
