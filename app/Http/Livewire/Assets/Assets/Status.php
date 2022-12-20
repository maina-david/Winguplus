<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\status as AssetStatus;
use Livewire\Component;
use Auth;

class Status extends Component
{
   protected $listeners = ['refreshComponent'=>'render'];

   public function render()
   {
      $statuses = AssetStatus::where('business_code',Auth::user()->business_code)
                           ->orderby('id','desc')
                           ->pluck('title','status_code')
                           ->prepend('choose status label','');

      return view('livewire.assets.assets.status', compact('statuses'));
   }
}
