<?php
namespace App\Models\finance\payments;

use Illuminate\Database\Eloquent\Model;
use Auth;

class payment_methods extends Model
{
   Protected $table = 'fn_payment_methods';

   public static function methods(){
      $methods = payment_methods::where('business_code',Auth::user()->business_code)->get();
      return $methods;
   }

   public static function default(){
      $default = payment_methods::where('business_code',0)->get();
      return $default;
   }
}
