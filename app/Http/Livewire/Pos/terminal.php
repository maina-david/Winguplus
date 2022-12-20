<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\finance\products\product_information;
use App\Models\finance\customer\customers;
use App\Models\finance\pos\cart;
use App\Models\finance\tax;
use Livewire\WithPagination;
use Auth;
use Wingu;
use Session;

class terminal extends Component
{
   use WithPagination;
   public $perPage = 30;
   public $search = '';
   public $amountReceived;
   public $discount = 0;


   // public function mount(){
   //    $this->cartItems = cart::where('created_by',Auth::user()->user_code)
   //                            ->where('business_code',Auth::user()->business_code)
   //                            ->orderby('fn_pos_cart.id','desc')
   //                            ->get();
   // }

   public function render()
   {
      return view('livewire.pos.terminal');
   }

   //add to cart
   public function addToCart($code){

   }
}

