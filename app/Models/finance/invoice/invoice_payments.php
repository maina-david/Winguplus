<?php

namespace App\Models\finance\invoice;

use Illuminate\Database\Eloquent\Model;
use Auth;

class invoice_payments extends Model
{
   Protected $table = 'fn_invoice_payments';

   public static function invoice_payments($code){
      $payments = invoice_payments::where('invoice_code',$code)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->get();

      return $payments;
   }
}
