<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Model;
use Auth;

class accounts extends Model
{
   Protected $table = 'fn_bank_accounts';

   public static function bank_accounts(){
      $accounts = accounts::where('business_code',Auth::user()->business_code)->get();
      return $accounts;
   }
}
