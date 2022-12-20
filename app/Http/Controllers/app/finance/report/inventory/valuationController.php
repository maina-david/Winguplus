<?php

namespace App\Http\Controllers\app\finance\report\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_information;
use App\Models\finance\invoice\invoice_products;
use App\Models\wingu\business;
use Auth;
use Session;
use DB;
use PDF;
use Wingu;
class valuationController extends Controller
{
   /**
    * Filter
    */
   public function report(Request $request){
      $business = business::where('business_code',Auth::user()->business_code)
                           ->select('currency as code')
                           ->first();

      $products = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                 ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                                 ->where('fn_product_information.business_code',Auth::user()->business_code)
                                 ->where('type','product')
                                 ->groupBy('fn_product_information.product_code')
                                 ->select('fn_product_information.product_name as product_name','fn_product_information.sku_code as sku_code','fn_product_inventory.current_stock as current_stock','fn_product_information.product_code as product_code','fn_product_price.selling_price as price')
                                 ->orderby('current_stock','desc')
                                 ->get();

      return view('app.finance.reports.inventory.valuation', compact('products','business'));
   }

   /**
    * print report
    */
   public function extract(){
      $business = business::where('business_code',Auth::user()->business_code)->select('currency as code')->first();

      $products = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                           ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                           ->where('fn_product_information.business_code',Auth::user()->business_code)
                           ->where('type','product')
                           ->groupBy('fn_product_information.product_code')
                           ->select('fn_product_information.product_name as product_name','fn_product_information.sku_code as sku_code','fn_product_inventory.current_stock as current_stock','fn_product_information.product_code as product_code','fn_product_price.selling_price as price')
                           ->orderby('current_stock','desc')
                           ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/reports/inventory/valuation', compact('products','business'));

      $name = 'inventory_valuation';
		return $pdf->stream($name.'.pdf');
   }
}

