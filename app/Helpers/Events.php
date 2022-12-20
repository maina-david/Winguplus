<?php
namespace App\Helpers;

use App\Models\finance\invoice\invoice_products;
use App\Models\events\schedule;
use Auth;

class Events
{
   //========================================== schedule  =============================================
	//=============================================================================================---->
   //get schedule session
   public function get_schedule_sessions($scheduleCode){

      $sessions = schedule::where('parent',$scheduleCode)->where('business_code',Auth::user()->business_code)->get();

      return response()->json([
         "session" => $sessions,
         "count"   => $sessions->count(),
      ]);
   }

   //========================================== tickets  =============================================
	//=============================================================================================---->
   //tickets sold
   public function tickets_sold($code){
      $qty = invoice_products::where('product_code',$code)->sum('quantity');
      return $qty;
   }
}
