<?php

namespace App\Http\Controllers\app\pos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\hr\branches;
use App\Models\finance\tax;
use Session;
use Auth;

class productsPriceController extends Controller
{
   /**
   * product price
   **/
   public function price($productCode)
   {
      $mainBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->first();
      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $defaultPrice = product_price::where('product_code', $productCode)
                                 ->where('business_code', Auth::user()->business_code)
                                 ->where('default_price','Yes')
                                 ->first();
      $prices = product_price::where('product_code', $productCode)->where('business_code', Auth::user()->business_code)->get();
      $outlets = branches::where('business_code',Auth::user()->business_code)->get();

      return view('app.pos.products.products.price', compact('prices','productCode','product','outlets','defaultPrice','mainBranch'));
   }


   /**
   * Update product price
   **/
   public function price_update(Request $request, $code)
   {

      $this->validate($request, array(
         'selling_price' =>'required',
         'price_id'      =>'required'
      ));

      $price = product_price::where('id',$request->price_id)
                           ->where('product_code',$code)
                           ->where('business_code',Auth::user()->business_code)
                           ->first();
      $price->buying_price = $request->buying_price;
      $price->selling_price = $request->selling_price;
      $price->offer_price = $request->offer_price;
      $price->save();

      Session::flash('success','Price updated');

      return redirect()->back();
   }
}
