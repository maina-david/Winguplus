<?php

namespace App\Http\Livewire\Propertywingu\Tenants;

use App\Models\property\tenants\tenants;
use Livewire\Component;
use Auth;

class Index extends Component
{
   public $search = '';
   public $perPage = 10;

   public function render(){
      $perPage = $this->perPage;
      $tenants = tenants::search($this->search)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->paginate($perPage);

      return view('livewire.propertywingu.tenants.index', compact('tenants'));
   }
}
