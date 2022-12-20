<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\finance\suppliers\supplier_address;
use App\Models\finance\suppliers\suppliers;
use Livewire\Component;
use Helper;
use Auth;

class AddSupplier extends Component
{
   public $supplier_name,$email,$phone_number;

   public function render()
   {
      return view('livewire.assets.assets.add-supplier');
   }

   //rest files
   public function restFields(){
      $this->name= "";
   }

   //save
   public function save_supplier(){
      $this->validate([
         'supplier_name' => 'required',
      ]);

      $supplierCode = Helper::generateRandomString(20);

		$supplier = new suppliers;
		$supplier->business_code        = Auth::user()->business_code;
      $supplier->supplier_name        = $this->supplier_name;
		$supplier->primary_phone_number = $this->phone_number;
      $supplier->email                = $this->email;
      $supplier->supplier_code        = $supplierCode;
      $supplier->created_by           = Auth::user()->user_code;
      $supplier->save();

      $address = new supplier_address;
		$address->supplier_code = $supplierCode;
      $address->business_code = Auth::user()->business_code;
      $address->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Supplier added successfully'
      ]);

      $this->restFields();

      $this->emitTo('assets.assets.suppliers','refreshComponent');
      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }
}
