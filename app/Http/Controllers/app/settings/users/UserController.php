<?php

namespace App\Http\Controllers\app\settings\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\branches;
use App\Mail\sendMessage;
use App\Models\wingu\permission_role;
use App\Models\wingu\role_user;
use App\Models\wingu\roles;
use App\Models\wingu\user_permission;
use App\Models\wingu\wp_user;
use DB;
use Session;
use Wingu;
use Auth;
use Hash;
use Mail;
use Helper;
use Hr;
class UserController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      if(!Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') != 0){
         return view('errors.403');
      }

      //check if account has no branches
      $checkBranches = branches::where('business_code',Auth::user()->business_code)->count();
      if($checkBranches == 0){
         $branches = new branches;
         $branches->branch_code = Helper::generateRandomString(20);
         $branches->branch_name = 'Main branch';
         $branches->main_branch = 'Yes';
         $branches->business_code = Auth::user()->business_code;
         $branches->created_by = Auth::user()->user_code;
         $branches->save();
      }

      $users = wp_user::join('wp_status','wp_status.id','=','wp_users.status')
                     ->where('business_code',Auth::user()->business_code)
                     ->select('*','wp_status.name as status_name','wp_users.name as user_name')
                     ->OrderBy('wp_users.id','DESC')
                     ->get();
      $businessPlan = Wingu::plan();

      return view('app.settings.users.index', compact('users','businessPlan'));
   }

   public function create(){
      if(!Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') != 0){
         return view('errors.403');
      }
      
      $businessPlan = Wingu::plan();
      $users = wp_user::where('business_code',Auth::user()->business_code)->get();

      if($users->count() == $businessPlan->users){
         return redirect()->route('winguplus.plans');
      }else{
         $roles = roles::where('business_code',Auth::user()->business_code)->get();
         $branches = branches::where('business_code',Auth::user()->business_code)->get();
         return view('app.settings.users.create', compact('roles','branches'));
      }
   }

   public function store(Request $request){
      $this->validate($request,[
         'name' => 'required',
         'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
         'password' => 'required', 'string', 'min:8', 'confirmed',
         //'roles' => 'required',
         'branch' => 'required',
      ]);

      $check = wp_user::where('email',$request->email)->count();
      if($check != 0){
         Session::flash('error','The email you have provided is already in use');
         return redirect()->back();
      }

      //create employee
      $userCode = Helper::generateRandomString(20);
      $user = new wp_user;
      $user->user_code       = $userCode;
      $user->name            = $request->name;
      $user->email           = $request->email;
      $user->branch_code     = $request->branch;
      $user->business_code   = Auth::user()->business_code;
      $user->created_by      = Auth::user()->user_code;
      $user->status          = 15;
      $user->remember_token  = Helper::generateRandomString(20);
      $user->password        = Hash::make($request->password);
      $user->save();

      //assign roles
      if(!empty($request->roles)){
         for($i=0; $i < count($request->roles); $i++ ) {
            $roles = new role_user;
            $roles->role_code = $request->roles[$i];
            $roles->user_code = $userCode;
            $roles->save();

            //assign permission
            $permissions = permission_role::where('role_code',$request->roles[$i])->where('business_code',Auth::user()->business_code)->get();
            foreach($permissions as $permission){
               $allocate  = new user_permission;
               $allocate->permission_code = $permission->permission_code;
               $allocate->user_code = $userCode;
               $allocate->save();
            }
         }
      }


      //send email to new employee
      $subject = 'Account Activation and verification';
      $to = $user->email;
      $content = '<h3>Hi,'.$request->name.'</h3><h4>We are delighted to have you on board</h4><p>We have a powerful product suite to help you manage your business with ease. You can check us out at www.winguplus.com.</p><p>To activate your winguPlus account, please click the link below within the next 30 days.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><center><a href="'.route('account.verify',$user->remember_token).'" target="_blank">Confirm Account</a> </center></td></tr></tbody></table></td></tr></tbody></table> <p>If you have any questions regarding your winguPlus<sup>TM</sup> account, please contact us at support@winguplus.com Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to winguPlus<sup>TM</sup>.</p>';
      Mail::to($to)->send(new sendMessage($content,$subject));

      Session::flash('success','User Added successfully');

      return redirect()->route('settings.users.index');
   }

   public function edit($code){
      $roles = roles::where('business_code',Auth::user()->business_code)->get();
      $user = wp_user::where('user_code', $code)->where('business_code',Auth::user()->business_code)->first();
      $branches = branches::where('business_code',Auth::user()->business_code)->pluck('name','branch_code')->prepend('choose branch','');

      return view('app.settings.users.edit', compact('user','user','roles','branches'));
   }

   public function update(Request $request,$code){
      $this->validate($request,[
         'name' => 'required',
         'branch_code' => 'required',
         'email' => 'required|email',
      ]);

      //check if email is in use
      $user = wp_user::where('user_code',$code)->where('business_code',Auth::user()->business_code)->first();
      if($user->email != $request->email){
         $checkEmail = wp_user::where('email',$request->email)->count();
         if($checkEmail != 0){
            Session::flash('error','The email you have provided is already in use');
            return redirect()->back();
         }
      }
      $user->name        = $request->name;
      $user->email       = $request->email;
      $user->branch_code = $request->branch_code;
      $user->updated_by  = Auth::user()->code;
      $user->save();

      if(!empty($request->roles)){
         DB::table('wp_role_user')->where('user_code',$code)->delete();
         DB::table('wp_permission_user')->where('user_code',$code)->delete();

         for($i=0; $i < count($request->roles); $i++ ) {
            $roles = new role_user;
            $roles->role_code = $request->roles[$i];
            $roles->user_code = $code;
            $roles->save();

            //assign permission
            $permissions = permission_role::where('role_code',$request->roles[$i])->where('business_code',Auth::user()->business_code)->get();
            foreach($permissions as $permission){
               $allocate  = new user_permission;
               $allocate->permission_code = $permission->permission_code;
               $allocate->user_code = $code;
               $allocate->save();
            }
         }
      }

      Session::flash('success', 'User Successfully updated!');

      return redirect()->back();
   }
}
