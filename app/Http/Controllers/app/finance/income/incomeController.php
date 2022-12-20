<?php

namespace App\Http\Controllers\app\finance\income;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\income\category;
use App\Models\finance\invoice\invoices;
use Session;
use Helper;
use Auth;
class incomeController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $categories = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $count = 1;
      return view('app.finance.income.index', compact('categories','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
      ]);

      $category = new category;
      $category->category_code = Helper::generateRandomString(20);
      $category->name = $request->name;
      $category->description = $request->description;
      $category->created_by = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();

      Session::flash('success','Income category successfully added');

      return redirect()->route('finance.income.category');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {

   }

   /**
    * edit leave
    *
    * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $data = category::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      return response()->json(['data' => $data]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
      ]);

      $category = category::where('business_code',Auth::user()->business_code)->where('id',$request->incomeID)->first();
      $category->name = $request->name;
      $category->description = $request->description;
      $category->updated_by = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();

      Session::flash('success','Income category successfully updated');

      return redirect()->back();
   }

   /**
    * store income category express
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function express(Request $request){
      $category = new category;
      $category->category_code = Helper::generateRandomString(20);
      $category->name = $request->category_name;
      $category->created_by = Auth::user()->user_code;
      $category->business_code = Auth::user()->business_code;
      $category->save();
   }

   public function get_express()
   {
      $accounts = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'name as text']);
      return ['results' => $accounts];
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      //check if category is linked invoice
      $check = invoices::where('business_code',Auth::user()->business_code)->where('income_category',$id)->count();
      if($check == 0){
         $delete = category::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
         $delete->delete();

         Session::flash('success','Income category successfully deleted');
      }else{
         Session::flash('warning','This category is linked to several invoices, please unlink it then delete the category');

         return redirect()->back();
      }


      return redirect()->back();
   }
}
