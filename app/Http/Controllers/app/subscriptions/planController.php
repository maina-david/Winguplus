<?php

namespace App\Http\Controllers\app\subscriptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\products\product_tag;
use App\Models\finance\products\category;
use App\Models\wingu\file_manager;
use App\Models\finance\tax;
use App\Models\finance\products\product_inventory;
use Auth;
use Helper;
use Session;

class planController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
	}

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $plans = product_information::join('product_price','product_price.productID','=','product_information.id')
               ->join('business','business.id','=','product_information.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('product_information.parentID',$id)
               ->where('type','plan')
               ->where('product_information.businessID',Auth::user()->businessID)
               ->select('*','product_information.id as panelID','product_information.created_at as panel_date')
               ->get();
      $count = 1;
      $productID = $id;

      return view('app.subscriptions.plan.index', compact('productID','plans','product','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($id)
   {
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $taxes = tax::where('businessID',Auth::user()->businessID)->get();
      $productID = $id;
      return view('app.subscriptions.plan.create', compact('productID','product','taxes'));
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
         'price' => 'required',
         'billing_type' => 'required',
      ]);

      $check = product_information::where('product_name',$request->product_name)->count();
      $plan = new product_information;
      $plan->product_name = $request->product_name;
      if ($request->code_type == 'Auto') {
         $plan->sku_code = Helper::generateRandomString(9);
      }elseif($request->code_type == 'Custom'){
         $plan->sku_code = $request->sku_code;
      }
      $plan->type = 'plan';
      $plan->product_name = $request->product_name;
      $plan->parentID = $request->parentID;
      $plan->status = $request->status;
      $plan->bill_count = $request->bill_count;
      $plan->billing_period = $request->billing_period;
      $plan->billing_type = $request->billing_type;
      $plan->specified_bill_cycle = $request->specified_bill_cycle;
      $plan->trial_days = $request->trial_days;
      $plan->short_description = $request->short_description;
      $plan->description = $request->description;
      $plan->businessID = Auth::user()->businessID;
      $plan->created_by = Auth::user()->id;
      if ($check > 1) {
         $plan->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
      }else{
         $plan->url = Helper::seoUrl($request->product_name);
      }
      $plan->save();

      //product price
      $price = new product_price;
      $price->productID = $plan->id;
      $price->selling_price = $request->price;
      $price->setup_fee = $request->setup_fee;
      $price->taxID = $request->tax;
      $price->businessID = Auth::user()->businessID;
      $price->created_by = Auth::user()->id;
      $price->save();

      //product quantities
      $product_inventory = new product_inventory;
      $product_inventory->productID = $plan->id;
      $product_inventory->businessID = Auth::user()->businessID;
      $product_inventory->created_by = Auth::user()->id;
      $product_inventory->save();

      Session::flash('success','Plan successfully updated');

      return redirect()->route('subscriptions.plan.index',$request->parentID);

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
   public function edit($id,$pid)
   {
      $product = product_information::where('id',$pid)->where('businessID',Auth::user()->businessID)->first();
      $edit = product_information::join('product_price','product_price.productID','=','product_information.id')
            ->where('product_information.id',$id)
            ->where('parentID',$pid)
            ->where('product_information.businessID',Auth::user()->businessID)
            ->select('*','product_information.id as proID')
            ->first();
      $taxes = tax::where('businessID',Auth::user()->businessID)->get();
      $productID = $pid;
      return view('app.subscriptions.plan.edit', compact('productID','product','taxes','edit'));
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
      $this->validate($request, [
         'product_name' => 'required',
         'sku_code' => 'required',
         'selling_price' => 'required',
         'billing_type' => 'required',
      ]);

      $plan = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      if($plan->product_name != $request->product_name || $plan->url == ""){
         $check = product_information::where('product_name',$request->product_name)->count();
         if ($check > 1) {
            $plan->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
         }else{
            $plan->url = Helper::seoUrl($request->product_name);
         }
      }

      $plan->product_name = $request->product_name;
      $plan->sku_code = $request->sku_code;
      $plan->product_name = $request->product_name;
      $plan->status = $request->status;
      $plan->bill_count = $request->bill_count;
      $plan->billing_period = $request->billing_period;
      $plan->billing_type = $request->billing_type;
      $plan->specified_bill_cycle = $request->specified_bill_cycle;
      $plan->trial_days = $request->trial_days;
      $plan->short_description = $request->short_description;
      $plan->description = $request->description;
      $plan->businessID = Auth::user()->businessID;
      $plan->updated_by = Auth::user()->id;
      $plan->save();

      //product price
      $price = product_price::where('productID',$id)->where('businessID',Auth::user()->businessID)->first();
      $price->selling_price = $request->selling_price;
      $price->setup_fee = $request->setup_fee;
      $price->taxID = $request->tax;
      $price->businessID = Auth::user()->businessID;
      $price->updated_by = Auth::user()->id;
      $price->save();

      Session::flash('success','Plan successfully updated');

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
               $directory = base_path().'/public/businesses/'.Limitless::business(Auth::user()->businessID)->businessID.'/finance/products/';
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

         Session::flash('success', 'Plan successfully deleted !');

         return redirect()->back();

      }else{
         Session::flash('error','You have recorded transactions for this product. Hence, this product cannot be deleted.');
         return redirect()->back();
      }
   }
}
