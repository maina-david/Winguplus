<?php

namespace App\Http\Controllers\app\pos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\payments\payment_methods;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\address;
use App\Models\finance\invoice\invoices;
use App\Models\finance\pos\cart;
use App\Models\hr\branches;
use App\Models\wingu\file_manager as docs;
use App\Mail\sendPosReceipt;
use App\Mail\systemMail;
use Auth;
use Wingu;
use PDF;
use Helper;
use Session;
use Mail;
use DB;

class posController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function dashboard(){
		$month = date('m');
		$year = date('Y');
		$customers = customers::where('business_code',Auth::user()->business_code)->whereMonth('created_at','=',$month)->count();
		$todaySales = invoices::where('business_code',Auth::user()->business_code)->where('invoice_type','POS')->where('invoice_date', date('Y-m-d'))->sum('paid');

		$monthSales = invoices::where('business_code',Auth::user()->business_code)->where('invoice_type','POS')->whereMonth('invoice_date',$month)->sum('paid');
		$itemsSold = invoices::join('fn_invoice_products','fn_invoice_products.invoice_code','=','fn_invoices.invoice_code')
									->where('fn_invoices.business_code',Auth::user()->business_code)
									->where('invoice_type','POS')
									->whereMonth('invoice_date',$month)
									->sum('quantity');

		if($itemsSold == 0 || $monthSales == 0){
			$averageSale = 0;
		}else{
			$averageSale = $monthSales / $itemsSold;
		}

		$salesThisYear = invoices::where('business_code',Auth::user()->business_code)
										->where('invoice_type','POS')
										->whereYear('invoice_date',$year)
										->groupBy(DB::raw("Month(invoice_date)"))
										->select(DB::raw('SUM(paid) as total'))
										->pluck('total');

		$salesperMonth = invoices::select(DB::raw('Month(invoice_date) as month'))
										->where('business_code',Auth::user()->business_code)
										->where('invoice_type','POS')
										->whereYear('invoice_date',$year)
										->groupBy(DB::raw("Month(invoice_date)"))
										->pluck('month');

		$datas = array(0,0,0,0,0,0,0,0,0,0,0,0);

		foreach($salesperMonth as $index=>$month){
			$datas[$month - 1] = intval($salesThisYear[$index]);
		}

      $business = Wingu::business();

      return view('app.pos.dashboard.dashboard', compact('customers','todaySales','averageSale','monthSales','itemsSold','datas','year','business'));
   }

   //sales dashboard
   public function sales(){
		//check if user is linked to an existing store/branch
		$checkBranch = branches::where('branch_code',Auth::user()->branch_code)->where('business_code',Auth::user()->business_code)->count();
		if($checkBranch == 1){
			return view('app.pos.sales.terminal');
		}else{
			Session::flash('warning','Please ask your admin to add you to an existing branch');
			return redirect()->back();
		}
   }

	//update cart
	public function update_cart(Request $request,$cartID){
		$this->validate($request, [
			'quantity' => 'required',
		]);

		$cart = cart::where('business_code',Auth::user()->business_code)->where('id',$cartID)->where('created_by',Auth::user()->user_code)->first();
		$amount = $cart->price * $request->quantity;
		$amountAfterDiscount = $amount - $request->discount;

		$cart->note = $request->note;
		$cart->qty = $request->quantity;
		$cart->amount = $amount;
		$cart->discount = $request->discount;
		$cart->total_amount = $amountAfterDiscount;
		$cart->save();

		Session::flash('success','cart successfully updated');

		return redirect()->back();
	}

	//apply tax
	public function apply_sale(Request $request){
		session()->put('taxRate',[
         'rate' => $request->taxRate,
      ]);

		Session::flash('success','Tax successfully added');

		return redirect()->back();
	}

	//remove tax
	public function remove_tax(){
		session()->forget('taxRate');

		Session::flash('success','Tax successfully removed');

		return redirect()->back();
	}

	//remove item from cart
	public function remove_cart_item($id){
		cart::where('id',$id)->where('business_code',Auth::user()->business_code)->where('created_by',Auth::user()->user_code)->delete();

      Session::flash('success','Item deleted');

		return redirect()->back();
	}

	//sale checkout
	public function sale_checkout(){
		$customer = customers::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
		$paymentTypes = payment_methods::where('business_code',Auth::user()->business_code)->get();
      $defaultPaymentTypes = payment_methods::where('business_code','admin')->get();

		$cartItems = cart::where('created_by',Auth::user()->user_code)
								->where('business_code',Auth::user()->business_code)
								->get();
		$symbol = Wingu::business()->currency;

		return view('app.pos.sales.checkout', compact('customer','paymentTypes','defaultPaymentTypes','cartItems','symbol'));
	}

   //save sale
   public function save_sale(Request $request){
      $this->validate($request, [
         'customer' => 'required',
      ]);

		//====get cart items
		$cartItems = cart::where('created_by',Auth::user()->user_code)
                     ->where('business_code',Auth::user()->business_code)
                     ->get();

      //====add new customer
      if($request->customer == 'New'){
         $this->validate($request, [
            'customer_name' => 'required'
         ]);

         $code = Helper::generateRandomString(30);
         $customer = new customers;
         $customer->customer_name = $request->customer_name;
         $customer->primary_phone_number = $request->customer_phone_number;
         $customer->email = $request->customer_email;
         $customer->business_code = Auth::user()->business_code;
         $customer->customer_code = $code;
         $customer->created_by = Auth::user()->user_code;
         $customer->updated_by = Auth::user()->user_code;
         $customer->save();

			//address
			$address = new address;
			$address->customer_code = $code;
         $address->business_code = Auth::user()->business_code;
			$address->save();
      }

      //====add new invoice
      $invoiceSettings = invoice_settings::where('business_code',Auth::user()->business_code)->first();
		$invoiceCode = Helper::generateRandomString(30);

		//====store invoice
		if(Session::has('taxRate')){
			$taxRate = Session::get('taxRate')['rate'];
		}else{
			$taxRate = 0;
		}

		//total amount
		$totalAmount = $cartItems->sum('amount');
		$discount = $cartItems->sum('discount');

		//check if taxed
		if($taxRate == 0 || $taxRate == NULL){
			$taxRate = 0;
			$amoutAfterDiscount = $totalAmount - $discount;
			$taxValue = 0;
			$amountAfterTax = $amoutAfterDiscount;
		}else{
			$taxRate = $taxRate/100;
			$amoutAfterDiscount = $totalAmount - $discount;
			$taxValue = $amoutAfterDiscount * $taxRate;
			$amountAfterTax = $amoutAfterDiscount + $taxValue;
		}

		$store					   = new invoices;
		$store->created_by		= Auth::user()->user_code;
		if($request->customer == 'New'){
			$store->customer	 	= $customer->customer_code;
		}else{
			$store->customer	 	= $request->customer;
		}
		$store->invoice_title	= 'Point Of Sale';
		$store->invoice_number  = $invoiceSettings->number + 1;
		$store->invoice_prefix  = $invoiceSettings->prefix;
		$store->invoice_date	   = date('Y-m-d');
		$store->invoice_due	   = date('Y-m-d');
		$store->sales_person   	= Auth::user()->user_code;
		$store->main_amount     = $totalAmount;
		$store->discount        = $discount;
		$store->total		      = $amountAfterTax;
		$store->balance		   = 0;
		$store->paid				= $amountAfterTax;
		$store->sub_total	      = $amoutAfterDiscount;
		$store->tax_value	      = $taxValue;
      $store->income_category = 'point-of-sale';
		if(Session::has('taxRate')){
			$taxRate = Session::get('taxRate')['rate'];
			$store->tax_rate         = $taxRate;
		}else{
			$store->tax_rate         = 0;
		}

		$store->invoice_type		= 'POS';
		$store->status  		   = 1;
		$store->invoice_code 	= $invoiceCode;
      $store->branch    		= Auth::user()->branch_code;
		$store->business_code 	= Auth::user()->business_code;
		$store->save();

      //products
		foreach ($cartItems as $item){
			$product 					= new invoice_products;
			$product->invoice_code	= $invoiceCode;
			$product->product_code	= $item->product_code;
			$product->product_name	= $item->product_name;
			$product->quantity		= $item->qty;
			$product->discount		= $item->discount;
			$product->tax_rate		= 0;
			$product->tax_value		= 0;
			$product->total_amount  = $item->amount;
			$product->main_amount   = $item->amount;
			$product->sub_total  	= $item->amount;
			$product->business_code = Auth::user()->business_code;
			$product->selling_price = $item->price;
			$product->category      = 'Product';
			$product->save();

			//product information
			$productInfo = product_information::where('product_code',$item->product_code)->where('business_code',Auth::user()->business_code)->first();

			//reduce quantity
			if($productInfo->track_inventory == 'Yes'){

				//check if has multiple inventory store
				$checkInventory = product_inventory::where('business_code',Auth::user()->business_code)->where('product_code',$item->product_code)->count();
				if($checkInventory > 1){
					$inventory = product_inventory::where('business_code',Auth::user()->business_code)
															->where('branch_code',Auth::user()->branch_code)
															->where('product_code',$item->product_code)
															->first();

					if($inventory->current_stock > $item->qty){
						$inventory->current_stock = $inventory->current_stock - $item->qty;
					}else {
						$inventory->current_stock = 0;
					}
					$inventory->save();

					//send inventory notification if below reorder point
					if($inventory->current_stock < $inventory->reorder_point){
						if($inventory->notification < 2){
							//send email
							$subject = 'WinguPlus Stock Level Notification';
							$to = Wingu::business()->email;
							$content = '<p>The following product needs to be restocked<br><b>Product:</b> '.$item->product_name.'<br><b>Current Stock</b> '.$inventory->current_stock.'<br> <b>Reorder Quantity</b> '.$inventory->reorder_qty.'</p>';
							Mail::to($to)->send(new systemMail($content,$subject));

							$inventroyNotification = product_inventory::where('business_code',Auth::user()->business_code)
																					->where('branch_code',Auth::user()->branch_code)
																					->where('product_code',$item->product_code)
																					->first();
							$inventroyNotification->notification = $inventroyNotification->notification + 1;
							$inventroyNotification->save();
						}
					}

				}else{
					$inventory = product_inventory::where('business_code',Auth::user()->business_code)->where('default_inventory','Yes')->where('product_code',$item->product_code)->first();
					if($inventory->current_stock > $item->qty){
						$inventory->current_stock = $inventory->current_stock - $item->qty;

						//send inventory notification if below reorder point
						if($inventory->current_stock < $inventory->reorder_point){
							if($inventory->notification < 2){
								//send email
								$subject = 'winguPlus Stock Level Notification';
								$to = Wingu::business()->primary_email;
								$content = '<p>The following product needs to be restocked<br><b>Product:</b> '.$item->product_name.'<br><b>Current Stock</b> '.$inventory->current_stock.'<br> <b>Reorder Quantity</b> '.$inventory->reorder_qty.'</p>';
								Mail::to($to)->send(new systemMail($content,$subject));

								$inventroyNotification = product_inventory::where('business_code',Auth::user()->business_code)
																						->where('default_inventory','Yes')
																						->where('product_code',$item->product_code)
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

			//delete item from cart
			cart::where('id',$item->id)->where('created_by',Auth::user()->user_code)->where('business_code',Auth::user()->business_code)->delete();
		}

		//invoice setting
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

		//record payment
		$pay = new invoice_payments;
		$pay->amount = $amountAfterTax;
		$pay->balance = 0;
		$pay->reference_number = $store->invoice_number.$store->invoice_prefix;
      $pay->payment_code = Helper::generateRandomString(30);
		$pay->payment_method = $request->payment_method;
		$pay->payment_date = date('Y-m-d');
		$pay->invoice_code = $store->invoice_code;
		$pay->created_by = Auth::user()->user_code;
		$pay->business_code = Auth::user()->business_code;
		if($request->customer == 'New'){
			$pay->customer_code	= $customer->customer_code;
		}else{
			$pay->customer_code	= $request->customer;
		}
		$pay->payment_category = 'Received';
		$pay->save();

		session()->forget('taxRate');

		//recorded activity
		$activities = 'POS sale #'.$store->prefix.$store->invoice_number.' has been made by '.Auth::user()->name;
		$section = 'POS';
		$type = 'Sale';
		$adminID = Auth::user()->user_code;
		$activityID = $invoiceCode;
		$business_code = Auth::user()->business_code;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','Sale successfully saved');

		return redirect()->route('pos.sale.details',$invoiceCode);
   }

	//view sale order
	public function sale_view($code){
		$invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                        ->join('wp_status','wp_status.id','=','fn_invoices.status')
                        ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                        ->where('fn_invoices.invoice_code',$code)
                        ->where('fn_invoices.business_code',Auth::user()->business_code)
                        ->select('*','fn_invoices.invoice_code as invoice_code','wp_business.name as businessName','fn_invoices.status as invoiceStatusID','wp_business.business_code as business_code','wp_business.currency as symbol')
							   ->first();

		$products = invoice_products::where('invoice_code',$code)->get();
		$payments = invoice_payments::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->get();

		$accountPayment = payment_methods::where('business_code',Auth::user()->business_code)->get();
		$defaultPayment = payment_methods::where('business_code','admin')->get();

		$files = docs::where('file_code',$code)->where('business_code',Auth::user()->business_code)->get();

		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->where('fn_customers.customer_code',$invoice->customer)
                        ->where('fn_customers.business_code',Auth::user()->business_code)
                        ->select('*','fn_customers.customer_code as customer_code','bill_country as countryID')
                        ->first();

		$template = Wingu::template(Wingu::business()->template_code)->template_name;
		$count = 1;

		return view('app.pos.sales.sale-details', compact('client','invoice','products','files','payments','accountPayment','defaultPayment','template','count'));
	}

	//print receipt
	public function receipt_print($code){
		$invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                        ->join('wp_status','wp_status.id','=','fn_invoices.status')
                        ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                        ->where('fn_invoices.invoice_code',$code)
                        ->where('fn_invoices.business_code',Auth::user()->business_code)
                        ->select('*','fn_invoices.invoice_code as invoice_code','wp_business.name as businessName','fn_invoices.status as invoiceStatusID','wp_business.business_code as business_code')
							   ->first();

		$products = invoice_products::where('invoice_code',$invoice->invoice_code)->get();

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/pos/receipt', compact('invoice','products'));

      return $pdf->stream($invoice->prefix.$invoice->invoice_number.'.pdf');
	}

	//mail receipt
	public function receipt_mail(Request $request){
		$this->validate($request, [
			'email' => 'required',
		]);

		//send email
		$subject = 'Receipt from '.Wingu::business()->name;
		$to = $request->email;

		Mail::to($to)->send(new sendPosReceipt($subject,$request->saleID));

		//recorord activity
		$activities = 'POS Receipt Sent to '.$request->email.'by '.Auth::user()->name;
		$section = 'POS';
		$type = 'Receipt';
		$adminID = Auth::user()->user_code;
		$activityID = $request->saleID;
		$business_code = Auth::user()->business_code;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$business_code);

		Session::flash('success','Receipt successfully sent');

		return redirect()->back();
	}

	public function cancel_sale(){
		cart::where('business_code',Auth::user()->business_code)->where('created_by',Auth::user()->business_code)->delete();
		session()->forget('taxRate');

		Session::flash('success', 'Sale Successfully canceled');

		return redirect()->back();
	}
}
