<?php

namespace App\Http\Controllers\app\pos\supplier;

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
      $groups = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.pos.suppliers.groups.index', compact('groups'));
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
      $group->created_by = Auth::user()->user_code;
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
      $groups = category::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      $edit = category::where('business_code',Auth::user()->business_code)->where('id',$id)->first();

      return view('app.pos.suppliers.groups.edit', compact('groups','edit'));
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
      $group->updated_by    = Auth::user()->user_Code;
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
      category::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();

      Session::flash('success','Group successfully deleted');

      return redirect()->route('pos.supplier.groups.index');
   }
}
