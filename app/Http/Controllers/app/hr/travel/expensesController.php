<?php

namespace App\Http\Controllers\app\hr\travel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_category;
use App\Models\finance\expense\expense_items;
use App\Models\wingu\file_manager as docs;
use App\Models\wingu\business;
use App\Models\hr\travel;
use Session;
use Wingu;
use File;
use Helper;
use Auth;
use DB;
class expensesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Travel expense list
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){

      $expenses = expense::join('hr_travels','hr_travels.travel_code','=','fn_expense.travel_code')
                          ->join('wp_business','wp_business.business_code','=','fn_expense.business_code')
                          ->join('wp_status','wp_status.id','=','fn_expense.status')
                          ->where('fn_expense.business_code',Auth::user()->business_code)
                          ->where('expense_type','Travel')
                          ->select('fn_expense.amount as amount','hr_travels.travel_code as travelCode','fn_expense.expense_date as date','wp_status.name as statusName','fn_expense.updated_at as modifiedDate','fn_expense.expense_name as title','approval_date','fn_expense.updated_by as updatedBy','fn_expense.expense_code as expenseCode','fn_expense.travel_code as expenseTravelID','wp_business.currency as currency')
                          ->orderby('fn_expense.id','desc')
                          ->get();
      return view('app.hr.travel.expenses.index', compact('expenses'));
   }

   /**
   * Create travel expense
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      $travels = travel::join('fn_customers','fn_customers.customer_code','=','hr_travels.customer_code')
                        ->where('hr_travels.business_code',Auth::user()->business_code)
                        ->select('hr_travels.travel_code as travel_code','customer_name','place_of_visit','departure_date','hr_travels.travel_code as trID')
                        ->orderby('hr_travels.travel_code','desc')
                        ->get();

      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('name','category_code');

      return view('app.hr.travel.expenses.create', compact('travels','expenseCategory'));
   }

   /**
   * Store expense
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request, [
         'travel' => 'required',
         'expense' => 'required',
         'price' => 'required',
         'quantity' => 'required',
         'expense_category' => 'required',
         'date' => 'required',
      ]);

      //add expense
      $code = Helper::generateRandomString(30);
      $store = new expense;
      $store->expense_code      = $code;
      $store->expense_date      =  $request->date;
      $store->expense_name      =  $request->expense_name;
      $store->travel_code       =  $request->travel;
      $store->category          =  $request->expense_category;
      $store->expense_type      =  'Travel';
      $store->status            =  $request->status;
      $store->created_by        =  Auth::user()->user_code;
      $store->business_code     =  Auth::user()->business_code;
      $store->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(15). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;

            $upload->file_code      = $code;
            $upload->folder 	      = 'expenses';
            $upload->name 		      = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->file_name      = $fileName;
            $upload->file_size      = $size;
            $upload->file_mime      = $file->getClientMimeType();
            $upload->created_by     = Auth::user()->user_code;
            $upload->business_code  = Auth::user()->business_code;
            $upload->save();
         }
      }

      //calculate and add expense Items
      $expenseItems = $request->expense;
		foreach ($expenseItems as $k => $v){
			$mainAmount = $request->price[$k] * $request->quantity[$k];
         $item                = new expense_items;
         $item->item_code     = Helper::generateRandomString(30);
         $item->expense_code	= $code;
         $item->travel_code	= $request->travel;
			$item->expense		   = $request->expense[$k];
         $item->quantity		= $request->quantity[$k];
         $item->price		   = $request->price[$k];
			$item->total_amount  = $mainAmount;
			$item->business_code = Auth::user()->business_code;
         $item->created_by    = Auth::user()->user_code;
			$item->save();
      };

      //get expense Items for expense calculation
      $getItems = expense_items::where('expense_code',$code)
                              ->where('business_code',Auth::user()->business_code)
                              ->select(DB::raw('SUM(total_amount) as amount'))
                              ->first();

      //updated expense
      $expenseUpdate = expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $expenseUpdate->amount  =  $getItems->amount;
      $expenseUpdate->save();

      //get travel
      $travel = travel::where('travel_code',$request->travel)
                     ->where('business_code',Auth::user()->business_code)
                     ->first();
      $travel->expense_code = $code;
      $travel->amount = $getItems->amount;
      $travel->save();

      Session::flash('success','Expense successfully added');

      return redirect()->route('hrm.travel.expenses');
   }

   /**
   * Expense edit
   *
   * @return \Illuminate\Http\Response
   */
   public function edit($code){
      $travels = travel::join('fn_customers','fn_customers.customer_code','=','hr_travels.customer_code')
                        ->where('hr_travels.business_code',Auth::user()->business_code)
                        ->select('hr_travels.travel_code as travel_code','customer_name','place_of_visit','departure_date','hr_travels.travel_code as travelCode')
                        ->orderby('hr_travels.travel_code','desc')
                        ->get();

      $edit = expense::join('hr_travels','hr_travels.travel_code','=','fn_expense.travel_code')
                     ->join('fn_customers','fn_customers.customer_code','=','hr_travels.customer_code')
                     ->where('fn_expense.business_code',Auth::user()->business_code)
                     ->where('fn_expense.expense_code',$code)
                     ->where('fn_expense.business_code',Auth::user()->business_code)
                     ->select('*','hr_travels.travel_code as travel_code','fn_expense.status as status','fn_expense.expense_code as expenseCode','fn_expense.category as expense_category','expense_date as date')
                     ->first();

      $expenses = expense_items::where('expense_code',$code)
                              ->where('business_code',Auth::user()->business_code)
                              ->get();

      $files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

      $expenseCategory = expense_category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('name','category_code');

      return view('app.hr.travel.expenses.edit', compact('travels','edit','expenses','files','expenseCategory'));
   }

   /**
   * update expense
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code){
      $this->validate($request, [
         'travel'           => 'required',
         'expense'          => 'required',
         'price'            => 'required',
         'quantity'         => 'required',
         'expense_category' => 'required',
         'date'             => 'required',
      ]);

      //add expense
      $store = expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $store->expense_date      =  $request->date;
      $store->expense_name      =  $request->expense_name;
      $store->travel_code       =  $request->travel;
      $store->category          =  $request->expense_category;
      $store->expense_type      =  'Travel';
      $store->status            =  $request->status;
      $store->updated_by        =  Auth::user()->user_code;
      $store->business_code     =  Auth::user()->business_code;
      $store->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(15). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;

            $upload->file_code      = $code;
            $upload->folder 	      = 'expenses';
            $upload->name 		      = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->file_name      = $fileName;
            $upload->file_size      = $size;
            $upload->file_mime      = $file->getClientMimeType();
            $upload->created_by     = Auth::user()->user_code;
            $upload->business_code  = Auth::user()->business_code;
            $upload->save();
         }
      }

      //delete current expense
      expense_items::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      //calculate and add expense Items
      $expenseItems = $request->expense;
		foreach ($expenseItems as $k => $v){
			$mainAmount = $request->price[$k] * $request->quantity[$k];
         $item                = new expense_items;
         $item->expense_code  = $code;
         $item->travel_code   = $request->travel;
			$item->expense		   = $request->expense[$k];
         $item->quantity		= $request->quantity[$k];
         $item->price		   = $request->price[$k];
			$item->total_amount  = $mainAmount;
			$item->business_code = Auth::user()->business_code;
			$item->save();
      };

      //get expense Items for expense calculation
      $getItems = expense_items::where('expense_code',$code)
                              ->where('business_code',Auth::user()->business_code)
                              ->select(DB::raw('SUM(total_amount) as amount'))
                              ->first();

      //updated expense
      $expenseUpdate = expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $expenseUpdate->amount  =  $getItems->amount;
      $expenseUpdate->save();

      //get travel
      $travel = travel::where('travel_code',$request->travel)
                     ->where('business_code',Auth::user()->business_code)
                     ->first();
      $travel->expense_code = $code;
      $travel->amount       = $getItems->amount;
      $travel->save();

      Session::flash('success','Expense successfully updated');

      return redirect()->back();
   }


   /**
   * Delete expense files
   *
   * @return \Illuminate\Http\Response
   */
   public function delete_file($code,$id){
      $delete = docs::where('id',$id)->where('file_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';

      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','document deleted successfully');

      return redirect()->back();
   }

   /**
   * Delete expenses
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($code){
      expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->delete();
      expense_items::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->get();
      $delete = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';

      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','Expense deleted successfully');

      return redirect()->route('hrm.travel.expenses');
   }
}
