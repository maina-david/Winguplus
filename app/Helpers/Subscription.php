<?php
namespace App\Helpers;
use App\Models\finance\products\product_information;
use App\Models\subscriptions\subscriptions;
use Auth;
class Subscription
{
   public function __construct(){
		$this->middleware('auth');
   }

   //count plan per products
   public static function count_plans_per_product($id){
      $count = product_information::where('parentID',$id)->where('type','plan')->where('businessID',Auth::user()->businessID)->count();
      return $count;
   }

   //count subscription
   public static function count_subscriptions(){
      $count = subscriptions::where('businessID',Auth::user()->businessID)->count();
      return $count;
   }

}
