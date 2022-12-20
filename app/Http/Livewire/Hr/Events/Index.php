<?php

namespace App\Http\Livewire\Hr\Events;

use App\Models\hr\events;
use Livewire\Component;
use Auth;

class Index extends Component
{
   public function render()
   {
      $events = events::where('business_code',Auth::user()->business_code)->orderby('start_date','desc')->get();

      return view('livewire.hr.events.index', compact('events'));
   }
}
