<?php

namespace App\Models\finance\customer;
use Illuminate\Database\Eloquent\Model;
use Auth;

class contact_persons extends Model
{
   Protected $table = 'fn_customer_contact_persons';

   public static function customer_contact_persons($code){
      $persons = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();
      return $persons;
   }
}
