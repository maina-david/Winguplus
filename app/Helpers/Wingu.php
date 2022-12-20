<?php
namespace App\Helpers;
use App\Models\wingu\languages;
use App\Models\wingu\country;
use App\Models\wingu\settings;
use App\Models\wingu\activity_log;
use App\Models\wingu\business;
use App\Models\finance\currency;
use App\Models\wingu\status;
use App\Models\wingu\User;
use App\Models\wingu\Sessions;
use App\Models\wingu\permissions;
use App\Models\wingu\file_manager;
use App\Models\wingu\templates;
use App\Models\wingu\modules;
use App\Models\wingu\industry;
use App\Models\wingu\plan_module;
use App\Models\wingu\plan_functions;
use App\Models\wingu\functions;
use App\Models\wingu\plan;
use App\Models\wingu\roles;
use App\Models\wingu\business_modules;
use App\Models\wingu\permission_role;
use App\Models\wingu\role_user;
use App\Models\wingu\user_permission;
use App\Models\wingu\wp_user;
use Request;
use Auth;
use Helper;
use File;
class Wingu
{
   //get language
   public static function Language($id){
      $language = languages::find($id);
      return $language;
   }

   /**============= country =============**/
	public static function country($id){
		$country = country::find($id);
		return $country;
   }

   /**============= settings =============**/
   public static function check_for_setting($name, $type){
      $check = settings::where('name',$name)->where('type',$type)->count();
      return $check;
   }

   public static function all_settings(){
      $settings = settings::groupby('section')->get();
      return $settings;
   }

   public static function settings_by_type($type){
      $types = settings::where('type',$type)->get();
      return $types;
   }

   public static function get_specific_setting($name, $type){
      $settings = settings::where('name',$name)->where('type',$type)->first()->value;
      return $settings;
   }

   /**============= Record Activity =============**/
   public static function activity($activity,$module,$section,$action,$activityCode){
      $save = new activity_log;
      $save->activity      = $activity;
      $save->module        = $module;
      $save->section       = $section;
      $save->action        = $action;
      $save->activity_code = $activityCode;
      $save->user_code     = Auth::user()->user_code;
      $save->business_code = Auth::user()->business_code;
      $save->ip_address    = Request::ip();
      $save->save();
   }

   /**============= check if admin is linked to a business =============**/
   public static function business(){
      $business = business::where('business_code',Auth::user()->business_code)->first();
      return $business;
   }

   public static function business_with_id($business_code){
      $business = business::where('business_code',$business_code)->select('name')->first();
      return $business;
   }

   public static function template(){
      $business = business::where('business_code',Auth::user()->business_code)->first();
      $template = templates::where('template_code',$business->template_code)->first();
      return $template;
   }

   /**============= status =============**/
   public static function status($id){
      $status = status::find($id);
      return $status;
   }

   public static function check_status($id){
      $check = status::where('id',$id)->count();
      return $check;
   }

   /**============= user info =============**/
   public static function user($code){
      $user = wp_user::where('user_code',$code)->where('business_code',Auth::user()->business_code);

      return response()->json([
         "user"  => $user->first(),
         "check" => $user->count(),
      ]);
   }

   //check user
   public static function check_user($code){
      $check = wp_user::where('user_code',$code)->where('business_code',Auth::user()->business_code)->count();
      return $check;
   }

   //count users
   public static function count_user(){
      $count = wp_user::where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   /**============= modules =============**/
   //module info
   public static function modules($code){
      $modules = modules::where('module_code',$code)->first();
      return $modules;
   }

   //check if module exits
   public static function check_modules($code){
      $check = modules::where('module_code',$code)->count();
      return $check;
   }

   //get all active modules
   public static function get_active_modules(){
      $modules = modules::where('status',15)->get();
      return $modules;
   }

   //check if plan is linked to module
   public static function check_plan_module_link($module_code,$planCode){
      $check = plan_module::where('module_code',$module_code)->where('plan_code',$planCode)->count();
      return $check;
   }

   /**============= general user info =============**/
   // user Session
   public static function sessions($id){
      $session = Sessions::where('user_id',$id)->orderby('id','desc')->limit(1)->first();
      return $session;
   }

   //check if user has account
   public static function employee_account_check($id){
      $check = User::where('employeeID',$id)->where('business_code',Auth::user()->business_code)->count();
      return $check;
   }

   /**============= plan =============**/
   //get all plans
   public static function get_all_plan(){
      $plans = plan::where('status','Active')->orderby('id','asc')->get();
      return $plans;
   }

   /**============= file manager =============**/
   public static function file_size(){
      $size = file_manager::where('business_code',Auth::user()->business_code)->get()->sum("file_size");
      return $size;
   }

   /**============= roles =============**/
   public static function count_roles(){
      $count = roles::where('business_code',Auth::user()->business_code)->count();
      return $count;
   }

   /**============= ipay =============**/
   public static function ipay($planCode){
      $plan = plan::where('plan_code',$planCode)->first();

      $vendorID = 'treeb';
      $secretKey = 'Fun123XCVA121dgkL';
      $cbUrl = route('wingu.application.payment');

      $price = $plan->price * 100;
      $currency = 'KES';
      $mpesa = 1;

      /*
      This is a sample PHP script of how you would ideally integrate with iPay Payments Gateway and also handling the
      callback from iPay and doing the IPN check

      ----------------------------------------------------------------------------------------------------
               ************(A.) INTEGRATING WITH iPAY ***********************************************
      ----------------------------------------------------------------------------------------------------
      */
      //Data needed by iPay a fair share of it obtained from the user from a form e.g email, number etc...
      $fields = array("live"=> "1",
         "oid"=> Wingu::business()->business_code,
         "mpesa"=> $mpesa,
         "inv"=> Wingu::business()->business_code,
         "ttl"=> $price,
         "tel"=> "0700000000",
         "eml"=> Wingu::business()->email,
         "vid"=> $vendorID,
         "curr"=> $currency,
         "p1"=> "Plan Payment",
         "p2"=> Auth::user()->business_code,
         "p3"=> $currency,
         "p4"=> "",
         "cbk"=> $cbUrl,
         "cst"=> "1",
         "crl"=> "0"
      );

      /*
      ----------------------------------------------------------------------------------------------------
      ************(b.) GENERATING THE HASH PARAMETER FROM THE DATASTRING *********************************
      ----------------------------------------------------------------------------------------------------

      The datastring IS concatenated from the data above
      */
      $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
      $hashkey =  $secretKey;//use "demoCHANGED" for testing where vid is set to "demo"

      /********************************************************************************************************
      * Generating the HashString sample
      */
      $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

      return $generated_hash;
   }

   /**============= ipay =============**/
   public static function check_account_payment(){
      $check = business::where('id',Auth::user()->business_code)->first();
      if(date('Y-m-d') > $check->due_date){
         return 'due';
      }else{
         return 'ok';
      }
   }

   /**============= industry =============**/
   public static function industry($id){
      $industry = industry::find($id);
      return $industry;
   }


   /**============= payment link =============**/
   public static function payment_link(){
      $link = 'https://payments.winguplus.com';
      return $link;
   }

   //============================================ business modules  ==================================
	//=============================================================================================---->
   // business modules
   public static function check_business_modules($code){
      $check = business_modules::where('business_code',Auth::user()->business_code)->where('module_code',$code)->count();
      return $check;
   }

   //check if account has modules
   public static function check_if_account_has_modules(){
      $check = business_Modules::where('business_code',Auth::user()->business_code)->count();
      return $check;
   }

   //check if account has modules
   public static function get_account_module_details($code){
      $info = business_Modules::where('business_code',Auth::user()->business_code)
                              ->where('module_code',$code)
                              ->first();
      return $info;
   }

   //check the number of active modules
   public static function count_payed_modules(){
      $check = business_Modules::where('business_code',Auth::user()->business_code)->where('payment_status',1)->where('status',15)->count();
      return $check;
   }

   //plan details
   public static function plan(){
      $business = business::where('business_code',Auth::user()->business_code)->first();
      $plan = plan::where('plan_code',$business->plan_code)->first();
      return $plan;
   }


   //plan modules
   public static function check_plan_module($planID,$module_code){
      $check = plan_module::where('planID',$planID)->where('module_code',$module_code)->where('status',15)->count();
      return $check;
   }

   //plan functions
   public static function check_plan_function($functionID,$planID,$module_code){
      $check = plan_functions::where('functionID',$functionID)
                     ->where('planID',$planID)
                     ->where('module_code',$module_code)
                     ->count();
      return $check;
   }

   //get plan details
   public static function get_plan($id){
      $plan = plan::where('id',$id)->first();
      return $plan;
   }

   //======================================= roles and permissions  ==================================
	//=============================================================================================---->
   /**
   * get permissions by group
   **/
   public static function permissions_by_group($code){
      $permissions = permissions::where('function_code',$code)->get();
      return $permissions;
   }

   //get module functionalities
   public static function get_module_functions($code){
      $groups = functions::where('module_code',$code)->where('status',15)->get();
      return $groups;
   }

   //check if function has permission
   public static function check_role_permission($role,$permission){
      $check = permission_role::where('permission_code',$permission)->where('role_code',$role)->where('business_code',Auth::user()->business_code)->count();
      return $check;
   }

   //get user roles
   public static function user_roles($code){
      $roles = role_user::join('wp_roles','wp_roles.role_code','=','wp_role_user.role_code')->where('user_code',$code)->get();
      return $roles;
   }

   //check if user has role
   public static function check_if_user_has_role($userCode,$roleCode){
      $check = role_user::where('user_code',$userCode)->where('role_code',$roleCode)->count();
      return $check;
   }

   //check user permission
   public static function check_user_permission($permission){
      $check = user_permission::join('wp_permissions','wp_permissions.permission_code','=','wp_permission_user.permission_code')
                              ->where('name',$permission)
                              ->where('user_code',Auth::user()->user_code)
                              ->count();
      return $check;
   }

   //==========================================  File management ======================================
	//=============================================================================================---->
   //get file by file code
   public static function get_files($code){
      $files = file_manager::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();
      return $files;
   }

   //delete file from folder
   public function remove_file($path){
      unlink($path);
   }

}
