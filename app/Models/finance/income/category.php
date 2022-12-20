<?php

namespace App\Models\finance\income;

use Illuminate\Database\Eloquent\Model;
use Auth;

class category extends Model{

   Protected $table = 'fn_income_category';

   //get income category
   public static function income_category(){
      $category = category::where('business_code',Auth::user()->business_code)->get();
      return $category;
   }
}
