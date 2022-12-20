<?php

namespace App\Http\Controllers\app\ecommerce\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_settings;
use Finance;
use Auth;
use Wingu;
use DB;
class dashboardController extends Controller
{
   /**
   * Dashboard
   */
   public function dashboard(){

		//check if account has settings
		$check = invoice_settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::invoice_setting_setup();
		}

      //

      $month = date('m');
		$year = date('Y');
		$customers = customers::where('business_code',Auth::user()->business_code)->whereMonth('created_at','=',$month)->count();
		$todaySales = invoices::where('business_code',Auth::user()->business_code)->where('invoice_type','wingu store')->where('invoice_date', date('Y-m-d'))->sum('paid');

		$monthSales = invoices::where('business_code',Auth::user()->business_code)->where('invoice_type','wingu store')->whereMonth('invoice_date',$month)->sum('paid');
		$itemsSold = invoices::join('fn_invoice_products','fn_invoice_products.invoice_code','=','fn_invoices.id')
									->where('fn_invoices.business_code',Auth::user()->business_code)
									->where('invoice_type','wingu store')
									->whereMonth('invoice_date',$month)
									->sum('quantity');

		if($itemsSold == 0 || $monthSales == 0){
			$averageSale = 0;
		}else{
			$averageSale = $monthSales / $itemsSold;
		}


		$currency = Wingu::business()->currency;

		$salesThisYear = invoices::where('business_code',Auth::user()->business_code)
										->where('invoice_type','wingu store')
										->whereYear('invoice_date',$year)
										->groupBy(DB::raw("Month(invoice_date)"))
										->select(DB::raw('SUM(paid) as total'))
										->pluck('total');

		$salesperMonth = invoices::select(DB::raw('Month(invoice_date) as month'))
										->where('business_code',Auth::user()->business_code)
										->where('invoice_type','wingu store')
										->whereYear('invoice_date',$year)
										->groupBy(DB::raw("Month(invoice_date)"))
										->pluck('month');

		$datas = array(0,0,0,0,0,0,0,0,0,0,0,0);

		foreach($salesperMonth as $index=>$month){
			$datas[$month - 1] = intval($salesThisYear[$index]);
		}

      return view('app.ecommerce.dashboard.dashboard', compact('customers','todaySales','currency','averageSale','monthSales','itemsSold','datas','year'));
   }
}
