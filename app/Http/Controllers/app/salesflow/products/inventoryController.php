<?php
namespace App\Http\Controllers\app\salesflow\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use App\Models\hr\branches;
use Auth;
use Session;
use Hr;

class inventoryController extends Controller{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display inventory
   *
   * @return \Illuminate\Http\Response
   */
   public function inventory($productCode){
      $mainBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->first();

      //product infromation
      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();

      //get inventory per branch
      $inventories = product_inventory::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->get();

      //outlets
      $outlets = branches::where('business_code',Auth::user()->business_code)->get();

      //default inventory
      $defaultInventory = product_inventory::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();

      return view('app.salesflow.products.inventory', compact('inventories','productCode','product','outlets','mainBranch','mainBranch'));
   }

   /**
   * product inventory settings
   */
   public function inventory_settings(Request $request,$productCode){
      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $product->track_inventory = $request->track_inventory;
      $product->same_price = $request->same_price;
      $product->save();

      Session::flash('success','Product inventory successfully updated');

      return redirect()->back();
   }

   /**
   * update product inventory
   *
   * @return \Illuminate\Http\Response
   */
   public function inventory_update(Request $request,$id,$productCode){
      $product = product_inventory::where('id',$id)
                                 ->where('product_code',$productCode)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->first();

      $product->current_stock = $request->current_stock;
      $product->reorder_point = $request->reorder_point;
      $product->reorder_qty = $request->reorder_qty;
      $product->expiration_date = $request->expiration_date;
      $product->business_code = Auth::user()->business_code;
      $product->updated_by = Auth::user()->user_code;
      $product->save();

      if($product->current_stock > $product->reorder_point){
         $update = product_inventory::where('id',$id)
                                    ->where('product_code',$productCode)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->first();
         $update->notification = 0;
         $update->save();
      }

      Session::flash('success','Product inventory successfully updated');

      return redirect()->back();
   }

   /**
   * link outlet to inventory
   */
   public function inventory_outlet_link(Request $request){
      $this->validate($request,[
         'productCode' => 'required',
         'outlets' => 'required'
      ]);

      $defaultBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->first();

      //add category
      $outlets = count(collect($request->outlets));
      if($outlets > 0){
         //upload new category
         for($i=0; $i < count($request->outlets); $i++ ){

            //check if outlet is linked
            if($defaultBranch->branch_code != $request->outlets[$i]){
               $checkOutLet = product_inventory::where('product_code',$request->productCode)
                                             ->where('branch_code',$request->outlets[$i])
                                             ->where('business_code',Auth::user()->business_code)
                                             ->count();
               if($checkOutLet == 0){
                  $out = new product_inventory;
                  $out->branch_code   = $request->outlets[$i];
                  $out->product_code  = $request->productCode;
                  $out->business_code = Auth::user()->business_code;
                  $out->created_by    = Auth::user()->user_code;
                  $out->updated_by    = Auth::user()->user_code;
                  $out->save();
               }

               $checkOutLet = product_price::where('product_code',$request->productCode)
                                          ->where('branch_code',$request->outlets[$i])
                                          ->where('business_code',Auth::user()->business_code)
                                          ->count();
               if($checkOutLet == 0){
                  //link outlet to price
                  $priceOutlet = new product_price;
                  $priceOutlet->product_code  = $request->productCode;
                  $priceOutlet->branch_code   = $request->outlets[$i];
                  $priceOutlet->business_code = Auth::user()->business_code;
                  $priceOutlet->updated_by    = Auth::user()->user_code;
                  $priceOutlet->created_by    = Auth::user()->user_code;
                  $priceOutlet->save();
               }
            }
         }
      }

      Session::flash('success','Item successfully link to outlet');

      return redirect()->back();
   }

   /**
   * Delete inventroy link
   */
   public function delete_inventroy($product_code,$branch_code){
      $inventory = product_inventory::where('product_code',$product_code)
                                    ->where('branch_code',$branch_code)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->first();

      if($inventory->current_stock == "" || $inventory->current_stock == 0 ){
         product_inventory::where('product_code',$product_code)->where('branch_code',$branch_code)->where('business_code',Auth::user()->business_code)->delete();
         product_price::where('product_code',$product_code)->where('branch_code',$branch_code)->where('business_code',Auth::user()->business_code)->delete();
         Session::flash('success','Product successfully deleted');
         return redirect()->back();
      }else{
         Session::flash('warning','make sure you dont have any item in the location before deleting');

         return redirect()->back();
      }
   }

}
