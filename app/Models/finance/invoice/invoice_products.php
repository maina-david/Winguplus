<?php

namespace App\Models\finance\invoice;

use Illuminate\Database\Eloquent\Model;
use Auth;

class invoice_products extends Model{

   Protected $table = 'fn_invoice_products';

   //invoice products
   public static function invoice_products($code){
      $products = invoice_products::where('invoice_code',$code)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->get();
      return $products;
   }
}
