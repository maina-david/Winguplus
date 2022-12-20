<?php
namespace App\Helpers;
use App\Models\asset\assets;
use App\Models\asset\types;
use App\Models\asset\car_make;
use App\Models\asset\car_model;
use App\Models\asset\car_type;
use App\Models\asset\status;
use Auth;
class Asset
{
   //asset type
   public static function type($code){
      $type = types::where('type_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return $type;
   }

   //check asset type
   public static function check_type($code){
      $check = types::where('type_code',$code)->where('business_code',Auth::user()->business_code)->count();
      return $check;
   }

   //car model
   public static function car_model($id){
      $model = car_model::where('id',$id)->first();
      return $model;
   }

   //check car model
   public static function check_car_model($id){
      $check = car_model::where('id',$id)->count();
      return $check;
   }

   //check car type
   public static function check_car_type($id){
      $check = car_type::where('id',$id)->count();
      return $check;
   }

   //car type
   public static function car_type($id){
      $type = car_type::where('id',$id)->first();
      return $type;
   }

   //check car make
   public static function check_car_make($id){
      $check = car_make::where('id',$id)->count();
      return $check;
   }

   //car make
   public static function car_make($id){
      $make = car_make::where('id',$id)->first();
      return $make;
   }

   //calculate assets
   public static function count_assets(){
      $count = assets::where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   //asset label
   public function label($code){
      $status = status::where('status_code',$code)->where('business_code',Auth::user()->business_code)->first();
      return $status;
   }


}
