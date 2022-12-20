<?php

namespace App\Http\Livewire\Salesflow\Products;

use App\Models\finance\products\product_information;
use Livewire\Component;
use Auth;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $perPage = 25;
   public $search = '';

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {

      $query =  product_information::whereNull('parent_product');
                  if($this->search){
                     $query->Where('sku_code','like','%'.$this->search.'%')
                     ->orWhere('product_name','like','%'.$this->search.'%');
                  }
      $products = $query->where('default_inventory','Yes')
                     ->where('default_price','Yes')
                     ->where('type','product')
                     ->where('fn_product_information.business_code', Auth::user()->business_code)
                     ->join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                     ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                     ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code')
                     ->where('type','!=','subscription')
                     ->select('fn_product_information.product_code as productCode','fn_product_information.created_at as date','fn_product_price.selling_price as price','fn_product_information.product_name as product_name','fn_product_inventory.current_stock as stock','fn_product_information.type as type','fn_product_information.created_at as date','fn_product_information.business_code as businessID','currency','sku_code')
                     ->orderby('fn_product_information.id','desc')
                     ->simplePaginate($this->perPage);

      return view('livewire.salesflow.products.index', compact('products'));
   }
}
