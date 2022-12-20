<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\hr\department;
use Livewire\Component;
use Auth;

class Departments extends Component
{
   protected $listeners = ['refreshComponent'=>'render'];

   public function render()
   {
      $departments = department::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.assets.assets.departments', compact('departments'));
   }
}
