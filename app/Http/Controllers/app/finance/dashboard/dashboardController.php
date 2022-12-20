<?php

namespace App\Http\Controllers\app\finance\dashboard;
use App\Models\finance\products\product_information;
use App\Charts\Finance\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\expense\expense;
use Auth;
use DB;
use Wingu;
class dashboardController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function home(Request $request)
   {
      if($request->year){
         $year = $request->year;
         $month = $request->month;
         $monthName = date("F", strtotime(date("Y") ."-".$request->month."-01"));
      }else{
         $year = date('Y');
         $month = date('m');
         $monthName = date('F');
      }

      $currency = Wingu::business()->currency;

      $dueInvoicesCount = invoices::where('business_code', Auth::user()->business_code)
                           ->where('invoice_number','!=',0)
                           ->where('status','!=',1)
                           ->whereYear('invoice_date', '=', $year)
                           ->where('invoice_due', '>=', date('Y-m-d'))
                           ->count();

      $monthTotalSales = invoices::where('business_code',Auth::user()->business_code)
                              ->whereYear('invoice_date',$year)
                              ->whereMonth('invoice_date',$month)
                              ->select('total')
                              ->get()
                              ->sum('total');

      $expensesThisMonth = expense::where('business_code',Auth::user()->business_code)
                                 ->whereYear('expense_date',$year)
                                 ->whereMonth('expense_date',$month)
                                 ->select('amount')
                                 ->get()
                                 ->sum('amount');

      /*
      * Sales Overview
      * */
      $yearSales = invoices::where('business_code',Auth::user()->business_code)
                              ->whereYear('invoice_date',$year)
                              ->groupBy(DB::raw("Month(invoice_date)"))
                              ->select(DB::raw('SUM(total) as total'))
                              ->pluck('total');

      $salesPerMonth = invoices::select(DB::raw('Month(invoice_date) as month'))
                              ->where('business_code',Auth::user()->business_code)
                              ->whereYear('invoice_date',$year)
                              ->groupBy(DB::raw("Month(invoice_date)"))
                              ->pluck('month');

      $salesOverviewData = array(0,0,0,0,0,0,0,0,0,0,0,0);

      foreach($salesPerMonth as $index=>$month){
         $salesOverviewData[$month - 1] = intval($yearSales[$index]);
      }

      /*
      * Expense Overview
      * */
      $expenseOverview = new Reports;

      //amount
      $expenseAmount = expense::where('business_code',Auth::user()->business_code)
                           ->whereYear('expense_date',$year)
                           ->groupBy(DB::raw("Month(expense_date)"))
                           ->select(DB::raw('SUM(amount) as total'))
                           ->pluck('total');

      //expense months
      $expenseMonths = expense::select(DB::raw('month(expense_date) as month'))
                              ->where('business_code',Auth::user()->business_code)
                              ->whereYear('expense_date',$year)
                              ->groupBy(DB::raw("month(expense_date)"))
                              ->selectRaw("DATE_FORMAT(expense_date, '%M') AS month")
                              ->pluck('month');


      $expenseOverview->labels($expenseMonths->values());
      $expenseOverview->dataset('', 'bar', $expenseAmount->values())
                        ->backgroundColor(collect(['rgba(243,71,112,0.2','rgba(237, 88, 18, 0.6)','rgba(243,71,112,0.2)','rgba(247, 229, 6, 0.6)','rgba(237, 88, 18, 0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));


      //products
      $products = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                    ->where('type','product')
                                    ->where('fn_product_inventory.business_code',Auth::user()->business_code)
                                    ->get();

      //with no stock
      $withNoStock = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                       ->where('type','product')
                                       ->where('current_stock',0)
                                       ->where('fn_product_inventory.business_code',Auth::user()->business_code)
                                       ->count();

      //stock alert
      $stockAlert = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                       ->where('type','product')
                                       ->where('reorder_point','>','current_stock')
                                       ->where('fn_product_inventory.business_code',Auth::user()->business_code)
                                       ->count();

      return view('app.finance.dashboard.dashboard', compact('dueInvoicesCount','year','monthTotalSales','monthName','month','salesOverviewData','expensesThisMonth','expenseOverview','currency','products','withNoStock','stockAlert'));
   }
}
