<?php

namespace App\Models\finance\customer;

use Illuminate\Database\Eloquent\Model;
use Auth;
class address extends Model
{
   Protected $table = 'fn_customer_address';

   //fix customer field
   public static function customer_address_fix($code){
      $checkAddress = address::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->count();
      if($checkAddress == 0){
         $address = new address;
         $address->customer_code = $code;
         $address->business_code = Auth::user()->business_code;
         $address->save();
      }
   }
}
