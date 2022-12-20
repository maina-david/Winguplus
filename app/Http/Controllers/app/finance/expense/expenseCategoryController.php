<?php

namespace App\Http\Controllers\app\finance\expense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\expense\expense_category;
use Session;
use Auth;
use Wingu;
use Helper;

class expenseCategoryController extends Controller
{
   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('app.finance.expense.category.index');
   }

   public function express(Request $request){
      $category = new expense_category;
      $category->category_code = Helper::generateRandomString(30);
      $category->name          = $request->name;
      $category->created_by    = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();

      //records activity
      // $activities = Auth::user()->name.' Has added an expense category';
      // $section = 'Settings';
      // $type = 'Expense category';
      // $adminID = Auth::user()->user_code;
      // $business_code = Auth::user()->business_code;
      // $activityID = $category->id;

      // Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

      // Session::flash('success','Category Successfully added');
   }

   public function list(Request $request)
   {
      $category = expense_category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'name as text']);
      return ['results' => $category];
   }
}
