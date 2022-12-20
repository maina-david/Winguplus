<?php

namespace App\Http\Livewire\Crm\Leads\Events;

use App\Models\finance\customer\customers;
use App\Models\finance\customer\events;
use App\Models\wingu\wp_user;
use Livewire\Component;
use Auth;

class GridView extends Component
{
   protected $listeners = ['refreshComponent'=>'$refresh'];

   public $leadCode,$eventCode,$eventDetailCode;
   public $search,$date;
   public $perPage = 21;

   // public function updatingSearch()
   // {
   //    $this->resetPage();
   // }

   public function render()
   {
      $query = events::where('business_code', Auth::user()->business_code);
                     if($this->search){
                        $query->where('event_name','like','%'.$this->search.'%');
                     }
                     if($this->date){
                        $query->where('start_date',$this->date);
                     }
      $events = $query->where('customer_code',$this->leadCode)->orderby('id','desc')->paginate($this->perPage);

      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose employee');
      $code = $this->leadCode;

      return view('livewire.crm.leads.events.grid-view', compact('events','users','code'));
   }

   //edit
   public function edit($code){
      $this->eventCode = $code;
   }

   //details
   public function details($code){
      $this->eventDetailCode = $code;
   }
}
