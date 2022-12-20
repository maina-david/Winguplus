<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\finance\suppliers\suppliers as SuppliersSuppliers;
use Livewire\Component;
use Auth;

class Suppliers extends Component
{

   protected $listeners = ['refreshComponent'=>'render'];

   public function render()
   {
      $suppliers = SuppliersSuppliers::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('supplier_name','supplier_code')
                           ->prepend('choose supplier','');

      return view('livewire.assets.assets.suppliers', compact('suppliers'));
   }
}
