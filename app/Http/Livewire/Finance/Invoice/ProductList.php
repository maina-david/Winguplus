<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use Livewire\Component;
use Auth;
use Helper;

class ProductList extends Component
{

   protected $listeners = ['refreshComponent'=>'render'];
   public $editProduct;
   public $productCode;

   public function render()
   {
      $Itemproducts = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
											->where('fn_product_information.business_code',Auth::user()->business_code)
											->where('default_inventory','Yes')
											->OrderBy('fn_product_information.id','DESC')
											->select('*','fn_product_information.product_code as productCode')
											->get();

		$Itemservice = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
										->where('fn_product_information.type','service')
										->where('default_inventory','Yes')
										->where('fn_product_information.business_code',Auth::user()->business_code)
										->OrderBy('fn_product_information.id','DESC')
										->select('*','fn_product_information.product_code as productCode')
										->get();

      return view('livewire.finance.invoice.product-list', compact('Itemproducts','Itemservice'));
   }

}
