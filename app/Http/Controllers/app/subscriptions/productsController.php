<?php
namespace App\Http\Controllers\app\subscriptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\products\product_tag;
use App\Models\finance\products\category;
use App\Models\wingu\file_manager;
use Auth;
use Wingu;
use Helper;
use Session;
use File;
class productsController extends Controller
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
      $products = product_information::where('product_information.businessID', Auth::user()->businessID)
      ->where('type','subscription')
      ->orderBy('id','desc')
      ->get();
      $count = 1;
      return view('app.subscriptions.products.index', compact('products','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('app.subscriptions.products.create');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'product_name' => 'required',
         'code_type' => 'required',
      ]);

      $check = product_information::where('product_name',$request->product_name)->count();
      $product = new product_information;
      $product->product_name = $request->product_name;
      if ($request->code_type == 'Auto') {
         $product->sku_code = Helper::generateRandomString(9);
      }elseif($request->code_type == 'Custom'){
         $product->sku_code = $request->sku_code;
      }
      $product->type = 'subscription';
      $product->notification_email = $request->notification_email;
      $product->short_description = $request->short_description;
      $product->description = $request->description;
      $product->status = $request->status;
      $product->businessID = Auth::user()->businessID;
      $product->created_by = Auth::user()->id;
      if ($check > 1) {
         $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
      }else{
         $product->url = Helper::seoUrl($request->product_name);
      }
      $product->save();

      //product price
      $product_price = new product_price;
      $product_price->productID = $product->id;
      $product_price->businessID = Auth::user()->businessID;
      $product_price->created_by = Auth::user()->id;
      $product_price->save();

      //product quantities
      $product_inventory = new product_inventory;
      $product_inventory->productID = $product->id;
      $product_inventory->businessID = Auth::user()->businessID;
      $product_inventory->created_by = Auth::user()->id;
      $product_inventory->save();

      Session::flash('success','Product successfully added.');

      return redirect()->route('subscriptions.products.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      return view('app.subscriptions.products.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $product = product_information::where('product_information.id',$id)
               ->where('product_information.businessID',Auth::user()->businessID)
               ->first();

      $productID = $id;

      return view('app.subscriptions.products.edit', compact('product','productID'));
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
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      if($product->product_name != $request->product_name || $product->url == ""){
         $check = product_information::where('product_name',$request->product_name)->count();
         if ($check > 1) {
            $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
         }else{
            $product->url = Helper::seoUrl($request->product_name);
         }
      }

      $product->product_name = $request->product_name;
      $product->sku_code = $request->sku_code;
      $product->status = $request->status;
      $product->short_description = $request->short_description;
      $product->notification_email = $request->notification_email;
      $product->description = $request->description;
      $product->businessID = Auth::user()->businessID;
      $product->updated_by = Auth::user()->id;
      $product->save();

      Session::flash('success','Product updated successfully');

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
      //check product in invoice
      $invoice = invoice_products::where('productID',$id)->count();

      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('fileID',$id)->where('businessID', Auth::user()->businessID)->where('folder','products')->count();

         if($check_image > 0){
               //directory
               $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/products/';
               $images = file_manager::where('fileID',$id)->where('businessID', Auth::user()->businessID)->where('folder','products')->get();
               foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
               }
         }

         $product = product_information::where('id', $id)->where('businessID', Auth::user()->businessID)->delete();
         $inventory = product_inventory::where('productID', $id)->where('businessID', Auth::user()->businessID)->delete();
         //delete categories
         $categories = product_category_product_information::where('productID',$id)->get();
         foreach($categories as $category){
               $del_link = product_category_product_information::find($category->id)->delete();
         }

         //delete tags
         $tags = product_tag::where('product_id',$id)->get();
         foreach($tags as $tag){
               $del_link = product_tag::find($tag->id)->delete();
         }

         //delete price
         $price = product_price::where('productID', $id)->where('businessID', Auth::user()->businessID)->delete();

         //////////////////////////////////////////////////////// delete plan //////////////////////////////////////////////////////////////////////
         $plans = product_information::where('parentID',$id)->where('businessID',Auth::user()->businessID)->get();
         foreach($plans as $plan){
            $plan = product_information::where('id',$plan->id)->where('parentID',$id)->where('businessID',Auth::user()->businessID)->first();
            //delete image from folder/directory
            $check_image = file_manager::where('fileID',$plan->id)->where('businessID', Auth::user()->businessID)->where('folder','products')->count();

            if($check_image > 0){
                  //directory
                  $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/products/';
                  $images = file_manager::where('fileID',$id)->where('businessID', Auth::user()->businessID)->where('folder','products')->get();
                  foreach($images as $image){
                  if (File::exists($directory)) {
                     unlink($directory.$image->file_name);
                  }
                  $image->delete();
                  }
            }

            $product = product_information::where('id', $plan->id)->where('businessID', Auth::user()->businessID)->delete();
            $inventory = product_inventory::where('productID', $plan->id)->where('businessID', Auth::user()->businessID)->delete();
            //delete categories
            $categories = product_category_product_information::where('productID',$plan->id)->get();
            foreach($categories as $category){
               $del_link = product_category_product_information::find($category->id)->delete();
            }

            //delete tags
            $tags = product_tag::where('product_id',$plan->id)->get();
            foreach($tags as $tag){
               $del_link = product_tag::find($tag->id)->delete();
            }

            //delete price
            $price = product_price::where('productID',$plan->id)->where('businessID', Auth::user()->businessID)->delete();
         }

         Session::flash('success', 'Product successfully deleted !');

         return redirect()->back();

      }else{
         Session::flash('error','You have recorded transactions for this product. Hence, this product cannot be deleted.');
         return redirect()->back();
      }
   }
}
