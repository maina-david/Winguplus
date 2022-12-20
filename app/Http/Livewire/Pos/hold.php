<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\finance\products\product_information;
use App\Models\finance\customer\customers;
use App\Models\finance\pos\cart;
use App\Models\finance\tax;
use Livewire\WithPagination;
use Auth;
use Wingu;
use Session;

class terminal extends Component
{
   use WithPagination;
   public $perPage = 30;
   public $search = '';
   public $amountReceived;
   public $discount = 0;


   // public function mount(){
   //    $this->cartItems = cart::where('created_by',Auth::user()->user_code)
   //                            ->where('business_code',Auth::user()->business_code)
   //                            ->orderby('fn_pos_cart.id','desc')
   //                            ->get();
   // }

   public function render()
   {
      $query =  product_information::join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                                    ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                    ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code');
                                    if($this->search){
                                       $query->Where('sku_code','like','%'.$this->search.'%')
                                       ->orWhere('product_name','like','%'.$this->search.'%');
                                    }
      $products = $query->where('type','product')
                        ->whereNull('parent_product')
                        ->where('default_inventory','Yes')
                        ->where('default_price','Yes')
                        ->where('pos_item','Yes')
                        ->where('fn_product_information.business_code', Auth::user()->business_code)
                        ->select('fn_product_information.product_code as proID','product_name','wp_business.currency as symbol','type','track_inventory','selling_price','same_price','fn_product_information.business_code as business_code','pos_item','offer_price')
                        ->simplePaginate($this->perPage);

      $clients = customers::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
      $taxes = tax::where('business_code',Auth::user()->business_code)->get();
      $amountReceived = $this->amountReceived;
      $discount = $this->discount;
      $currency = Wingu::business()->currency;

      $cartItems = cart::where('created_by',Auth::user()->user_code)
                     ->where('business_code',Auth::user()->business_code)
                     ->orderby('fn_pos_cart.id','desc')
                     ->get();

      return view('livewire.pos.terminal', compact('products','clients','taxes','amountReceived','discount','currency','cartItems'));
   }

   //add to cart
   public function addToCart($code){
      //check if product is in cart
      $checkProduct = cart::where('product_code',$code)
                           ->where('created_by',Auth::user()->user_code)
                           ->where('business_code',Auth::user()->business_code)
                           ->count();

      if($checkProduct == 1){
         $cart = cart::where('product_code',$code)
                     ->where('business_code',Auth::user()->business_code)
                     ->where('created_by',Auth::user()->user_code)
                     ->first();

         $newQty = $cart->qty + 1;
         $cart->qty = $newQty;
         $cart->amount = $newQty * $cart->price;
         $cart->total_amount = $newQty * $cart->price;
         $cart->save();
         $this->mount();

         Session::flash('success','Product Added Successfully');
      }else{
         $product = product_information::join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                                       ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                                       ->where('fn_product_information.business_code', Auth::user()->business_code)
                                       ->where('fn_product_information.product_code',$code)
                                       // ->where('type','product')
                                       // ->orwhere('type','variants')
                                       ->where('pos_item','Yes')
                                       ->select('fn_product_information.product_code as product_code','product_name','selling_price','offer_price')
                                       ->first();

         if($product->offer_price > 0){
            $price = $product->offer_price;
         }else{
            $price = $product->selling_price;
         }

         $add_to_cart = new cart;
         $add_to_cart->product_code = $product->product_code;
         $add_to_cart->product_name = $product->product_name;
         $add_to_cart->qty = 1;
         $add_to_cart->price        = $price;
         $add_to_cart->amount       = $price;
         $add_to_cart->total_amount = $price;
         $add_to_cart->created_by = Auth::user()->user_code;
         $add_to_cart->business_code = Auth::user()->business_code;
         $add_to_cart->session_id = Session::getId();
         $add_to_cart->save();

         // $this->cartItems->prepend($add_to_cart);

         Session::flash('success','Product Added Successfully');
      }
   }
}

