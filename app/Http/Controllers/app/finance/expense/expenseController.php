<?php
namespace App\Http\Controllers\app\finance\expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_category;
use App\Models\finance\payments\payment_type;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\accounts;
use App\Models\finance\payments\payment_methods;
use App\Models\finance\tax;
use App\Models\wingu\file_manager as docs;
use Session;
use File;
use Helper;
use Wingu;
use Auth;

class expenseController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(){
      return view('app.finance.expense.expense.index');
   }

   public function create(){
      $category = expense_category::where('business_code',Auth::user()->business_code)
                                    ->OrderBy('id','DESC')
                                    ->pluck('name','category_code')
                                    ->prepend('Choose Expense Category','');

      $tax = tax::OrderBy('id','DESC')
               ->where('business_code',Auth::user()->business_code)
               ->pluck('rate','tax_code')
               ->prepend('Choose VAT type');

      $paymentMethods = payment_methods::where('business_code',Auth::user()->business_code)->get();
      // $defaultPayment = payment_methods::->get();
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.finance.expense.expense.create', compact('category','tax','suppliers','paymentMethods'));
   }

   public function store(Request $request){
      $this->validate($request, array(
         'expense_date'              => 'Required',
         'expense_name'      => 'Required',
         'status'            => 'Required',
         'amount'            => 'Required',
         'category'           => 'Required',
      ));

      $code = Helper::generateRandomString(20);
      $expense = new expense;
      $expense->expense_date      =  $request->expense_date;
      $expense->expense_code      =  $code;
      $expense->deduct            =  $request->deduct;
      $expense->expense_name      =  $request->expense_name;
      if($request->account){
         $expense->account           =  accounts::where('business_code',Auth::user()->business_code)->where('id',$request->account)->first()->account_code;
      }
      $expense->category          =  $request->category;
      $expense->amount            =  $request->amount;
      if($request->tax_rate){
         $expense->tax_rate          =  tax::where('id',$request->tax_rate)
                                          ->where('business_code',Auth::user()->business_code)
                                          ->first()
                                          ->tax_code;
      }
      $expense->reference_number  =  $request->reference_number;
      if($request->supplier){
         $expense->supplier          =  suppliers::where('id',$request->supplier)
                                             ->where('business_code',Auth::user()->business_code)
                                             ->first()->supplier_code;
      }
      $expense->payment_method    =  $request->payment_method;
      $expense->status            =  $request->status;
      $expense->description       =  $request->description;
      $expense->expense_type      =  'expense';
      $expense->created_by        =  Auth::user()->user_code;
      $expense->business_code     =  Auth::user()->business_code;
      $expense->save();

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
            $fileName = Helper::generateRandomString(30). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;

            $upload->file_code      = $code;
            $upload->folder 	      = 'expenses';
            $upload->name 		      = $request->expense_name.'-'.Helper::generateRandomString(120);
            $upload->file_name      = $fileName;
            $upload->file_size      = $size;
            $upload->file_mime      = $file->getClientMimeType();
            $upload->created_by     = Auth::user()->user_code;
            $upload->business_code  = Auth::user()->business_code;
            $upload->save();
         }
      }

      // if($request->deduct == 'Yes' ){
      //    //deduct from account
      //    $account = accounts::where('business_code',Auth::user()->business_code)->where('id',$request->account)->first();
      //    $account->initial_balance = $account->initial_balance - $request->amount;
      //    $account->save();
      // }

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>Added</b> an new expense '.$request->expense_name.'</a>';
		$module       = 'Finance';
		$section      = 'Expense';
      $action       = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','expense added');

      return redirect()->route('finance.expense.index');
   }

   public function edit($code){
      $expense = expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $category = expense_category::OrderBy('id','DESC')
                  ->where('business_code',Auth::user()->business_code)
                  ->pluck('name','category_code');

      $tax = tax::OrderBy('id','DESC')
                  ->where('business_code',Auth::user()->business_code)
                  ->pluck('rate','tax_code')
                  ->prepend('Choose VAT type');

      $files = docs::where('file_code',$code)
               ->where('folder','=','expenses')
               ->where('business_code',Auth::user()->business_code)
               ->get();

      $accountPayment = payment_methods::where('business_code',Auth::user()->business_code)->get();
      $suppliers = suppliers::where('business_code', Auth::user()->business_code)->pluck('supplier_name','supplier_code')->prepend('','choose supplier');
      $bankAccounts = accounts::where('business_code',Auth::user()->business_code)->pluck('title','account_code')->prepend('Choose Account','');

      return view('app.finance.expense.expense.edit', compact('expense','category','tax','files','suppliers','bankAccounts','accountPayment'));
   }

   public function update(Request $request,$code){
      $this->validate($request, array(
         'expense_date'              => 'Required',
         'expense_name'      => 'Required',
         'status'            => 'Required',
         'amount'            => 'Required',
         'category'          => 'Required',
      ));


      $expense = expense::where('business_code',Auth::user()->business_code)->where('expense_code',$code)->first();
      //make new update
      $expense->expense_date      =  $request->expense_date;
      $expense->deduct            =  $request->deduct;
      $expense->expense_name      =  $request->expense_name;
      $expense->account           =  $request->account;
      $expense->category          =  $request->category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->reference_number  =  $request->reference_number;
      $expense->supplier          =  $request->supplier;
      $expense->payment_method    =  $request->payment_method;
      $expense->status            =  $request->status;
      $expense->description       =  $request->description;
      $expense->payment_method    =  $request->payment_method;
      $expense->updated_by        =  Auth::user()->user_code;
      $expense->business_code     =  Auth::user()->business_code;
      $expense->save();

      // if($request->deduct == 'No' && $expense->deduct == 'Yes'){
      //    //update the account
      //    $account = accounts::where('business_code',Auth::user()->business_code)->where('id',$expense->accountID)->first();
      //    $account->initial_balance = $account->initial_balance + $expense->amount;
      //    $account->save();
      // }

      // if($request->deduct == 'Yes' && $expense->deduct == 'No'){
      //    //deduct from account and save new amount
      //    $account = accounts::where('business_code',Auth::user()->business_code)->where('id',$request->account)->first();
      //    $account->initial_balance = $account->initial_balance - $request->amount;
      //    $account->save();
      // }


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
            $fileName = Helper::generateRandomString(30). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;

            $upload->file_code      = $code;
            $upload->folder 	      = 'expenses';
            $upload->name 		      = $request->expense_name.'-'.Helper::generateRandomString(10);
            $upload->file_name      = $fileName;
            $upload->file_size      = $size;
            $upload->file_mime      = $file->getClientMimeType();
            $upload->created_by     = Auth::user()->user_code;
            $upload->business_code  = Auth::user()->business_code;
            $upload->save();
         }
      }

      //recorded activity
		$activity     = 'expense has been updated by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Expense';
      $action       = 'Edit';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Expense Updated');

      return redirect()->back();
   }

   public function destroy($code){

      //delete expense
      $expense = expense::where('expense_code',$code)->where('business_code',Auth::user()->business_code)->first();

      //add the amount to specific account
      if($expense->deduct == 'Yes'){
         $account = accounts::where('business_code',Auth::user()->business_code)->where('id',$expense->accountID)->first();
         $account->initial_balance = $account->initial_balance + $expense->amount;
         $account->save();
      }


      //delete files
      $check = docs::where('file_code',$code)
               ->where('folder','expenses')
               ->where('business_code',Auth::user()->business_code)
               ->count();

      if($check > 0){
         $files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();
         foreach($files as $file) {
            docs::where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();
            $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';
            $path = $directory.$file->file_name;
            if (File::exists($path)) {
                  unlink($path);
            }
            $file->delete();
         }
      }

      $expense->delete();

      //recorded activity
		$activity     = 'expense has been deleted by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Expense';
      $action       = 'Delete';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Expense delete successfully');

      return redirect()->back();
   }

   public function file_delete($code){

      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';

      $delete = docs::where('id',$code)->where('business_code',Auth::user()->business_code)->first();

      $file = $directory.$delete->file_name;
      if (File::exists($file)) {
         unlink($file);
      }
      $delete->delete();

      //recorded activity
		$activity     = 'expense file has been deleted by '.Auth::user()->name;
		$module       = 'Finance';
		$section      = 'Expense Files';
      $action       = 'Delete';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   public function download($id) {
      $file = docs::where('id',$id)->where('folder','expenses')->where('business_code',Auth::user()->business_code)->first();
      $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/expense/';
      $path = $directory.$file->file_name;
      return response()->download($path);
   }
}
