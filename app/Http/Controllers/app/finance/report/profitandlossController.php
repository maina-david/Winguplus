<?php

namespace App\Http\Controllers\app\finance\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\income\category;
use App\Models\finance\expense\expense_category;
use Wingu;
use Auth;
use PDF;
class profitandlossController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function details(Request $request){
      $income = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$request->from,$request->to])->sum('total');
      $expense = expense::where('business_code',Auth::user()->business_code)->whereBetween('expense_date',[$request->from,$request->to])->sum('amount');
      $business = business::where('business_code',Auth::user()->business_code)->first();
      $incomeCategories = category::where('business_code',Auth::user()->business_code)->get();
      $defaultCategories = category::where('business_code','admin')->get();

      $from = $request->from;
      $to = $request->to;

      $unCategorisedInvoicesCount = invoices::where('business_code',Auth::user()->business_code)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->count();

      $unCategorisedInvoicesSum = invoices::where('business_code',Auth::user()->business_code)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->sum('total');

      $unCategorisedInvoicesSum2 = invoices::where('business_code',Auth::user()->business_code)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->where('income_category',0)
                                             ->sum('total');

      //expenses
      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->get();

      return view('app.finance.reports.profitandloss.detailed', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory','unCategorisedInvoicesSum2','defaultCategories'));
   }

   //pdf generator
   public function pdf($to,$from){
      $income = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$from,$to])->sum('total');
      $expense = expense::where('business_code',Auth::user()->business_code)->whereBetween('expense_date',[$from,$to])->sum('amount');
      $business = business::where('business_code',Auth::user()->business_code)->first();
      $incomeCategories = category::where('business_code',Auth::user()->business_code)->get();
      $defaultCategories = category::where('business_code','admin')->get();

      $unCategorisedInvoicesCount = invoices::whereBetween('invoice_date',[$from,$to])->whereNull('income_category')->count();
      $unCategorisedInvoicesSum = invoices::whereBetween('invoice_date',[$from,$to])->whereNull('income_category')->sum('total');
      $unCategorisedInvoicesSum2 = invoices::where('business_code',Auth::user()->business_code)
                                          ->whereBetween('invoice_date',[$from,$to])
                                          ->where('income_category',0)
                                          ->sum('total');

      //expenses
      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->get();

      $pdf = PDF::loadView('templates/'.Wingu::template()->template_name.'/reports/profitandloss', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory','defaultCategories','unCategorisedInvoicesSum2'));

      return $pdf->stream('profitandloss'.$from.'-'.$to.'.pdf');
   }
}
