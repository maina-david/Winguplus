<?php

namespace App\Http\Controllers\app\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\suppliers\category;
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
      $categories = category::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      return view('app.suppliers.category.index', compact('categories','count'));
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

      $category = new category;
      $category->name = $request->name;
      $category->businessID = Auth::user()->businessID;
      $category->createdBy = Auth::user()->id;
      $category->updatedBy = Auth::user()->id;
      $category->save();

      Session::flash('success','Category added successfully');

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
      $categorys = category::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $edit = category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      return view('app.suppliers.category.edit', compact('categorys','count','edit'));
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

      $category = category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $category->name = $request->name;
      $category->businessID = Auth::user()->businessID;
      $category->updatedBy = Auth::user()->id;
      $category->save();

      Session::flash('success','Category updated successfully');

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
      $category = category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $category->delete();

      Session::flash('success','Category successfully deleted');

      return redirect()->route('supplier.category.index');
   }
}
