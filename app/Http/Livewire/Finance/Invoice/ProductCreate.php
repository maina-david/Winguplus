<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use Livewire\Component;
use Auth;
use Helper;

class ProductCreate extends Component
{
   public $product_name,$price,$quantity,$type;

   public function render()
   {
      return view('livewire.finance.invoice.product-create');
   }

   //validation rules
   protected $rules = [
      'product_name' => 'required',
      'price' => 'required',
      'quantity' => 'required',
   ];

   //reset fiels
   public function restFields(){
      $this->product_name = "";
      $this->price = "";
      $this->quantity = "";
      $this->type = "";
   }

   //add income category
   public function AddProduct(){
      $this->validate();

      $productCode = Helper::generateRandomString(20);

      $check = product_information::where('product_name',$this->product_name)->where('business_code',Auth::user()->business_code)->count();
      $product = new product_information;
      $product->type = $this->type;
      $product->product_name = $this->product_name;
      $product->product_code = $productCode;
      $product->sku_code = Helper::generateRandomString(9);
      $product->business_code = Auth::user()->business_code;
      $product->created_by = Auth::user()->user_code;
      if($check > 1) {
         $product->url = Helper::seoUrl($this->product_name).'-'.Helper::generateRandomString(10);
      }else{
         $product->url = Helper::seoUrl($this->product_name);
      }
      $product->save();

      //product price
      $price = new product_price;
      $price->product_code = $productCode;
      $price->price_code = $productCode;
      $price->selling_price = $this->price;
      $price->default_price = 'Yes';
      $price->business_code = Auth::user()->business_code;
      $price->created_by = Auth::user()->user_code;
      $price->save();

      //product inventory
      $inventory = new product_inventory;
      $inventory->inventory_code = $productCode;
      $inventory->product_code = $productCode;
      $inventory->current_stock = $this->quantity;
      $inventory->default_inventory = 'Yes';
      $inventory->business_code = Auth::user()->business_code;
      $inventory->created_by = Auth::user()->user_code;
      $inventory->save();


      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Product added succesfully"
      ]);

      $this->restFields();

      $this->emit('refreshComponent');

      $this->emit('ModalStore');
   }
}
