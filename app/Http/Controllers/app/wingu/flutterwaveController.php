<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use App\Models\wingu\business;
use App\Models\wingu\business_modules;
use App\Models\wingu\control\creditnote;
use App\Models\wingu\control\creditnote_products;
use App\Models\wingu\control\creditnote_settings;
use App\Models\wingu\control\invoice_payments;
use App\Models\wingu\control\invoice_settings;
use App\Models\wingu\control\invoices;
use App\Models\wingu\plan;
use Illuminate\Http\Request;
use Flutterwave;
use Wingu;
use Session;
use Helper;

class flutterwaveController extends Controller
{
   //pay
   public function pay(Request $request){
      $business = Wingu::business();
      $plan = plan::where('plan_code',$request->planCode)->first();

      // Enter the details of the payment
      $data = [
         'payment_options' => 'card,banktransfer,mpesa,ussd',
         'amount' => $plan->price,
         'email' => request()->email,
         'tx_ref' => $business->business_code,
         'currency' => "USD",
         'redirect_url' => route('wingu.application.flutterwave.callback'),
         'customer' => [
            'email' => $business->email,
            "phone_number" => $business->phone_number,
            "name" => $business->name
         ],

         'meta' => [
            'plan_code'=> $request->planCode,
         ],

         "customizations" => [
            "title" => 'WinguPlus Plan Payment',
         ]
      ];

      $payment = Flutterwave::initializePayment($data);

      if ($payment['status'] !== 'success') {
         // notify something went wrong

         Session::flash('warning','something went wrong');

         return redirect()->back();
      }

      return redirect($payment['data']['link']);
   }

   /**
   * Obtain Rave callback information
   * @return void
   */
   public function callback()
   {

      $status = request()->status;

      //if payment is successful
      if ($status ==  'successful') {

         $transactionID = Flutterwave::getTransactionIDFromCallback();

         $data = Flutterwave::verifyTransaction($transactionID);

         // "status" => "success"
         // "message" => "Transaction fetched successfully"
         // "data" => array:21 [▼
         //    "id" => 3499834
         //    "tx_ref" => "nrLEVPYCK"
         //    "flw_ref" => "FLW-MOCK-a7ed1221d44c79a4f296451a332d8767"
         //    "device_fingerprint" => "b0a1f303c15c3907337893c86e2f3129"
         //    "amount" => 25
         //    "currency" => "USD"
         //    "charged_amount" => 25
         //    "app_fee" => 0.95
         //    "merchant_fee" => 0
         //    "processor_response" => "Approved. Successful"
         //    "auth_model" => "VBVSECURECODE"
         //    "ip" => "52.209.154.143"
         //    "narration" => "CARD Transaction "
         //    "status" => "successful"
         //    "payment_type" => "card"
         //    "created_at" => "2022-06-20T01:09:37.000Z"
         //    "account_id" => 748825
         //    "card" => array:7 [▼
         //       "first_6digits" => "418742"
         //       "last_4digits" => "4246"
         //       "issuer" => "ACCESS BANK PLC DEBIT CLASSIC"
         //       "country" => "NIGERIA NG"
         //       "type" => "VISA"
         //       "token" => "flw-t1nf-b02df9008d9565b6a5501d797ee1d307-m03k"
         //       "expiry" => "09/32"
         //    ]
         //    "meta" => array:1 [▼
         //       "__CheckoutInitAddress" => "https://ravemodal-dev.herokuapp.com/v3/hosted/pay"
         //    ]
         //    "amount_settled" => 24.05
         //    "customer" => array:5 [▼
         //       "id" => 1664101
         //       "name" => "Blue tree digital agency"
         //       "phone_number" => "700928867"
         //       "email" => "kisia@bluetreeagency.com"
         //       "created_at" => "2022-06-20T01:08:32.000Z"
         //    ]
         // ]

         //get plan information
         $business = business::where('business_code',$data['tx_ref'])->first();
         $business->plan_code = $data['meta']['plan_code'];
         $business->save();

         $plan = plan::where('plan_code',$data['meta']['plan_code']);

         $amount = $data['charged_amount'];

         $code = Helper::generateRandomString(30);

         $planDays = 29;
         $invoiceDate = date('Y-m-d');
         $invoiceDue = date('Y-m-d', strtotime($invoiceDate. ' + '.$planDays.' days'));

         //invoice setting
         $invoiceSettings = invoice_settings::find(1);

         $store = new invoices;

         //store invoice
         $store					   = new invoices;
         $store->business_code 	= $business->business_code;
         $store->invoice_title	= $plan->title.' Plan';
         $store->invoice_number  = $invoiceSettings->number + 1;
         $store->invoice_date	   = $invoiceDate;
         $store->plan_code	      = $data['meta']['plan_code'];
         $store->invoice_due	   = $invoiceDue;
         $store->customer_note	= $invoiceSettings->default_customer_notes;
         $store->terms				= $invoiceSettings->default_terms_conditions;
         $store->status 		   = 2;
         $store->invoice_code 	= $code;
         $store->main_amount     = $amount;
         $store->total		      = $amount;
         $store->balance		   = $amount;
         $store->sub_total	      = $amount;
         $store->created_by      = $business->business_code;
         $store->save();

         //invoice settings
         $invoiceNumber 				= $invoiceSettings->number + 1;
         $invoiceSettings->number	= $invoiceNumber;
         $invoiceSettings->save();

         //update invoice payment & status
         $invoice =  invoices::where('invoice_code',$code)->first();

         //update payment
         $oldPaid = $invoice->paid;
         $newPaid = $oldPaid + $amount;
         $invoice->balance = $invoice->total - $newPaid;
         $invoice->paid = $newPaid;

         //update status
         if($newPaid == $invoice->total || $newPaid > $invoice->total){
            $invoice->status = 1;
         }elseif($newPaid < $invoice->total && $newPaid != 0 ){
            $invoice->status = 3;
         }
         $invoice->save();

         //record payment
         $pay = new invoice_payments;
         $pay->amount           = $amount;
         $pay->balance          = $invoice->total - $newPaid;
         $pay->reference_number = $data['flw_ref'];
         $pay->payment_method   = 'Flutterwave';
         $pay->payment_date     = date('Y-m-d H:i:s');
         $pay->invoice_code     = $code;
         $pay->customer_code    = $business->business_code;
         $pay->save();

         //Client Credit
         // if($invoice->paid > $invoice->total) {
         //    //update creditnote number
         //    $setting = creditnote_settings::find(1);

         //    $creditAmount = $invoice->paid - $invoice->total;

         //    $credit					      = new creditnote;
         //    $total                     = $creditAmount;
         //    $credit->customer_code	 	= $business->business_code;
         //    $credit->creditnote_number = $setting->number+1;
         //    $credit->total		         = $total;
         //    $credit->balance		      = $total;
         //    $credit->title             = 'Payment credit for invoice #'.$invoice->invoice_number;
         //    $credit->sub_total		   = $total;
         //    $credit->creditnote_date   = date('Y-m-d');
         //    $credit->status		      = 21;
         //    $credit->paymentID         = $pay->id;
         //    $credit->business_code 	   = $business->business_code;
         //    $credit->save();

         //    //products
         //    $product 					= new creditnote_products;
         //    $product->creditnoteID  = $credit->id;
         //    $product->product_name	= 'Payment credit for invoice #'.$invoice->invoice_number;
         //    $product->quantity		= 1;
         //    $product->price    		= $total;
         //    $product->save();

         //    $setting->number = $setting->number + 1;
         //    $setting->save();

         //    //update payment
         //    $updateCredit = invoice_payments::find($pay->id);
         //    $updateCredit->credited = 'yes';
         //    $updateCredit->creditID = $credit->id;
         //    $updateCredit->save();
         // }

         Session::flash('success','Payment successful');

         return redirect()->route('wingu.dashboard');

      }elseif($status ==  'cancelled'){
         //Put desired action/code after transaction has been cancelled here
      }else{
        //Put desired action/code after transaction has failed here
      }
   }
}
