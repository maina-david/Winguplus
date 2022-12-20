<?php

namespace App\Http\Controllers\app\pos;
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
class itemsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Pos Items
   **/
   public function index(){
      return view('app.pos.items.index');
   }

   /**
   * Add Pos Items
   **/
   public function create(){
      $categories = category::where('businessID',Auth::user()->businessID)->pluck('name','id');
      $attributes = attributes::where('businessID',Auth::user()->businessID)
                           ->where('parentID',0)
                           ->pluck('name','id')
                           ->prepend('','Choose attribute');
      $tags = tags::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->pluck('name','id');
      $suppliers = suppliers::where('businessID',Auth::user()->businessID)
               ->pluck('supplierName','id')
               ->prepend('choose supplier','');
      $brands = brand::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose brand','');
      
      return view('app.pos.items.create', compact('categories','tags','suppliers','brands','attributes'));
   }
}
