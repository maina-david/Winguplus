<?php
namespace App\Helpers;
use App\Models\ecommerce\settings;
use Auth;
use Session;

class ecommerce
{
   public function __construct(){
      $this->middleware('auth');
	}

   //====================================== ecommerce settings =======================================
	//=============================================================================================---->
	public static function get_ecommerce_details(){
		$settings = settings::where('business_code',Auth::user()->business_code)->first();
		return $settings;
	}
}
