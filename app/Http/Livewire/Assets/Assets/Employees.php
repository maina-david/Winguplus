<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\hr\employees as HrEmployees;
use Livewire\Component;
use Auth;

class Employees extends Component
{
   protected $listeners = ['refreshComponent'=>'render'];

   public function render()
   {
      $employees = HrEmployees::where('business_code',Auth::user()->business_code)->orderby('id','desc')->pluck('names','employee_code')->prepend('choose employee','');

      return view('livewire.assets.assets.employees', compact('employees'));
   }
}
