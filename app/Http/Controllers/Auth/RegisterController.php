<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\wingu\business;
use App\Models\wingu\wp_user;
use App\Mail\systemMail;
use App\Models\wingu\role_user;
use Session;
use Helper;
use Mail;

class RegisterController extends Controller
{
   /*
   |--------------------------------------------------------------------------
   | Register Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles the registration of new users as well as their
   | validation and creation. By default this controller uses a trait to
   | provide this functionality without requiring any additional code.
   |
   */

   use RegistersUsers;

   /**
    * Where to redirect users after registration.
    *
    * @var string
    */
   protected $redirectTo = RouteServiceProvider::HOME;

   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('guest');
   }


   /**
    * Create a new user instance after a valid registration.
    *
    *
   */
   public function signup_form(){
      return view('auth.register');
   }

   /**
    * Create a new user instance after a valid registration.
    *
    *
   */
   public function signup(Request $request){
      $this->validate($request, [
         'full_names' => 'required',
         'email' => 'required', 'string', 'email', 'max:255', 'unique:wp_users',
         'password' => ['required', 'string', 'min:12', 'confirmed'],
      ]);

      //token
      $token = Helper::generateRandomString(20);
      $checkEmail = wp_user::where('email',$request->email)->count();
      if($checkEmail != 0){
         Session::flash('warning','The email your entered is already in use');

         return redirect()->back();
      }

      //add to user table
      $user = new wp_user;
      $user->name = $request->full_names;
      $user->user_code = $token;
      $user->business_code =  $token;
      $user->email = $request->email;
      $user->status = 15;
      $user->password = Hash::make($request->password);
      $user->remember_token = $token;
      $user->created_by = $token;
      $user->save();

      $trialDays = 14;
      $startDate = date('Y-m-d');
      $dateJoined = date('Y-m-d H:i:s');
      $billingStart = date('Y-m-d', strtotime($startDate. ' + '.$trialDays.' days'));

      //add the business
      $business = new business;
      $business->business_code = $token;
      $business->name = $request->full_names;
      $business->email = $request->email;
      $business->plan_code = 'UnyfV9RP1rMFhuBWKO4sjCcZyg12xp';
      $business->currency = 'ksh';
      $business->country = 'Kenya';
      $business->company_size = '1-5';
      $business->time_zone = 'Africa/Nairobi';
      $business->created_by =$token;
      $business->template_code = '8zhvwH0';
      $business->due_date = $billingStart;
      $business->date_joined = $dateJoined;
      $business->save();

      //add admin role
      $role = new role_user;
      $role->role_code = 'admin';
      $role->user_code = $token;
      $role->save();

      //welcome email
      $appNames       = 'WinguPlus';
      $appEmail       = 'support@winguplus.com';
      $appWebsiteLink = 'https://winguplus.com/';
      $appLinkName    = 'www.winguplus.com';

      $subject = 'Welcome to '.$appNames;
      $userContent = '<h4>Hello, '.$user->name.'</h4><p>Thank you for creating your account with us. Managing your business has never gotten easier.We have a powerful product suite to help you manage your business with ease. <p><p>To activate your '.$appNames.' account, please click the link below within the next 30 days.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><center><a href="'.route('account.verify',$token).'" target="_blank">Confirm Account</a></center></td></tr></tbody></table></td></tr></tbody></table><p>If you have any questions regarding your '.$appNames.' account, please contact us at '.$appEmail.' Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to '.$appNames.'<sup>TM</sup>.</p><p><p>Regards<br>'.$appNames.' Team<br><a href="'.$appWebsiteLink.'">'.$appLinkName.'</a></p><hr><small>If you’re having trouble clicking the "Confirm Account" button, copy and paste the URL below into your web browser: <a href="'.route('account.verify',$token).'">'.route('account.verify',$token).'</a></small>';
      $to = $request->email;
      Mail::to($to)->send(new systemMail($userContent,$subject));

      Session::flash('success','Your account has been created you can now login');

      return redirect()->route('login');
   }
}
