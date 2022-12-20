<?php

namespace App\Http\Livewire\Finance\Suppliers;

use App\Models\finance\suppliers\suppliers as SuppliersSuppliers;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;

class Suppliers extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $search;
   public $perPage = 20;

   public function render()
   {
      $query = SuppliersSuppliers::join('wp_business','wp_business.business_code','=','fn_suppliers.business_code')
							->where('fn_suppliers.business_code',Auth::user()->business_code);
                     if($this->search){
                        $query->where('supplier_name','like','%'.$this->search.'%');
                     }
      $suppliers = $query->select('*','fn_suppliers.supplier_code as supplierCode','wp_business.business_code as business_code','fn_suppliers.email as email','fn_suppliers.created_at as created_at')
							->OrderBy('fn_suppliers.id','DESC')
							->simplePaginate($this->perPage);

      return view('livewire.finance.suppliers.suppliers', compact('suppliers'));
   }
}
