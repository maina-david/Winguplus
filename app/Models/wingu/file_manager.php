<?php

namespace App\Models\wingu;

use Illuminate\Database\Eloquent\Model;
use Auth;

class file_manager extends Model
{
   Protected $table = 'wp_file_manager';

   public static function media($code){
      $media = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();
      return $media;
   }
}
