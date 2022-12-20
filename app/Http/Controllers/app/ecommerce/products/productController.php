<?php
namespace App\Http\Controllers\app\ecommerce\products;
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
use App\Models\finance\products\product_tag;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\products\brand;
use App\Models\hr\branches;
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
      $products =  product_information::join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                           ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                           ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                           ->whereNull('parent_product')
                           ->where('default_inventory','Yes')
                           ->where('default_price','Yes')
                           ->where('ecommerce_item','Yes')
                           ->where('fn_product_information.business_code', Auth::user()->business_code)
                           ->select('fn_product_information.product_code as proID','fn_product_information.created_at as date','fn_product_price.selling_price as price','fn_product_information.product_name as product_name','fn_product_inventory.current_stock as stock','fn_product_information.type as type','fn_product_information.created_at as date','fn_product_information.business_code as business_code','currency')
                           ->orderBy('fn_product_information.id','desc')
                           ->get();

      return view('app.ecommerce.products.index', compact('products'));
   }

   /**
 * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $categories = category::where('business_code',Auth::user()->business_code)->where('wingu_store','Yes')->pluck('name','category_code');

      $tags = tags::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->pluck('name','name');
      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose brand','');

      return view('app.ecommerce.products.create', compact('categories','tags','suppliers','brands'));
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
      $product->ecommerce_item = 'Yes';
      $product->type = $request->type;
      $product->supplier = $request->supplier;
      $product->pos_item = $request->pos_item;
      $product->active = $request->status;
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
		$activity     = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new product <a href="'.route('ecommerce.products.details',$productCode).'">'.$request->product_name.'</a>';
		$module       = 'E-commerce';
		$section      = 'Products';
      $action       = 'Create';
		$activityCode = $productCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Product successfully added.');

      return redirect()->route('ecommerce.products.description',$productCode);
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function details($id)
   {
      $details = product_information::join('wp_business','wp_business.id','=','fn_product_information.business_code')
                     ->join('currency','currency.id','=','wp_business.base_currency')
                     ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                     ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                     ->whereNull('parent_product')
                     ->where('fn_product_information.product_code',$id)
                     ->where('fn_product_information.business_code', Auth::user()->business_code)
                     ->select('*','fn_product_information.product_code as proID','fn_product_information.created_by as creator')
                     ->orderBy('fn_product_information.product_code','desc')
                     ->first();

      return view('app.ecommerce.products.details.show', compact('details'));
   }

   /**
 * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
      $productCode = $code;

      $product = product_information::where('fn_product_information.product_code',$productCode)
                                    ->where('fn_product_information.business_code',Auth::user()->business_code)
                                    ->select('*','fn_product_information.product_code as product_code')
                                    ->first();

      $jointTags = json_decode($product->tags);

      $tags = tags::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->pluck('name','name');

      $suppliers = suppliers::where('business_code',Auth::user()->business_code)
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      $brands = brand::where('business_code',Auth::user()->business_code)->pluck('name','name')->prepend('Choose brand','');

      //category
      $categories = category::where('business_code',Auth::user()->business_code)->where('wingu_store','Yes')->pluck('name','category_code');

      //join category
      $getJoint = product_category_product_information::join('fn_product_category','fn_product_category.category_code','=','fn_product_category_product_information.category')
                        ->where('product',$productCode)
                        ->where('wingu_store','Yes')
                        ->select('category_code')
                        ->get();

      $jointCategories = array();
      foreach($getJoint as $cj){
         $jointCategories[] = $cj->category_code;
      }

      return view('app.ecommerce.products.edit', compact('product','categories','tags','productCode','suppliers','brands','jointTags','jointCategories'));
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
      $product->ecommerce_item = 'Yes';
      $product->active         = $request->status;
      $product->type           = $request->type;
      $product->tags           = json_encode($request->tags);
      $product->business_code = Auth::user()->business_code;
      $product->updated_by    = Auth::user()->user_code;
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
      return view('app.ecommerce.products.description', compact('product','productCode'));
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

      return view('app.ecommerce.products.price', compact('prices','productCode','product','outlets','defaultPrice','mainBranch'));
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
         'selling_price'=>'required'
      ));

      $price = product_price::where('id',$id)
                           ->where('product_code',$request->product_code)
                           ->where('business_code',Auth::user()->business_code)
                           ->first();
      $price->buying_price = $request->buying_price;
      $price->selling_price = $request->selling_price;
      $price->offer_price = $request->offer_price;
      $price->save();

      session::flash('success','You have successfully edited item price!');

      return redirect()->back();
   }


   /**
 * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      //check product in invoice
      $invoice = invoice_products::where('product_code',$id)->count();

      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('fileID',$id)->where('business_code', Auth::user()->business_code)->where('folder','products')->count();

         if($check_image > 0){
               //directory
               $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->business_code)->primary_email.'/finance/products/';
               $images = file_manager::where('fileID',$id)->where('business_code', Auth::user()->business_code)->where('folder','products')->get();
               foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
               }
         }

         product_information::where('id', $id)->where('business_code', Auth::user()->business_code)->delete();
         product_inventory::where('product_code', $id)->where('business_code', Auth::user()->business_code)->delete();
         //delete categories
         $categories = product_category_product_information::where('product_code',$id)->get();
         foreach($categories as $category){
            product_category_product_information::find($category->id)->delete();
         }

         //delete tags
         $tags = product_tag::where('product_id',$id)->get();
         foreach($tags as $tag){
            product_tag::find($tag->id)->delete();
         }

         //delete price
         product_price::where('product_code', $id)->where('business_code', Auth::user()->business_code)->delete();

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

   public function express_store(Request $request){
      $primary = new customers;
		$primary->customer_name = $request->customer_name;
      $primary->business_code = Auth::user()->business_code;
      $primary->created_by = Auth::user()->user_code;
		$primary->save();

		$address = new address;
		$address->customerID = $primary->id;
		$address->save();

   }

   public function express_list(Request $request)
   {
      $accounts = product_information::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'product_name as text']);
      return ['results' => $accounts];
   }
}
