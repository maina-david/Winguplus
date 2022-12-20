<?php

namespace App\Http\Controllers\app\finance\products;

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
      $count = 1;
      return view('app.finance.products.tags.index', compact('tags','count'));
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
      $tags->name = $request->name;
      $tags->business_code = Auth::user()->business_code;
      $tags->created_by = Auth::user()->user_code;
      $tags->save();

      session::flash('success','You have successfully created a new Tag.');

      return redirect()->route('finance.product.tags');
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
   public function edit($id)
   {
      $tag = tags::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $tags = tags::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.tags.edit', compact('tag','count','tags'));
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
         'name' => '',
      ]);

      $tags = tags::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $tags->name = $request->name;
      $tags->updated_by = Auth::user()->user_code;
      $tags->save();

      session::flash('success','Tag successfully updated!');

      return redirect()->route('finance.product.tags.edit',$tags->id);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $tag = tags::where('id',$id)->where('business_code',Auth::user()->business_code)->first();;
      $tag->delete();

      Session::flash('success', 'The Tag was successfully deleted !');

      return redirect()->route('finance.product.tags');
   }
}
