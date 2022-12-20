<?php

namespace App\Models\finance\lpo;

use Illuminate\Database\Eloquent\Model;

class lpo extends Model
{
   Protected $table = 'fn_purchaseorders';

   public function totalProduct( $qty, $price){
      $price = $qty * $price;
      return $price;
   }

   public function total($qty, $price){
		$sum = 0;

		foreach ($qty as $k => $q)
		{
			$sum += $this->totalProduct($qty[$k], $price[$k]);
		}

		return  abs($sum);
	}
}
