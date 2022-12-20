<?php

namespace App\Http\Livewire\Wingu;

use App\Mail\systemMail;
use App\Models\wingu\business_modules;
use App\Models\wingu\Cart;
use App\Models\wingu\control\invoice_settings;
use App\Models\wingu\control\invoices;
use App\Models\wingu\modules;
use Livewire\Component;
use Wingu;
use Auth;
use Mail;

class Apps extends Component
{
   public $cartID;

   public function render()
   {
      
      $applications = modules::where('status',15)->get();

      $cart = Cart::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.wingu.apps', compact('applications','cart'));
   }

   //add to cart
   public function add_to_cart($code){
      $checkCart = Cart::where('module_code',$code)->where('business_code',Auth::user()->business_code)->count();
      if($checkCart == 0){
         $applications = modules::where('module_code',$code)->first();

         $add = new Cart;
         $add->module_code   = $code;
         $add->module_name   = $applications->name;
         $add->description   = $applications->caption;
         $add->qty           = 1;
         $add->price         = $applications->price;
         $add->total_amount  = $applications->price;
         $add->business_code = Auth::user()->business_code;
         $add->created_by    = Auth::user()->user_code;
         $add->save();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Application successfully added"
         ]);

      }else{

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"This application is already on your selected list"
         ]);
      }
   }

   //confirm remove
   public function confirm_remove($id){
      $this->cartID = $id;
   }

   //remove
   public function remove_cart(){
      Cart::where('id',$this->cartID)->where('business_code',Auth::user()->business_code)->where('created_by',Auth::user()->user_code)->delete();

      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Application successfully removed"
      ]);

      $this->emit('popModal');
   }

   //close
   public function close(){
      $this->cartID = "";
      $this->emit('popModal');
   }

}
