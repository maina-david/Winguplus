<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\deductions;
use App\Models\hr\payroll_allocations;
use Auth;
use Session;
use Helper;

class deductionsController extends Controller
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
      $deductions = deductions::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.hr.payroll.settings.deductions', compact('deductions'));
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
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deduction = new deductions;
      $deduction->deduction_code = Helper::generateRandomString(20);
      $deduction->title = $request->title;
      $deduction->description = $request->description;
      $deduction->created_by = Auth::user()->user_code;
      $deduction->business_code = Auth::user()->business_code;
      $deduction->save();

      Session::flash('success','Deduction successfully added');

      return redirect()->back();
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $data = deductions::where('deduction_code',$code)->where('business_code',Auth::user()->business_code)->first();
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
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deduction = deductions::where('deduction_code',$request->code)->where('business_code',Auth::user()->business_code)->first();
      $deduction->title = $request->title;
      $deduction->description = $request->description;
      $deduction->update_by = Auth::user()->user_code;
      $deduction->business_code = Auth::user()->business_code;
      $deduction->save();

      Session::flash('success','Deduction successfully added');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($code)
   {
      $check = payroll_allocations::where('deduction',$code)->where('business_code',Auth::user()->business_code)->count();
      if($check > 0){
         Session::flash('warning','This deduction is linked to an employee unlink it first then delete it');
         return redirect()->back();
      }

      $deduction = deductions::where('deduction',$code)->where('business_code',Auth::user()->business_code)->first();
      $deduction->delete();

      Session::flash('success','Deduction successfully deleted');

      return redirect()->back();
   }
}
