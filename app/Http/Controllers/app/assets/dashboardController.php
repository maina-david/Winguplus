<?php
namespace App\Http\Controllers\app\assets;
use App\Charts\Assets\Reports;
use App\Http\Controllers\Controller;
use App\Models\asset\assets;
use Illuminate\Http\Request;
use App\Models\asset\types;
use Auth;
use Wingu;
use DB;

class dashboardController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function dashboard(){
      //total assets
      $assets = assets::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      //checked out
      $checkedOut = assets::where('business_code',Auth::user()->business_code)->where('current_status',38)->orderby('id','desc')->get();

      //under Repair
      $underRepair = assets::where('business_code',Auth::user()->business_code)->where('current_status',34)->orderby('id','desc')->get();

      //missing
      $missing = assets::where('business_code',Auth::user()->business_code)->where('current_status',34)->orderby('id','desc')->get();

      //assets by type
      $assetByType = new Reports;

      $types = assets::join('as_asset_type','as_asset_type.type_code','=','as_assets.asset_type')
                     ->where('as_asset_type.business_code',Auth::user()->business_code)
                     ->orwhere('as_asset_type.business_code',0)
                     ->groupby('asset_type')
                     ->select('as_asset_type.name as type')
                     ->pluck('type');

      $assetType = DB::table('as_assets')
                     ->join('as_asset_type','as_asset_type.type_code','=','as_assets.asset_type')
                     ->where('as_asset_type.business_code',Auth::user()->business_code)
                     ->orwhere('as_asset_type.business_code',0)
                     ->select(DB::raw('COUNT(as_asset_type.type_code) as total'))
                     ->groupby('asset_type')
                     ->pluck('total');

      $assetByType->labels($types->values());
      $assetByType->dataset('Jobs Per Month', 'pie', $assetType->values())
                      ->backgroundColor(collect(['rgba(243,71,112,0.2','rgba(237, 88, 18, 0.6)','rgba(243,71,112,0.2)','rgba(247, 229, 6, 0.6)','rgba(237, 88, 18, 0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));


      //Assets By Status
      $assetByStatus = new Reports;

      $status = assets::join('wp_status','wp_status.id','=','as_assets.current_status')
                     ->where('as_assets.business_code',Auth::user()->business_code)
                     ->groupby('current_status')
                     ->select('wp_status.name as status')
                     ->pluck('status');

      $assetsStatus = DB::table('as_assets')
                     ->join('wp_status','wp_status.id','=','as_assets.current_status')
                     ->where('as_assets.business_code',Auth::user()->business_code)
                     ->select(DB::raw('COUNT(current_status) as total'))
                     ->groupby('current_status')
                     ->pluck('total');

      $assetByStatus->labels($status->values());
      $assetByStatus->dataset('Jobs Per Month', 'doughnut', $assetsStatus->values())
                     ->backgroundColor(collect(['rgba(52,186,187,0.6)','rgba(247, 229, 6, 0.6)','rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(52,186,187,0.6)','rgba(243,71,112,0.2)']));

      return view('app.assets.dashboard.dashboard', compact('assetByType','assetByStatus','assets','checkedOut','underRepair','missing'));
   }
}
