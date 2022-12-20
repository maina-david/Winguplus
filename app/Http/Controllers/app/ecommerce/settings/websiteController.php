<?php

namespace App\Http\Controllers\app\ecommerce\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ecommerce\settings;
use Auth;
use Session;
use Helper;
use File;
class websiteController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Wesite details
   **/
   public function details(){
      //check if account has settings
      $check = settings::where('business_code',Auth::user()->business_code)->count();
      if($check == 0){
         $setup = new settings;
         $setup->business_code = Auth::user()->business_code;
         $setup->created_by = Auth::user()->user_code;
         $setup->save();
      }

      $site = settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.ecommerce.settings.website.details', compact('site'));
   }

   /**
   * save details
   **/
   public function save_details(Request $request){
      $site = settings::where('business_code',Auth::user()->business_code)->first();

      //upload logo
      if(!empty($request->logo)){

         //directory
         $directory = base_path().'/public/businesses/'.$site->business_code.'/documents/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //delete logo if exist
         if($site->logo != ""){
            $delete = $directory.$site->logo;
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
         $file->move($directory, $fileName);

         $site->logo = $fileName;
      }

      $site->store_title = $request->site_title;
      $site->store_meta_description = $request->store_meta_description;
      $site->store_description = $request->store_description;
      $site->domain = $request->domain;
      $site->save();

      Session::flash('success','Site details updated successfully');

      return redirect()->back();
   }

   /**
   * Wesite contacts
   **/
   public function contacts(){     
      //check if account has settings
      $site = settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.ecommerce.settings.website.contacts', compact('site'));
   }

   /**
   * save contacts
   **/
   public function save_contacts(Request $request){
      $site = settings::where('business_code',Auth::user()->business_code)->first();
      $site->notification_email = $request->notification_email;
      $site->phone_number = $request->phone_number;
      $site->location_address = $request->location_address;
      $site->map = $request->map;
      $site->save();

      Session::flash('success','Site contacts updated successfully');

      return redirect()->back();
   }

   /**
   * Wesite policies
   **/
   public function policies(){
      //check if account has settings
      $site = settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.ecommerce.settings.website.policies', compact('site'));
   }

   /**
   * save policies
   **/
   public function save_policies(Request $request){
      $site = settings::where('business_code',Auth::user()->business_code)->first();
      $site->return_policy = $request->return_policy;
      $site->refund_policy = $request->refund_policy;
      $site->payment_policy = $request->payment_policy;
      $site->privacy_policy = $request->privacy_policy;
      $site->terms_and_conditions = $request->terms_and_conditions;
      $site->save();

      Session::flash('success','Site policies updated successfully');

      return redirect()->back();
   }

   /**
   * Wesite analytics
   **/
   public function analytics(){
      //check if account has settings
      $site = settings::where('business_code',Auth::user()->business_code)->first();

      return view('app.ecommerce.settings.website.analytics', compact('site'));
   }

   /**
   * save analytics
   **/
   public function save_analytics(Request $request){
      $site = settings::where('business_code',Auth::user()->business_code)->first();
      $site->facebook_pixel = $request->facebook_pixel;
      $site->google_analytics = $request->google_analytics;
      $site->save();

      Session::flash('success','Site analytics updated successfully');

      return redirect()->back();
   }
}
