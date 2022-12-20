<?php

namespace App\Http\Controllers\app\pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\brand;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class brandController extends Controller
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
      $brands = brand::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();
      return view('app.pos.products.brands.index', compact('brands'));
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

      $check = brand::where('business_code',Auth::user()->business_code)->where('name',$request->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($request->name);
      }else{
         $url = Helper::seoUrl($request->name).Helper::generateRandomString(10);
      }

      $brand = new brand;
      $brand->brand_code   = Helper::generateRandomString(30);
      $brand->name          = $request->name;
      $brand->url           = $url;
      $brand->business_code = Auth::user()->business_code;
      $brand->created_by    = Auth::user()->user_code;
      $brand->save();

      session::flash('success','You have successfully created a new brand.');

      return redirect()->route('pos.product.brand');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $brand = brand::where('brand_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $brands = brand::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();

      return view('app.pos.products.brands.edit', compact('brand','brands'));
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

      $brand = brand::where('brand_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $brand->name = $request->name;
      $brand->updated_by = Auth::user()->user_code;
      $brand->save();

      session::flash('success','Brand successfully updated!');

      return redirect()->route('pos.product.brand.edit',$code);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      brand::where('brand_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success', 'The brand was successfully deleted !');

      return redirect()->route('pos.product.brand');
   }
}
