<?php

namespace App\Http\Controllers\app\propertywingu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\property\lease;
use App\Models\finance\customer\customers;
use App\Models\property\tenants\tenants;
use App\Models\crm\emails;
use App\Models\wingu\Email;
use Auth;
class propertywinguController extends Controller
{
   public function dashboard(){
      $business = business::where('business_code',Auth::user()->code)->first();

      $tenants = tenants::where('business_code',Auth::user()->business_code)->count();

      $vacant = property::where('business_code',Auth::user()->business_code)->whereNull('tenant')->count();

      $occupied = property::where('business_code',Auth::user()->business_code)->where('tenant','!=',"")->count();

      $owners = customers::where('business_code',Auth::user()->business_code)->count();

      $inquiries = Email::where('business_code',Auth::user()->business_code)
                           ->where('property_code','!=',NULL)->where('section','Property Inquiry')
                           ->orderby('id','desc')
                           ->limit(7)
                           ->get();
      $count = 1;
      return view('app.propertywingu.dashboard.dashboard', compact('tenants','vacant','occupied','owners','inquiries','count'));
   }
}
