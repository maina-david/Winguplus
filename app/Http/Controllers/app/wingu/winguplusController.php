<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use App\Mail\systemMail;
use App\Models\finance\products\product_information;
use App\Models\wingu\business_modules;
use App\Models\wingu\Cart;
use App\Models\wingu\control\invoice_settings;
use App\Models\wingu\control\invoices;
use Illuminate\Http\Request;
use App\Models\wingu\plan;
use App\Models\wingucrowd\events;
use Wingu;
use Auth;
use Mail;
use Helper;
use Session;
class winguplusController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //subscription
   public function subscription(){
      $subscription = plan::where('plan_code',Wingu::business()->plan_code)->first();
      $business = Wingu::business();

      return view('app.settings.subscription', compact('subscription','business'));
   }

   //plan
   public function plans(){
      return view('app.plan.plans');
   }

   //ticket test
   public function tickets(){
      $content = "content";
      $subject = "subject";
      $to = "grifkisia@gmail.com";

      $productCode = 'R7ZidQCbOawVgEPidScz';
      $eventCode = 'pcb6jPbvDgJ8CSYS7RLKGr417CQ201';

      //Mail::to($to)->send(new sendTicket($content,$subject));
      $ticket  = product_information::where('product_code',$productCode)->where('business_code',Auth::user()->business_code)->first();
      $event = events::where('event_code',$eventCode)->where('business_code',Auth::user()->business_code)->first();
      $link = route('wingu.ticket.details',$productCode);

      return view('email.tickets.template2', compact('event','ticket','link'));
   }

   //application
   public function apps(){
      return view('app.wingu.apps');
   }

   //install applications
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
            $appNames = 'WinguPlus';
            $appEmail = 'support@winguplus.com';

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
}
