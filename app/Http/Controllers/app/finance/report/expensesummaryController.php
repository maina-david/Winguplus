<?php

namespace App\Http\Controllers\app\finance\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use App\Models\finance\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\income\category;
use App\Models\finance\expense\expense_category;
use Wingu;
use Auth;
use PDF;

class expensesummaryController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function details(Request $request){
      $expense = expense::where('business_code',Auth::user()->business_code)->whereBetween('expense_date',[$request->from,$request->to])->sum('amount');
      $business = business::where('business_code',Auth::user()->business_code)->first();

      $from = $request->from;
      $to = $request->to;

      //expenses
      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->get();

      return view('app.finance.reports.overview.expensesummery', compact('expense','business','from','to','expenseCategory'));
   }

   //extract
   public function extract($to,$from){
      $expense = expense::where('business_code',Auth::user()->business_code)->whereBetween('expense_date',[$from,$to])->sum('amount');
      $business = business::where('business_code',Auth::user()->business_code)->first();

      //expenses
      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->get();

      $pdf = PDF::loadView('templates/'.Wingu::template()->template_name.'/reports/expensesummery', compact('expense','business','from','to','expenseCategory'));

      return $pdf->stream('expensesummery'.$from.'-'.$to.'.pdf');
   }
}
