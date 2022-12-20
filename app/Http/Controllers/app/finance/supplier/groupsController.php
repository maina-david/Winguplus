<?php

namespace App\Http\Controllers\app\finance\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\category;
use Auth;
use Session;

class groupsController extends Controller
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
      $count = 1;
      $groups = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.finance.suppliers.groups.index', compact('groups','count'));
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
         'name' => 'required'
      ]);

      $group = new category;
      $group->name = $request->name;
      $group->business_code = Auth::user()->business_code;
      $group->updated_by = Auth::user()->user_code;
      $group->save();

      Session::flash('success','Group added successfully');

      return redirect()->back();

   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $count = 1;
      $groups = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $edit = category::where('business_code',Auth::user()->business_code)->where('id',$id)->first();

      return view('app.finance.suppliers.groups.edit', compact('groups','count','edit'));
   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $this->validate($request,[
         'name' => 'required'
      ]);

      $group = category::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $group->name          = $request->name;
      $group->business_code = Auth::user()->business_code;
      $group->updated_by    = Auth::user()->user_code;
      $group->save();

      Session::flash('success','Group updated successfully');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($id)
   {
      $group = category::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $group->delete();

      Session::flash('success','Group successfully deleted');

      return redirect()->route('finance.supplier.groups.index');
   }
}
