<?php

namespace App\Http\Controllers\app\subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_products;
use App\Models\subscriptions\subscriptions;
use App\Models\finance\creditnote\invoice_creditnote;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\income\category;
use App\Models\wingu\file_manager as docs;
use App\Models\crm\emails;
use App\Models\finance\payments\payment_type;
use App\Models\finance\accounts;
use App\Mail\sendInvoices;
use App\Mail\sendMessage;
use Input;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

class invoiceController extends Controller
{
   public function index(){
      $invoices	= invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
										->join('invoice_settings','invoice_settings.businessID','=','invoices.businessID')
										->join('status','status.id','=','invoices.statusID')
										->where('invoice_type','Subscription')
										->where('invoices.businessID',Auth::user()->businessID)
										->select('*','invoices.id as invoiceID','status.name as statusName')
										->orderby('invoices.id','desc')
                              ->get();
                              
      return view('app.subscriptions.invoice.index', compact('invoices'));
	}
	
	public function show($id){
		$count = 1;
		$filec = 1;

		$invoice = invoices::join('business','business.id','=','invoices.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->join('status','status.id','=','invoices.statusID')
					->join('invoice_settings','invoice_settings.businessID','=','invoices.businessID')
					->where('invoices.id',$id)
					->where('invoices.businessID',Auth::user()->businessID)
					->select('*','invoices.id as invoiceID','business.name as businessName','invoices.statusID as invoiceStatusID')
					->first();

		$products = invoice_products::where('invoiceID',$invoice->invoiceID)->get();
		$payments = invoice_payments::where('invoiceID',$id)->where('businessID',Auth::user()->businessID)->get();

		$paymenttypes = payment_type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose payment method','');

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		$files = docs::where('fileID',$id)->where('section','invoice')->where('businessID',Auth::user()->businessID)->get();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->where('customers.id',$invoice->customerID)
					->where('businessID',Auth::user()->businessID)
					->select('*','customers.id as clientID','bill_country as countryID')
					->first();
		$persons = contact_persons::where('customerID',$client->clientID)->get();

		$accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

		$categories = category::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose income category','');

		$template = Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name;

		return view('app.subscriptions.invoice.show', compact('client','invoice','products','count','taxed','filec','files','persons','payments','paymenttypes','accounts','categories','template'));
	}

	
}
