<?php

namespace App\Http\Controllers\app\settings\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business;
use App\Models\wingu\activity_log;
use App\Models\wingu\industry;
use App\Models\wingu\country;
use App\Models\finance\currency;
use App\Models\wingu\wp_user;
use Wingu;
use Auth;
use Session;
use Helper;
use File;


class businessController extends Controller
{
   public function index(){
      if(!Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') != 0){
         return view('errors.403');
      }

      $business = business::where('business_code',Auth::user()->business_code)->first();
      $logs = activity_log::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $industry = industry::orderby('id','desc')->pluck('name','id')->prepend('Choose industry','');
      $country = country::orderby('id','desc')->pluck('name','id')->prepend('Choose country','');
      $currency = currency::pluck('currency_name','code')->prepend('Choose currency');
      $staffs = wp_user::where('business_code', Auth::user()->business_code)
                        ->select('*','business_code as business')
                        ->orderby('id','desc')
                        ->get();

      return view('app.settings.business.index', compact('business','staffs','logs','industry','country','currency'));
   }

   public function update(Request $request,$code){

      $this->validate($request, [
         'name' => 'required',
         'phone_number' => 'required',
      ]);

      $business = business::where('business_code',$code)->first();
      $business->name = $request->name;
      $business->industry = $request->industry;
      $business->company_size = $request->company_size;
      $business->phone_number = $request->phone_number;
      $business->website = $request->website;
      $business->street = $request->street;
      $business->city = $request->city;
      $business->state_province = $request->state_province;
      $business->zip_code = $request->zip_code;
      $business->country = $request->country;
      $business->currency = $request->currency;

      //upload logo
      if(!empty($request->logo)){

         //directory
         $directory = base_path().'/public/businesses/'.$business->business_code.'/documents/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //delete logo if exist
         if($business->logo != ""){
            $delete = $directory.$business->logo;
            if (File::exists($delete)) {
               unlink($delete);
            }
         }

         //upload estimate to system
         $file = $request->logo;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(9). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $upload_success = $file->move($directory, $fileName);

         $business->logo = $fileName;
      }

      $business->save();

      //recorded activity
      $activities = Auth::user()->name.' has made an update to the business profile';
      $module = 'Settings';
      $section = 'Business Profile';
      $action = 'Edit';
      $activityID = $code;
      Wingu::activity($activities,$section,$action,$activityID,$module);

      Session::flash('success','Business profile successfully updated');

      return redirect()->back();
   }

   public function delete_logo($code){

      $business = business::where('business_code',$code)->first();

      //directory
      $directory = base_path().'/public/businesses/'.$business->business_code.'/documents/images/';

      //create directory if it doesn't exists
      $delete = $directory.$business->logo;
      if (File::exists($delete)) {
         unlink($delete);
      }

      $business->logo = "";
      $business->save();

      //recorded activity
      $activities = Auth::user()->name.' has deleted the business profile logo';
      $module = 'Settings';
      $section = 'Business Profile';
      $action = 'Edit';
      $activityID = $code;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      Session::flash('success','Business profile successfully updated');

      return redirect()->back();

   }
}
