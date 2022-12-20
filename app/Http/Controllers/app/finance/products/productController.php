<?php
namespace App\Http\Controllers\app\finance\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\category;
use App\Models\wingu\file_manager;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\products\tags;
use App\Models\finance\products\attributes;
use App\Models\finance\products\product_tag;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\products\brand;
use App\Models\hr\branches;
use App\Models\finance\tax;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;
use Hr;

class productController extends Controller{
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
      return view('app.finance.products.index');
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $categories = category::where('business_code',Auth::user()->business_code)->pluck('name','category_code');
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                              ->pluck('supplier_name','supplier_code')
                              ->prepend('choose supplier','');
      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','name')->prepend('Choose brand','');

      return view('app.finance.products.create', compact('categories','suppliers','brands'));
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

      $productCode = Helper::generateRandomString(20);

      $check = product_information::where('product_name',$request->product_name)->where('business_code',Auth::user()->business_code)->count();
      $product = new product_information;
      $product->product_name = $request->product_name;
      $product->product_code = $productCode;
      if($request->code_type == 'Auto') {
         $product->sku_code = Helper::generateRandomString(9);
      }elseif($request->code_type == 'Custom'){
         $product->sku_code = $request->sku_code;
      }
      $product->brand = $request->brand;
      $product->type = $request->type;
      $product->supplier = $request->supplier;
      $product->pos_item = $request->pos_item;
      $product->active = $request->status;
      $product->ecommerce_item = $request->ecommerce_item;
      $product->tags = json_encode($request->tags);
      $product->business_code = Auth::user()->business_code;
      $product->created_by = Auth::user()->user_code;
      if($check > 1) {
         $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(10);
      }else{
         $product->url = Helper::seoUrl($request->product_name);
      }
      $product->save();

      //product price
      $product_price = new product_price;
      $product_price->product_code = $productCode;
      $product_price->default_price = 'Yes';
      $product_price->business_code = Auth::user()->business_code;
      $product_price->created_by = Auth::user()->user_code;
      $product_price->save();

      //product inventory
      $product_inventory = new product_inventory;
      $product_inventory->product_code = $productCode;
      $product_inventory->default_inventory = 'Yes';
      $product_inventory->business_code = Auth::user()->business_code;
      $product_inventory->created_by = Auth::user()->user_code;
      $product_inventory->save();

      //add category
      $category = count(collect($request->category));
         if($category > 0){
         //upload new category
         for($i=0; $i < count($request->category); $i++ ) {
            $cat = new product_category_product_information;
            $cat->product = $productCode;
            $cat->category = $request->category[$i];
            $cat->save();
         }
      }

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new product <a href="'.route('finance.products.details',$productCode).'">'.$request->product_name.'</a>';
		$module       = 'Finance';
		$section      = 'Products';
      $action       = 'Create';
		$activityCode = $productCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Item successfully added.');

      return redirect()->route('finance.products.edit', $productCode);
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function details($code)
   {
      $details = product_information::join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                                    ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                    ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                                    ->where('fn_product_information.product_code',$code)
                                    ->where('fn_product_information.business_code', Auth::user()->business_code)
                                    ->select('*','fn_product_information.product_code as productCode','fn_product_information.created_by as creator')
                                    ->orderBy('fn_product_information.product_code','desc')
                                    ->first();

      return view('app.finance.products.details.show', compact('details'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($productCode)
   {
      $product = product_information::where('fn_product_information.product_code',$productCode)
                                    ->where('fn_product_information.business_code',Auth::user()->business_code)
                                    ->select('*','fn_product_information.product_code as product_code')
                                    ->first();

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','name')->prepend('Choose brand','');

      //category
      $categories = category::where('business_code',Auth::user()->business_code)->pluck('name','category_code');

      //join category
      $getJoint = product_category_product_information::join('fn_product_category','fn_product_category.category_code','=','fn_product_category_product_information.category')->where('product',$productCode)->select('category_code')->get();
      $jointCategories = array();
      foreach($getJoint as $cj){
         $jointCategories[] = $cj->category_code;
      }

      return view('app.finance.products.edit', compact('product','categories','productCode','suppliers','brands','jointCategories'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $productCode)
   {
      $this->validate($request, [
         'product_name' => 'required',
      ]);

      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();

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
      $product->brand = $request->brand;
      $product->supplier = $request->supplier;
      $product->pos_item = $request->pos_item;
      $product->active = $request->status;
      $product->ecommerce_item = $request->ecommerce_item;
      $product->type = $request->type;
      $product->tags = json_encode($request->tags);
      $product->business_code = Auth::user()->business_code;
      $product->updated_by = Auth::user()->user_code;
      $product->save();

      $category = count(collect($request->category));
      //update category
         if($category > 0){
         //delete existing category
         product_category_product_information::where('product',$productCode)->delete();

         //upload new category
         for($i=0; $i < count($request->category); $i++ ) {
            $cat = new product_category_product_information;
            $cat->product = $productCode;
            $cat->category = $request->category[$i];
            $cat->save();
         }
      }

      //recorded activity
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>updated</b> <a href="'.route('finance.products.details',$productCode).'">'.$request->product_name.' product</a>';
		$module       = 'Finance';
		$section      = 'Products';
      $action       = 'Create';
		$activityCode = $productCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Item successfully updated !');

      return redirect()->back();
   }


   /**
    * product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description($productCode){
      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();

      return view('app.finance.products.description', compact('product','productCode'));
   }


   /**
   * update product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description_update(Request $request,$productCode){

      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $product->short_description = $request->short_description;
      $product->description = $request->description;
      $product->business_code = Auth::user()->business_code;
      $product->updated_by = Auth::user()->user_code;
      $product->save();

      Session::flash('success','Item description updated successfully');

      return redirect()->back();
   }


   /**
 * product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price($productCode)
   {
      $mainBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->first();
      $product = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $defaultPrice = product_price::where('product_code',$productCode)->where('business_code', Auth::user()->business_code)->where('default_price','Yes')->first();
      $prices = product_price::where('product_code',$productCode)->where('business_code', Auth::user()->business_code)->get();

      $outlets = branches::where('business_code',Auth::user()->business_code)->get();

      return view('app.finance.products.price', compact('prices','productCode','product','outlets','defaultPrice','mainBranch'));
   }


   /**
   * Update product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price_update(Request $request,$id)
   {
      $this->validate($request, array(
         'selling_price' =>'required',
         'product_code'  =>'required'
      ));

      $price = product_price::where('id',$id)
                           ->where('product_code',$request->product_code)
                           ->where('business_code',Auth::user()->business_code)
                           ->first();
      $price->buying_price = $request->buying_price;
      $price->selling_price = $request->selling_price;
      $price->offer_price = $request->offer_price;
      $price->save();

      Session::flash('success','Price updated');

      return redirect()->back();
   }


   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($code)
   {
      //check product in invoice
      $invoice = invoice_products::where('product_code',$code)->count();
      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('file_code',$code)->where('business_code', Auth::user()->business_code)->count();

         if($check_image > 0){
            //directory
            $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/products/';
            $images = file_manager::where('file_code',$code)->where('business_code', Auth::user()->business_code)->get();
            foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
            }
         }

         product_information::where('product_code',$code)->where('business_code', Auth::user()->business_code)->delete();
         product_inventory::where('product_code',$code)->where('business_code', Auth::user()->business_code)->delete();

         //delete categories
         product_category_product_information::where('product',$code)->delete();

         //delete price
         product_price::where('product_code',$code)->where('business_code',Auth::user()->business_code)->delete();

         Session::flash('success', 'The Item was successfully deleted !');

         return redirect()->back();

      }else{
         Session::flash('error','You have recorded transactions for this product. Hence, this product cannot be deleted.');
         return redirect()->back();
      }
   }

   /**
   * get product price via ajax
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function productPrice(Request $request){
		return json_encode(product_price::where('product_code', $request->product)->first());
   }

   public function express_list(Request $request)
   {
      $accounts = product_information::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'product_name as text']);
      return ['results' => $accounts];
   }

   /**
   * Category
   *
   */
   public function category(){
      return view('app.finance.products.categories');
   }
}
