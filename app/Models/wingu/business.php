<?php

namespace App\Models\wingu;

use Illuminate\Database\Eloquent\Model;
use Auth;

class business extends Model
{
   Protected $table = 'wp_business';

   //business details
   public static function business_info(){
      $business = business::where('business_code',Auth::user()->business_code)->first();
      return $business;
   }
}
