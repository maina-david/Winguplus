<?php

namespace App\Http\Controllers\app\finance\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\hr\employees;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Mail\systemMail;
use App\Models\wingu\wp_user;
use DB;
use Session;
use Finance;
use Wingu;
use Auth;
use Helper;
use Mail;
class productinvoiceController extends Controller
{
	public function __construct(){
      $this->middleware('auth');
	}

   public function create(){
		//check if account has settings
		$check = invoice_settings::where('business_code',Auth::user()->business_code)->count();
		if($check != 1){
			Finance::invoice_setting_setup();
		}

   	$taxs = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

		$salespersons = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('Choose sales person','');

		return view('app.finance.invoices.product.create', compact('taxs','salespersons'));
   }

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
  	public function store(Request $request){
		$this->validate($request, array(
			'customer'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		$invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();

		$code = Helper::generateRandomString(16);

		//store invoice
		$store					   = new invoices;
      $store->invoice_code 	= $code;
		$store->customer	 	   = $request->customer;
		$store->invoice_title	= $request->invoice_title;
		$store->lpo_number      = $request->lpo_number;
		$store->income_category = $request->income_category;
		$store->invoice_number  = $request->invoice_number;
		$store->invoice_prefix  = $invoiceSettings->prefix;
		$store->invoice_date	   = $request->invoice_date;
		$store->invoice_due	   = $request->invoice_due;
		$store->customer_note	= $request->customer_note;
		$store->terms				= $request->terms;
		$store->sales_person   	= $request->sales_person;
		$store->tax_config		= $request->tax_config;
		$store->invoice_type		= 'Product';
		$store->status		      = 2;
      $store->created_by		= Auth::user()->user_code;
		$store->branch 		   = Auth::user()->branch_code;
		$store->business_code 	= Auth::user()->business_code;
		$store->save();

		//products
		$products				= $request->product_code;

		foreach ($products as $k => $v){
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;
			$taxvalue = $amount * $rate;
			$totalAmount = $amount + $taxvalue;

			$product 					= new invoice_products;
			$product->invoice_code	= $code;
			$product->product_code	= $request->product_code[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->tax_rate		= $request->tax[$k];
			$product->tax_value		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->business_code = Auth::user()->business_code;
			$product->selling_price = $request->price[$k];
			$product->category      = 'Product';
			$product->save();

			//product information
			$productInfo = product_information::where('product_code',$request->product_code[$k])->where('business_code',Auth::user()->business_code)->first();

			//reduce quantity
			if($productInfo->track_inventory = 'Yes'  && $productInfo->track_inventory != ""){
				$inventory = product_inventory::where('business_code',Auth::user()->business_code)
                                          ->where('default_inventory','Yes')
                                          ->where('product_code',$request->product_code[$k])
                                          ->first();

				if($inventory->current_stock > $request->qty[$k]){
					$inventory->current_stock = $inventory->current_stock - $request->qty[$k];

					//send inventory notification if below reorder point
					if($inventory->current_stock < $inventory->reorder_point){
						if($inventory->notification < 2){
							//send email
							$subject = 'WinguPlus Stock Level Notification';
							$to = Wingu::business()->primary_email;
							$content = '<p>The following product needs to be restocked<br><b>Product:</b> '.$productInfo->product_name.'<br><b>Current Stock</b> '.$inventory->current_stock.'<br> <b>Reorder Quantity</b> '.$inventory->reorder_qty.'</p>';
							Mail::to($to)->send(new systemMail($content,$subject));

							$inventroyNotification = product_inventory::where('business_code',Auth::user()->business_code)
																					->where('default_inventory','Yes')
																					->where('product_code',$request->product_code[$k])
																					->first();
							$inventroyNotification->notification = $inventroyNotification->notification + 1;
							$inventroyNotification->save();
						}
					}
				}else {
					$inventory->current_stock = 0;
				}
				$inventory->save();
			}
		}

		//get invoice products
		$invoiceProducts = invoice_products::where('invoice_code',$code)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as taxvalue'))
								->first();

		//update invoice
		$invoice = invoices::where('id',$store->id)->where('business_code',Auth::user()->business_code)->first();
		$invoice->main_amount  = $invoiceProducts->mainAmount;
		$invoice->discount     = $invoiceProducts->discount;
		$invoice->total        = $invoiceProducts->total;
		$invoice->balance		  = $invoiceProducts->total;
		$invoice->sub_total	  = $invoiceProducts->sub_total;
		$invoice->tax_value	  = $invoiceProducts->taxvalue;
		$invoice->save();

		//invoice setting
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

		//recored activity
		$activity= 'Invoices #'.Finance::invoice_settings()->prefix.$store->invoice_number.' has been created by '.Auth::user()->name;
		$module = 'Finance';
		$section = 'Invoice';
      $action = 'Create';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','Invoice has been successfully created');

		return redirect()->route('finance.invoice.index');

   }

	public function edit($code){

		$invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->join('wp_status','wp_status.id','=','fn_invoices.status')
                           ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                           ->join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                           ->where('fn_invoices.invoice_code',$code)
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->select('*','fn_invoices.invoice_code as invoiceCode','wp_business.name as businessName')
                           ->first();

		$clients = customers::where('business_code',Auth::user()->business_code)
                            ->OrderBy('id','DESC')
                            ->get();

		$client = customers::where('customer_code',$invoice->customer)->where('business_code',Auth::user()->business_code)->first();

		$taxs = tax::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->get();

		$Itemproducts = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.product_code')
												->where('fn_product_information.type','product')
												->where('default_inventory','Yes')
												->where('fn_product_information.business_code',Auth::user()->business_code)
												->OrderBy('fn_product_information.id','DESC')
												->select('*','fn_product_information.id as product_code')
												->get();

		$Itemservice = product_information::join('fn_product_inventory','fn_product_inventory.product_code','=','fn_product_information.id')
												->where('fn_product_information.type','service')
												->where('default_inventory','Yes')
												->where('fn_product_information.business_code',Auth::user()->business_code)
												->OrderBy('fn_product_information.id','DESC')
												->select('*','fn_product_information.id as product_code')
												->get();

		$salespersons = employees::where('business_code',Auth::user()->business_code)->pluck('names','employee_code')->prepend('Choose sales person','');
      $invoiceProducts = invoice_products::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->get();

		return view('app.finance.invoices.product.edit', compact('client','clients','invoice','Itemproducts','taxs','invoiceProducts','salespersons','Itemservice'));
	}

	public function update(request $request,$code){
		$this->validate($request, array(
			'customer'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		//get the invoice products the update their quantity
		$oldProducts = invoice_products::where('business_code',Auth::user()->business_code)->where('invoice_code',$code)->get();
		foreach($oldProducts as $oldPro){

			//get the invoice product
			$oldInvoiceProduct = invoice_products::where('id',$oldPro->id)->where('business_code',Auth::user()->business_code)->where('invoice_code',$code)->first();

			//get product details
			$productSpecs = product_information::where('product_code',$oldPro->product_code)->where('business_code',Auth::user()->business_code)->first();

			if($productSpecs->type == 'product' && $productSpecs->track_inventory == 'Yes'){
				//return the quantity
				$returnInventory = product_inventory::where('business_code',Auth::user()->business_code)
                                          ->where('default_inventory','Yes')
                                          ->where('product_code',$productSpecs->product_code)
                                          ->first();
				$returnInventory->current_stock = $returnInventory->current_stock + $oldInvoiceProduct->quantity;
				$returnInventory->save();
			}

			$oldInvoiceProduct->delete();
		}

		$invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();
		$update	= invoices::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->first();

		//add new products
		$products  = $request->product_code;
		foreach ($products as $k => $v){
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;

			$totalAmount = $amount + $taxvalue;

			$product 					= new invoice_products;
			$product->invoice_code	= $code;
			$product->product_code	= $request->product_code[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->tax_rate		= $request->tax[$k];
			$product->tax_value		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->business_code = Auth::user()->business_code;
			$product->selling_price = $request->price[$k];
			$product->category      = 'Product';
			$product->save();

			//product information
			$productInfo = product_information::where('product_code',$request->product_code[$k])
                                          ->where('business_code',Auth::user()->business_code)
                                          ->first();

			//reduce quantity
			if($productInfo->type == 'product' && $productInfo->track_inventory == 'Yes'){
				$inventory = product_inventory::where('business_code',Auth::user()->business_code)
                                          ->where('default_inventory','Yes')
                                          ->where('product_code',$request->product_code[$k])
                                          ->first();

				if($inventory->current_stock > $request->qty[$k]){
					$inventory->current_stock = $inventory->current_stock - $request->qty[$k];
				}else {
					$inventory->current_stock = 0;
				}
				$inventory->save();
			}
		}

		//get invoice products
      $invoiceProducts = invoice_products::where('invoice_code',$code)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(tax_value) as taxvalue'))
								->first();

		$update->main_amount     =  $invoiceProducts->mainAmount;
		$update->discount        = $invoiceProducts->discount;
		if($invoiceSettings->prefix == ""){
			$update->invoice_prefix  = $invoiceSettings->prefix;
		}
		$update->invoice_number  = $request->invoice_number;
		$update->total		       = $invoiceProducts->total;
		$update->balance		    = $invoiceProducts->total - $update->paid;
		$update->sub_total	    = $invoiceProducts->sub_total;
		$update->tax_value	    = $invoiceProducts->taxvalue;
		$update->invoice_title   = $request->invoice_title;
		$update->customer	       = $request->customer;
		$update->sales_person    = $request->sales_person;
		$update->income_category = $request->income_category;
		$update->lpo_number      = $request->lpo_number;
		$update->invoice_date    = $request->invoice_date;
		$update->invoice_due	    = $request->invoice_due;
		$update->customer_note   = $request->customer_note;
		$update->terms			    = $request->terms;
		$update->tax_config	    = $request->taxconfig;
		$update->business_code 	 = Auth::user()->business_code;
      $update->updated_by	    = Auth::user()->user_code;
		$update->save();

      //recored activity
		$activity=  'Invoices #'.$update->invoice_prefix.$update->invoice_number.' has been updated by '.Auth::user()->name;
		$module = 'Finance';
		$section = 'Invoice';
      $action = 'update';
		$activityCode = $code;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

		Session::flash('success','Invoice has been successfully updated');

    	return redirect()->back();
	}
}
