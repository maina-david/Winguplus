<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\types as AssetTypes;
use Livewire\Component;
use Auth;

class Types extends Component
{
   protected $listeners = ['refreshComponent'=>'render'];
   public $editType;

   public function render(){

      $types = AssetTypes::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('livewire.assets.assets.types', compact('types'));

   }
}
