<?php

namespace App\Http\Controllers\app\ecommerce\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use Helper;
use Auth;
use Session;
class settingsController extends Controller
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
      //
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
      //
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
   public function edit($id){
      $product = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $productID = $id;
      if($product->product_code == ""){
         $addCode = product_information::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
         $addCode->product_code = Helper::generateRandomString(10);
         $addCode->save();
      }

      return view('app.finance.products.settings', compact('productID','product'));
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
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
