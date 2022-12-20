<?php

namespace App\Models\finance\customer;

use Illuminate\Database\Eloquent\Model;
use Auth;
class customers extends Model
{
   Protected $table = 'fn_customers';

   //single customer
   public static function single_customer($code){
      $customer = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                           ->where('fn_customers.customer_code',$code)
                           ->where('fn_customers.business_code',Auth::user()->business_code)
                           ->select('*','fn_customers.customer_code as customerCode','bill_country as countryID')
                           ->first();

      return $customer;
   }
}
