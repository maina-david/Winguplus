<?php

namespace App\Http\Controllers\app\assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\asset\types;
use Session;
use Auth;
use Helper;

class typeController extends Controller
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
      $types = types::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.assets.types.index', compact('types'));
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
      $type = new types;
      $type->type_code = Helper::generateRandomString(30);
      $type->name = $request->name;
      $type->business_code = Auth::user()->business_code;
      $type->created_by = Auth::user()->user_code;
      $type->save();

      Session::flash('success','Asset type successfully added');

      return redirect()->back();
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $edit = types::where('type_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $types = types::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.assets.types.edit', compact('types','edit'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $code)
   {
      $edit = types::where('type_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $edit->name = $request->name;
      $edit->business_code = Auth::user()->business_code;
      $edit->updated_by = Auth::user()->user_code;
      $edit->save();

      Session::flash('success','Asset type successfully updated');

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
      types::where('type_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','Asset type successfully deleted');

      return redirect()->route('assets.type.index');
   }
}
