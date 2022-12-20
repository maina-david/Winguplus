<?php

namespace App\Http\Controllers\app\subscriptions;

use App\Charts\Subscriptions\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\subscriptions\subscriptions;
use Auth;
use DB;
use Wingu;
class dashboardController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   public function dashboard(){
      $month = date('m');
      $year = date('Y');

      $subscriptionsCount = subscriptions::whereMonth('created_at',$month)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->count();

      $trialCount = subscriptions::whereMonth('created_at',$month)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->where('status',35)
                                    ->count();

      $closedCount = subscriptions::whereMonth('created_at',$month)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->where('status',22)
                                    ->count();

      $liveCount = subscriptions::whereMonth('created_at',$month)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->where('status',36)
                                    ->count();

      /*
      * subscriptions per month
      * */
      $subscriptionPerMonth = new Reports;
      $month  = subscriptions::where('subscriptions.business_code',Auth::user()->business_code)
                                 ->whereYear('starts_on', '=', $year)
                                 ->groupby(DB::raw('MONTH(starts_on)'))
                                 ->select(DB::raw('month(starts_on) as month'))
                                 ->selectRaw("DATE_FORMAT(starts_on, '%M') AS month")
                                 ->pluck('month');

      $totalMonth =  DB::table('subscriptions')
                           ->whereYear('starts_on', '=', $year)
                           ->groupby(DB::raw('MONTH(starts_on)'))
                           ->select(DB::raw('SUM(amount) as total'))
                           ->where('business_code',Auth::user()->business_code)
                           ->pluck('total');

      $TotalSubscriptionCount =  DB::table('subscriptions')
                           ->whereYear('starts_on', '=', $year)
                           ->groupby(DB::raw('MONTH(starts_on)'))
                           ->where('business_code',Auth::user()->business_code)
                           ->select(DB::raw('count(*) as total'))
                           ->pluck('total');

      $subscriptionPerMonth->labels($month->values());
      $subscriptionPerMonth->dataset('Subscription value', 'bar', $totalMonth->values())->backgroundColor('rgba(252,0,56,0.4)');
      $subscriptionPerMonth->dataset('Total Subscriptions', 'bar', $TotalSubscriptionCount->values())->backgroundColor('rgba(132, 87, 243,0.4)');

      return view('app.subscriptions.dashboard.index', compact('subscriptionsCount','trialCount','closedCount','liveCount','subscriptionPerMonth'));
   }
}
