<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\asset\assets as AssetAssets;
use App\Models\asset\status;
use App\Models\asset\types;
use Livewire\Component;
use Auth;

class Assets extends Component
{
   public $search,$asset_type,$status;

   public function render()
   {
      $query = AssetAssets::where('business_code',Auth::user()->business_code)
                           ->where('category','Asset');
                           if($this->search){
                              $query->where('asset_name','like','%'.$this->search.'%');
                           }
                           if($this->asset_type){
                              $query->where('asset_type',$this->asset_type);
                           }
                           if($this->status){
                              $query->where('status',$this->status);
                           }
      $assets = $query->orderby('id','desc')->get();

      $statuses = status::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $types = types::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.assets.assets.assets', compact('assets','statuses','types'));
   }

   //
}
