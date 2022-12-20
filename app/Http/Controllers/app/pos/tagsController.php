<?php

namespace App\Http\Controllers\app\pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\tags;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class tagsController extends Controller
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
      $tags = tags::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();

      return view('app.pos.products.tags.index', compact('tags'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request,array(
         'name'=>'required',
      ));

      $tags = new tags;
      $tags->name          = $request->name;
      $tags->business_code = Auth::user()->business_code;
      $tags->created_by    = Auth::user()->user_code;
      $tags->save();

      session::flash('success','You have successfully created a new Tag.');

      return redirect()->route('pos.product.tags');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $tag = tags::where('id',$code)->where('business_code',Auth::user()->business_code)->first();

      $tags = tags::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();

      return view('app.pos.products.tags.edit', compact('tag','tags'));
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
      $this->validate($request,[
         'name' => '',
      ]);

      $tags = tags::where('id',$code)->where('business_code',Auth::user()->business_code)->first();
      $tags->name       = $request->name;
      $tags->updated_by = Auth::user()->user_code;
      $tags->save();

      session::flash('success','Tag successfully updated!');

      return redirect()->route('pos.product.tags.edit',$code);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($code)
   {
      tags::where('id',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success', 'The Tag was successfully deleted !');

      return redirect()->route('pos.product.tags');
   }
}
