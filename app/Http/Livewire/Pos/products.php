<?php

namespace App\Http\Livewire\Pos;
use App\Models\finance\products\product_information;
use Livewire\Component;
use Auth;

class products extends Component
{
   public $perPage = 25;
   public $search = '';

   public function render()
   {
      $query =  product_information::join('wp_business','wp_business.business_code','=','fn_product_information.business_code')
                        ->join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
                        ->join('fn_product_price','fn_product_price.product_code','=','fn_product_information.product_code');
                        if($this->search){
                           $query->where('sku_code','like','%'.$this->search.'%')
                           ->orwhere('product_name','like','%'.$this->search.'%');
                        }
      $products = $query->where('default_inventory','Yes')
                        ->where('default_price','Yes')
                        ->where('pos_item','Yes')
                        ->where('wp_business.business_code',Auth::user()->business_code)
                        ->select('fn_product_information.product_code as productCode','fn_product_information.created_at as date','fn_product_price.selling_price as price','fn_product_information.product_name as product_name','wp_business.currency as symbol','fn_product_inventory.current_stock as stock','fn_product_information.type as type','fn_product_information.created_at as date','fn_product_information.business_code as businessCode','pos_item')
                        ->orderBy('fn_product_information.id','desc')
                        ->paginate($this->perPage);

      return view('livewire.pos.products', compact('products'));
   }

   // public function updatingSearch()
   // {
   //    $this->resetPage();
   // }
}
