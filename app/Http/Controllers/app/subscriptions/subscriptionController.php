<?php

namespace App\Http\Controllers\app\subscriptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\subscriptions\subscriptions;
use App\Models\subscriptions\settings;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\invoice_creditnote;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\income\category;
use App\Models\finance\payments\payment_type;
use App\Models\hr\employees;
use App\Models\finance\tax;
use DB;
use Session;
use Finance;
use Wingu;
use Auth;
use Helper; 

class subscriptionController extends Controller
{
   // public function __construct(){
	// 	$this->middleware('auth'); 
	// }

   //list all subscriptions
   public function index(){
		$subscriptions = subscriptions::join('wp_business','wp_business.business_code','=','subscriptions.business_code')
									->join('subscription_settings','subscription_settings.business_code','=','business.business_code')
									->join('customers','customers.id','=','subscriptions.customer')
									->join('product_information','product_information.product_code','=','subscriptions.plan')
									->join('product_price','product_price.product_code','=','product_information.product_code')
									->join('status','status.id','=','subscriptions.status')
									->where('subscriptions.business_code',Auth::user()->business_code)
									->orderby('subscriptions.id','desc')
									->select('*','status.name as statusName','subscriptions.id as subscriptionID','subscriptions.status as status','subscriptions.created_at as created_at')
									->get();
      return view('app.subscriptions.subscriptions.index', compact('subscriptions'));
   }

   //create subscription
   public function create(){
		//check if settings is linked 
		$settings = settings::where('business_code',Auth::user()->business_code)->count();

		if($settings != 1){
			$setting = new settings;
			$setting->business_code = Auth::user()->business_code;
			$setting->created_by = Auth::user()->id;
			$setting->prefix = 'SUB00';
			$setting->save();
		}

		//check invoice settings 
		$check = invoice_settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::invoice_setting_setup();
		}

      $products = product_information::where('product_information.business_code', Auth::user()->business_code)
                     ->where('type','subscription')
                     ->orderBy('id','desc')
							->get();
							
      $customers =  customers::join('business','business.business_code','=','customers.business_code')
									->where('customers.business_code',Auth::user()->business_code)
									->whereNull('category')
									->select('*','customers.id as customer_code','customers.created_at as date_added')
									->OrderBy('customers.id','DESC')
									->get();
		$taxs = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
		$employees = employees::where('hr_employees.business_code',Auth::user()->business_code)->where('hr_employees.status',25)->get(); 
      
      return view('app.subscriptions.subscriptions.create', compact('products','customers','taxs','employees'));
   }

   //store subscription 
   public function store(Request $request){ 
		$this->validate($request, array(
			'customer'   => 'required',
			'product' => 'required',
			'starts_on' => 'required',
			'expiration_cycle' => 'required',
			'product_code' => 'required',
			'qty' => 'required',
			'price' => 'required',
			'subscription_number' => 'required'
		));

		$code = Helper::generateRandomString(16);
		$invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		//check if subscription has trial
		if($request->trial_days != 0 || $request->trial_days != NULL){
			$trialDays = $request->trial_days;

			//add trial days to starting date
			$billingStart = date('Y-m-d', strtotime($request->starts_on. ' + '.$trialDays.' days'));
		}

		//store invoice
		$store					   = new invoices;
		$store->created_by		= Auth::user()->id;
		$store->customer_code	 	= $request->customer;
		$store->income_category = $request->income_category;
		$store->invoice_number  = $invoiceSettings->number + 1;
		$store->invoice_date	   = $request->starts_on;
		if($request->trial_days != 0){
			$store->invoice_title = 'Discounted subscription invoice';			
			$store->invoice_due = $billingStart;
		}else{
			$store->invoice_title	= 'subscription Invoice';
		}
		$store->salesperson   	= $request->sales_person;
		$store->invoice_type		= 'Subscription';
		if($request->trial_days != 0){
			$store->status		   = 1;
		}else{
			$store->status		   = 2;
		}
		$store->invoice_code 	= $code;
		$store->business_code 		= Auth::user()->business_code;
		$store->save();

		//products
		$mainAmount = $request->price * $request->qty;
		$amount = ($request->price * $request->qty) - $request->discount;

		$rate = $request->tax/100;

		$taxvalue = $amount * $rate;
		
		$totalAmount = $amount + $taxvalue;

		$product 					= new invoice_products;
		$product->invoice_code		= $store->id;
		$product->product_code		= $request->product_code;
		$product->quantity		= $request->qty;
		if($request->trial_days != 0){
			$product->discount	= $amount;
		}else{
			$product->discount	= $request->discount;
		}
		$product->taxrate			= $request->tax;		
		if($request->trial_days != 0){
			$product->taxvalue		= 0; 
			$product->total_amount  = $amount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
		}else{
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
		}		
		$product->business_code  	= Auth::user()->business_code;
		$product->selling_price = $request->price;
		$product->category      = 'Product';
		$product->save();

		//get invoice products
		$invoiceProducts = invoice_products::where('invoice_code',$store->id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'),'product_code as product_code')
								->first();

		//plan information
		$plan = product_information::where('id',$invoiceProducts->product_code)->where('business_code',Auth::user()->business_code)->first();
		$month = 30;
		$week = 7;
		$year = 1;		

		//update invoice 
		$invoice = invoices::where('id',$store->id)->where('business_code',Auth::user()->business_code)->first(); 

		//billing cycle calculation
		if($request->trial_days == 0 || $request->trial_days == ""){
			if($plan->billing_period == 'Month'){
				//count days
				$countDays = $plan->bill_count * $month;
				$invoice_due = date('Y-m-d', strtotime($request->starts_on. ' + '.$countDays.' days'));
				$invoice->invoice_due = $invoice_due;
			}

			if($plan->billing_period == 'Week'){
				//count days
				$countDays = $plan->bill_count * $week;
				$invoice_due = date('Y-m-d', strtotime($request->starts_on. ' + '.$countDays.' days'));
				$invoice->invoice_due = $invoice_due;
			}

			if($plan->billing_period == 'Year'){
				//count days
				$countDays = $plan->bill_count * $year;
				$invoice_due = date('Y-m-d', strtotime($request->starts_on. ' + '.$countDays.' year'));
				$invoice->invoice_due = $invoice_due;
			}						
		}
		
		//calculate invoice amount
		$invoice->main_amount   = $invoiceProducts->mainAmount;
		if($request->trial_days != 0){
			$invoice->discount    = $invoiceProducts->total;
			$invoice->balance		 = 0;
		}else{
			$invoice->discount     = $invoiceProducts->discount;
			$invoice->balance		  = $invoiceProducts->total;
		}
		$invoice->total		  = $invoiceProducts->total;		
		$invoice->sub_total	  = $invoiceProducts->sub_total; 
		$invoice->taxvalue	  = $invoiceProducts->taxvalue; 
		$invoice->save();
		
		//invoice setting
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

		//subscription
		$subscription						      = new subscriptions;	
		$subscription->customer 	         = $request->customer;
		$subscription->subscription_number 	= $request->subscription_number;
		$subscription->reference 				= $request->reference;
		$subscription->starts_on 				= $request->starts_on;
		if($request->trial_days != 0){
			$subscription->next_billing 		= $billingStart;
			$subscription->trial_end_date    = $billingStart;
		}else{
			$subscription->next_billing 		= $invoice_due;
		}		
		$subscription->last_billing 			= $request->starts_on;
		$subscription->sales_person 			= $request->sales_person;
		$subscription->expiration_cycle     = $request->expiration_cycle;
		$subscription->cycles 					= $request->cycles;
		$subscription->amount 					= $invoiceProducts->total;
		$subscription->price 					= $request->price;
		$subscription->trial_days 				= $request->trial_days;
		$subscription->product 					= $request->product;
		$subscription->plan 						= $invoiceProducts->product_code;
		$subscription->qty 						= $request->qty;
		$subscription->tax_rate 				= $request->tax;
		if($request->trial_days != 0){
			$subscription->status 				= 36;
		}else{
			if($request->payment_status == 'Yes' || $request->amount_paid != ""){
				$subscription->status 			= 36;
			}else{
				$subscription->status 			= 7;
			}			
		}
		$subscription->business_code 				= Auth::user()->business_code;
		$subscription->created_by 				= Auth::user()->id;
		$subscription->save();


		//update invoice 
		$invoice2 = invoices::where('id',$store->id)->where('business_code',Auth::user()->business_code)->first(); 
		$invoice2->subscriptionID = $subscription->id;
		$invoice2->save();

		//subscription setting
		$settings = settings::where('business_code',Auth::user()->business_code)->first();
		$subNumber 	= $settings->number + 1;
		$settings->number	= $subNumber;
		$settings->save();

		//record activity
		$activities = 'Subscription #'.Finance::subscription_settings()->prefix.$subscription->subscription_number.' has been created by '.Auth::user()->name;
		$section = 'Subscription';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $subscription->id;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','Subscription has been successfully created');

		return redirect()->route('subscriptions.index');

	}
	
	//get product plan
	public function plan($id){
		$plan = product_information::join('product_price','product_price.product_code','=','product_information.product_code')
											  ->where('parentID',$id)
											  ->where('type','plan')
											  ->where('product_information.business_code',Auth::user()->business_code)
											  ->select('product_information.product_name as product_name','product_information.product_code as product_code','product_price.selling_price as selling_price','product_information.trial_days as trial_days')
											  ->orderby('product_information.product_code','desc')
											  ->get();
  
      return \Response::json($plan);
	}

	//get plan price
	public function plan_price($id){
		$prices = product_price::where('product_code',$id)->where('business_code',Auth::user()->business_code)->get();
		return \Response::json($prices);
	}

	//subscription details
	public function show($id){
		$subscription = subscriptions::join('business','business.business_code','=','subscriptions.business_code')
								->join('currency','currency.id','=','business.base_currency')
								->join('subscription_settings','subscription_settings.business_code','=','business.business_code')
								->join('customers','customers.id','=','subscriptions.customer')
								->join('product_information','product_information.product_code','=','subscriptions.plan')
								->join('product_price','product_price.product_code','=','product_information.product_code')
								->join('status','status.id','=','subscriptions.status')
								->where('subscriptions.business_code',Auth::user()->business_code)
								->where('subscriptions.id',$id)
								->select('*','status.name as statusName','subscriptions.id as subscriptionID')
								->first();
		$customer = customers::where('id',$subscription->customer)->where('business_code',Auth::user()->business_code)->first();
		$checkContactPerson = contact_persons::where('customer_code',$customer->id)->where('business_code',Auth::user()->business_code)->count();
		$contactPersons = contact_persons::where('customer_code',$customer->id)->where('business_code',Auth::user()->business_code)->get();
		
		return view('app.subscriptions.subscriptions.show', compact('subscription','customer','checkContactPerson','contactPersons'));
	}

	//subscription invoice
	public function invoices($id){
		$subscription = subscriptions::join('business','business.business_code','=','subscriptions.business_code')
								->join('currency','currency.id','=','business.base_currency')
								->join('subscription_settings','subscription_settings.business_code','=','business.business_code')
								->join('customers','customers.id','=','subscriptions.customer')
								->join('product_information','product_information.product_code','=','subscriptions.plan')
								->join('product_price','product_price.product_code','=','product_information.product_code')
								->join('status','status.id','=','subscriptions.status')
								->where('subscriptions.business_code',Auth::user()->business_code)
								->where('subscriptions.id',$id)
								->select('*','status.name as statusName','subscriptions.id as subscriptionID')
								->first();
		$customer = customers::where('id',$subscription->customer)->where('business_code',Auth::user()->business_code)->first();
		$checkContactPerson = contact_persons::where('customer_code',$customer->id)->where('business_code',Auth::user()->business_code)->count();
		$contactPersons = contact_persons::where('customer_code',$customer->id)->where('business_code',Auth::user()->business_code)->get();
		$invoices	= invoices::join('customers','customers.id','=','invoices.customer_code')
										->join('business','business.business_code','=','invoices.business_code')
										->join('currency','currency.id','=','business.base_currency')
										->join('invoice_settings','invoice_settings.business_code','=','invoices.business_code')
										->join('status','status.id','=','invoices.status')
										->where('subscriptionID',$id)
										->where('invoices.business_code',Auth::user()->business_code)
										->select('*','invoices.id as invoice_code','status.name as statusName')
										->orderby('invoices.invoice_date','desc')
										->get();

		$count = 1;
		return view('app.subscriptions.subscriptions.show', compact('subscription','customer','checkContactPerson','contactPersons','invoices','count'));
	}

	//edit subscription
	public function edit($id){
		//subscription 
		$subscription = subscriptions::where('business_code',Auth::user()->business_code)->where('id',$id)->first();

		$invoice = invoices::join('business','business.business_code','=','invoices.business_code')
					->join('currency','currency.id','=','business.base_currency')
					->join('status','status.id','=','invoices.status')
					->join('invoice_settings','invoice_settings.business_code','=','invoices.business_code')
					->join('customers','customers.id','=','invoices.customer_code')
					->where('invoices.subscriptionID',$subscription->id)
					->where('invoices.business_code',Auth::user()->business_code)
					->select('*','invoices.id as invoice_code','business.name as businessName')
					->orderby('invoices.id','desc')
					->first();

		$clients = customers::where('business_code',Auth::user()->business_code)
                            ->where('category', '=', 'Subscriber')
                            ->orWhereNull('category')
                            ->OrderBy('id','DESC')
									 ->get();
									 
		$client = customers::where('id',$invoice->customer_code)->where('business_code',Auth::user()->business_code)->first();

		$taxs = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();
		$products = product_information::where('product_information.business_code', Auth::user()->business_code)
                     ->where('type','subscription')
                     ->orderBy('id','desc')
							->get();
		$salespersons = employees::where('business_code',Auth::user()->business_code)->pluck('names','id')->prepend('Choose salse person','');
		$currencies = currency::OrderBy('id','DESC')->get();
		$currency = currency::find($invoice->currencyID);
      $invoiceProducts = invoice_products::where('invoice_code',$invoice->invoice_code)->get();
		$count = 1;

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		return view('app.subscriptions.subscriptions.edit', compact('client','clients','currency','taxed','count','invoice','products','currencies','taxs','invoiceProducts','salespersons','subscription'));
	}

	//update subscription
	public function update(Request $request,$id){
		$this->validate($request, array(
			'customer'  => 'required',
			'product'   => 'required',
			'starts_on' => 'required',
			'due_date'  => 'required',
			'expiration_cycle' => 'required',
			'product_code' => 'required',
			'qty' => 'required',
			'price' => 'required',
		));

		//invoice 
		$invoice = invoices::where('id',$id)->where('business_code',Auth::user()->business_code)->first(); 

		//store invoice
		$invoice->updated_by		   = Auth::user()->id;
		$invoice->customer_code	 	   = $request->customer;
		$invoice->invoice_date	   = $request->starts_on;
		$invoice->invoice_due   	= $request->due_date;
		$invoice->invoice_title	   = $request->invoice_title;
		$invoice->salesperson   	= $request->salesperson;
		$invoice->income_category  = $request->income_category;
		$invoice->business_code 		= Auth::user()->business_code;
		$invoice->save();

		//products
		$mainAmount = $request->price * $request->qty;
		$amount = ($request->price * $request->qty) - $request->discount;
		$rate = $request->tax/100;
		$taxvalue = $amount * $rate;		
		$totalAmount = $amount + $taxvalue;

		$product 					= invoice_products::where('product_code',$request->product_code)->where('invoice_code',$id)->where('business_code',Auth::user()->business_code)->first();
		$product->invoice_code		= $id;
		$product->product_code		= $request->product_code;
		$product->quantity		= $request->qty;
		$product->discount	   = $request->discount;
		$product->taxrate			= $request->tax;		
		$product->taxvalue		= $taxvalue; 
		$product->total_amount  = $totalAmount;
		$product->main_amount   = $mainAmount;
		$product->sub_total  	= $amount;
		$product->business_code  	= Auth::user()->business_code;
		$product->selling_price = $request->price;
		$product->category      = 'Product';
		$product->save();

		//get invoice products
		$invoiceProducts = invoice_products::where('invoice_code',$id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'),'product_code as product_code')
								->first();

		//update invoice 
		$invoice = invoices::where('id',$id)->where('business_code',Auth::user()->business_code)->first(); 		
		$invoice->main_amount  = $invoiceProducts->mainAmount;
		$invoice->discount     = $invoiceProducts->discount;
		$invoice->balance		  = $invoiceProducts->total;
		$invoice->total		  = $invoiceProducts->total;		
		$invoice->sub_total	  = $invoiceProducts->sub_total; 
		$invoice->taxvalue	  = $invoiceProducts->taxvalue; 
		$invoice->save();

		//subscription
		$subscription						      = subscriptions::where('business_code',Auth::user()->business_code)->where('id',$invoice->subscriptionID)->first();	
		$subscription->customer 	         = $request->customer;
		$subscription->subscription_number 	= $request->subscription_number;
		$subscription->reference 				= $request->reference;
		$subscription->last_billing 			= $request->starts_on;
		$subscription->next_billing 			= $request->due_date;
		$subscription->sales_person 			= $request->salesperson;
		$subscription->expiration_cycle     = $request->expiration_cycle;
		$subscription->cycles 					= $request->cycles;
		$subscription->amount 					= $invoiceProducts->total;
		$subscription->price 					= $request->price;
		$subscription->trial_days 				= $request->trial_days;
		$subscription->product 					= $request->product;
		$subscription->plan 						= $invoiceProducts->product_code;
		$subscription->qty 						= $request->qty;
		$subscription->tax_rate 				= $request->tax;
		$subscription->business_code 				= Auth::user()->business_code;
		$subscription->updated_by 				= Auth::user()->id;
		$subscription->save();

		//update invoice 
		$invoice2 = invoices::where('id',$id)->where('business_code',Auth::user()->business_code)->first(); 
		$invoice2->subscriptionID = $subscription->id;
		$invoice2->save();

		//record activity
		$activities = 'Subscription #'.Finance::subscription_settings()->prefix.$subscription->subscription_number.' has been updated by '.Auth::user()->name;
		$section = 'Subscription';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $subscription->id;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','Subscription has been successfully updated');

		return redirect()->back();
	}

	/**
	* Renew subscription
	*/
	public function renew($id){
		$code = Helper::generateRandomString(16);
		$invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		$invoice = invoices::where('invoices.subscriptionID',$id)
									->where('invoices.business_code',Auth::user()->business_code)
									->first();
									
		//store invoices
		$store					    = new invoices;

		//get plan information
		$plan = invoice_products::where('invoice_code',$invoice->id)->where('business_code',Auth::user()->business_code)->first();
		$plan = product_information::where('id',$plan->product_code)->where('business_code',Auth::user()->business_code)->first();
		$month = 30;
		$week = 7;
		$year = 1;	
		$renew_date = date('Y-m-d');	

		//due date calculation
		if($plan->billing_period == 'Month'){
			//count days
			$countDays = $plan->bill_count * $month;
			$invoice_due = date('Y-m-d', strtotime($renew_date. ' + '.$countDays.' days'));
			$store->invoice_due = $invoice_due;
		}

		if($plan->billing_period == 'Week'){
			//count days
			$countDays = $plan->bill_count * $week;
			$invoice_due = date('Y-m-d', strtotime($renew_date. ' + '.$countDays.' days'));
			$store->invoice_due = $invoice_due;
		}

		if($plan->billing_period == 'Year'){
			//count days
			$countDays = $plan->bill_count * $year;
			$invoice_due = date('Y-m-d', strtotime($renew_date. ' + '.$countDays.' year'));
			$store->invoice_due = $invoice_due;
		}						

		$store->created_by		 = Auth::user()->id;
		$store->customer_code	 	 = $invoice->customer_code;
		$store->income_category  = $invoice->income_category;
		$store->subscriptionID   = $id;
		$store->invoice_number   = $invoiceSettings->number + 1;
		$store->invoice_date	    = $renew_date;
		$store->invoice_title	 = $invoice->invoice_title;
		$store->salesperson   	 = $invoice->salesperson;
		$store->invoice_type		 = 'Subscription';
		$store->status		    = 2;
		$store->invoice_code 	 = $code;
		$store->business_code 		 = Auth::user()->business_code;
		$store->main_amount  	 = $invoice->main_amount;
		$store->discount         = $invoice->discount;
		$store->balance		    = $invoice->balance;
		$store->total		       = $invoice->total;		
		$store->sub_total	       = $invoice->sub_total; 
		$store->taxvalue	       = $invoice->taxvalue; 
		$store->save();

		//invoice setting
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

		//invoice products
		$invoiceProduct = invoice_products::where('invoice_code',$invoice->id)->where('business_code',Auth::user()->business_code)->get();
		
		foreach($invoiceProduct as $theProduct){
			$renewed_products =  invoice_products::where('id',$theProduct->id)
															->where('invoice_code',$invoice->id)
															->where('business_code',Auth::user()->business_code)
															->first();

			$product 					= new invoice_products;
			$product->invoice_code		= $store->id;
			$product->product_code		= $renewed_products->product_code;	
			$product->quantity		= $renewed_products->quantity;
			$product->discount	   = $renewed_products->discount;
			$product->taxrate			= $renewed_products->taxrate;
			$product->taxvalue		= $renewed_products->taxvalue;	
			$product->total_amount  = $renewed_products->total_amount;
			$product->main_amount   = $renewed_products->main_amount;
			$product->sub_total  	= $renewed_products->sub_total;
			$product->selling_price = $renewed_products->selling_price;
			$product->business_code  	= Auth::user()->business_code;			
			$product->category      = 'Product';
			$product->save();
		}

		//update subscription
		$subscription = subscriptions::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
		$subscription->next_billing = $invoice_due;
		$subscription->last_billing = $renew_date;
		$subscription->save();
		
		Session::flash('success','Subscription successfully renewed');

		return redirect()->back();
	}

	//delete subscription 
	public function delete($id){
		return redirect()->back();
	}
}
