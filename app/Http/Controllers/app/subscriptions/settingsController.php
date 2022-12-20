<?php

namespace App\Http\Controllers\app\subscriptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\subscriptions\settings;
use Auth;
class settingsController extends Controller
{

   public function __construct(){
		$this->middleware('auth');
   }
   
   public function index(){
      $settings = settings::where('businessID',Auth::user()->businessID)->first();

      return view('app.subscriptions.settings.index', compact('settings'));
   }
}
