<?php

namespace App\Models\finance\creditnote;

use Illuminate\Database\Eloquent\Model;
use Auth;

class creditnote extends Model
{
   Protected $table = 'fn_creditnote';

   public function totalProduct( $qty, $price){
      $price = $qty * $price;
      return $price;
   }

   public function total($qty, $price){

		$total = 0;

		foreach ($qty as $k => $q)
		{
			$total += $this->totalProduct($qty[$k], $price[$k]);
		}

		$amount =  abs($total);

		return $amount;
	}

   public function amount($qty, $price){
		$total 	 = 0;
		$sum = 0;

		foreach ($qty as $k => $q)
		{
			$sum += $this->totalProduct($qty[$k], $price[$k]);
		}

		return $sum;
	}

   public static function credit_note_details($code){
      $details = creditnote::join('wp_business','wp_business.business_code','=','fn_creditnote.business_code')
                           ->join('fn_customers','fn_customers.customer_code','=','fn_creditnote.customer_code')
                           ->join('fn_customer_address','fn_customer_address.customer_code','=','fn_creditnote.customer_code')
                           ->join('fn_creditnote_settings','fn_creditnote_settings.business_code','=','wp_business.business_code')
                           ->join('wp_status','wp_status.id','=','fn_creditnote.status')
                           ->where('fn_creditnote.business_code',Auth::user()->business_code)
                           ->where('fn_creditnote.creditnote_code',$code)
                           ->select('*','wp_status.name as statusName','wp_business.name as businessName','wp_business.website as business_website','wp_business.business_code as business_code','fn_customers.customer_code as customer_code','fn_creditnote.status as statusID','wp_business.currency as currency','fn_customers.email as customer_email','wp_business.email as business_email','fn_creditnote.prefix as credit_note_prefix','fn_creditnote.number as credit_note_number')
                           ->first();
      return $details;
   }

}
