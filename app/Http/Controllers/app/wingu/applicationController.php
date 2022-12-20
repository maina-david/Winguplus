<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\Modules;
use App\Models\wingu\Cart;
use App\Models\wingu\business_modules;
use App\Models\wingu\control\invoices;
use App\Models\wingu\control\invoice_settings;
use App\Mail\systemMail;
use Auth;
use Session;
use Wingu;
use Helper;
use Mail;
use PDF;
class applicationController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Application setup
   **/
   public function application_setup(){

      //check if account has modules
      if(Wingu::check_if_account_has_modules() > 0){
         return redirect()->route('application.setup');
      }

      $applications = Modules::where('status',15)->get();

      $cart = Cart::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.wingu.application-setup', compact('applications','cart'));
   }

   /**
   * Add application to cart
   **/
   public function add_to_cart($moduleCode){

      $checkCart = Cart::where('module_code',$moduleCode)->where('business_code',Auth::user()->business_code)->count();
      if($checkCart == 0){
         $applications = Modules::where('module_code',$moduleCode)->first();

         $add = new Cart;
         $add->module_code = $moduleCode;
         $add->module_name = $applications->name;
         $add->description = $applications->caption;
         $add->qty = 1;
         $add->price = $applications->price;
         $add->total_amount = $applications->price;
         $add->business_code = Auth::user()->business_code;
         $add->created_by = Auth::user()->user_code;
         $add->save();

         Session::flash('success','Application successfully added');

         return redirect()->back();
      }else{
         Session::flash('warning','This application is already on your selected list');

         return redirect()->back();
      }
   }

   /**
   * remove application from cart
   **/
   public function remove_cart($cartID){
      Cart::where('id',$cartID)->where('business_code',Auth::user()->business_code)->where('created_by',Auth::user()->user_code)->delete();

      Session::flash('success','Application successfully removed');

      return redirect()->back();
   }

   /**
   * install applications
   **/
   public function install(Request $request){
      $code = Helper::generateRandomString(16);
      $business = Wingu::business();
      $trialDays = 14;
      $invoiceDate = date('Y-m-d');
      $invoiceDue = date('Y-m-d', strtotime($invoiceDate. ' + '.$trialDays.' days'));

      //get items from cart
      $cart = Cart::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      foreach($cart as $item){
         //check if account has module
         $checkModule = business_modules::where('business_code',Auth::user()->business_code)->where('module_code',$item->module_code)->count();
         if($checkModule == 0){
            //invoice setting
		      $invoiceSettings = invoice_settings::find(1);

            //create invoice
            $store					   = new invoices;
            $store->business_code	= Auth::user()->business_code;
            $store->invoice_title	= $item->module_name;
            $store->module_code	   = $item->module_code;
            $store->number          = $invoiceSettings->number + 1;
            $store->number          = $invoiceSettings->prefix;
            $store->invoice_date	   = $invoiceDate;
            $store->invoice_due	   = $invoiceDue;
            $store->customer_note	= $invoiceSettings->default_customer_notes;
            $store->terms				= $invoiceSettings->default_terms_conditions;
            $store->status		      = 1;
            $store->invoice_code 	= $code;
            $store->main_amount     = $item->total_amount;
            $store->total		      = $item->total_amount;
            $store->balance		   = $item->total_amount;
            $store->sub_total	      = $item->total_amount;
            $store->created_by      = Auth::user()->user_code;
            $store->save();

            //settings
            $invoiceSettings->number = $invoiceSettings->number + 1;
            $invoiceSettings->save();

            //allocate modules to account
            $module = new business_modules;
            $module->business_code  = Auth::user()->business_code;
            $module->module_code    = $item->module_code;
            $module->payment_status = 1;
            $module->start_date     = $invoiceDate;
            $module->end_date       = $invoiceDue;
            $module->price          = $item->total_amount;
            $module->version        = 35;
            $module->status         = 15;
            $module->created_by     = Auth::user()->user_code;
            $module->save();

            //send email confirmation and discounted invoice
            $appNames = 'Shule Cloud';
            $appEmail = 'support@shulecloud.com';

            $subject = $appNames.' '.$item->module_name.' Application Billing';
            $to = $business->email;
            $content = '<h3>Hi,'.$business->name.'</h3><h4>Billing Details</h4><p><b>Application :</b> '.$item->module_name.'<br><b>Trial Period :</b> '.date('F j, Y', strtotime($invoiceDate)).' - '.date('F j, Y', strtotime($invoiceDue)).'<br><b>Payment Status :</b> <span style="color:green;font-weight:900;">Paid</span><br><b>Discount :</b> $'.$item->total_amount.'</p><p>'.$business->name.' has been given '.$trialDays.'days to try all the '.$item->module_name.' Application features</p><p>If you have any questions regarding your '.$appNames.'<sup>TM</sup> account, please contact us at '.$appEmail.' Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to '.$appNames.'<sup>TM</sup>.</p>';

            Mail::to($to)->send(new systemMail($content,$subject));

            //delete cart item
            Cart::where('business_code',Auth::user()->business_code)->where('id',$item->id)->delete();
         }

         if($checkModule > 0){
            $update = business_modules::where('business_code',Auth::user()->business_code)->where('module_code',$item->module_code)->where('status',22)->first();
            $update->status = 15;
            $update->save();

            //delete cart item
            Cart::where('business_code',Auth::user()->business_code)->where('id',$item->id)->delete();
         }
      }

      //redirect to dashboard
      Session::flash('success','Your Applications have been installed successfully');

      return redirect()->route('wingu.dashboard');
   }

   /**
   * upgrade application
   **/
   public function add_application(){
      $applications = Modules::get();
      $cart = Cart::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.wingu.applications', compact('applications','cart'));
   }
}
