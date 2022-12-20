<?php
namespace App\Helpers;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\products\category;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\quotes\quotes;
use App\Models\finance\expense\expense;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\salesorder\salesorder_settings;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\payments\flow;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\invoice\invoice_products;
use App\Models\wingu\file_manager;
use App\Models\finance\creditnote\invoice_creditnote;
use App\Models\finance\lpo\lpo_settings;
use App\Models\finance\lpo\lpo_products;
use App\Models\finance\accounts;
use App\Models\finance\income\category as income_category;
use App\Models\finance\products\brand;
use App\Models\finance\quotes\quote_settings;
use App\Models\finance\invoice\invoice_payments;
use App\Models\subscriptions\settings as subscription_settings;
use App\Models\finance\tax;
use App\Models\wingu\business_gateways;
use App\Models\finance\products\attributes;
use App\Models\finance\expense\expense_category;
use App\Models\wingu\business_payment_integrations;
use App\Models\finance\payments\payment_methods;
use Hr;
use DB;
use Auth;
use Wingu;
use Mail;

class Finance
{
	public function __construct(){
      $this->middleware('auth');
	}

	//======================================= product   =========================================
	//=============================================================================================---->
	public static function check_account_payment_method($code){
		$check = payment_methods::where('method_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	public static function account_payment_method($code){
		$method = payment_methods::where('business_code',Auth::user()->business_code)->where('method_code',$code)->first();
		return $method;
	}

	//check payment system
	public static function check_system_payment($code){
		$check = payment_methods::where('method_code',$code)->where('business_code',0)->count();
		return $check;
	}

	//get payment system
	public static function system_payment($code){
		$method = payment_methods::where('business_code',0)->where('method_code',$code)->first();
		return $method;
	}

	//product info
	public static function product($code){
		$product = product_information::where('business_code',Auth::user()->business_code)->where('product_code',$code)->first();
		return $product;
	}

	public static function check_product($code){
		$count = product_information::where('business_code',Auth::user()->business_code)->where('product_code',$code)->count();
		return $count;
	}

   //product price
	public static function price($code){
		$price = product_price::where('business_code',Auth::user()->business_code)->where('default_price','Yes')->where('product_code',$code)->first();
		return $price;
	}


	//product price of specific  store
	public static function store_price($code){
		//get main branch
		$mainBranch = Hr::get_main_branch();
		if($mainBranch->code == Auth::user()->branch_code){
			$price = product_price::where('business_code',Auth::user()->business_code)->where('default_price','Yes')->where('product_code',$code)->first();
		}elseif(Auth::user()->branch_code == Null || Auth::user()->branch_code == 0){
			$price = product_price::where('business_code',Auth::user()->business_code)->where('default_price','Yes')->where('product_code',$code)->first();
		}else{
			$price = product_price::join('hr_branches','hr_branches.branch_code','=','fn_product_price.branch_code')
											->where('fn_product_price.business_code',Auth::user()->business_code)
											->where('fn_product_price.branch_code',Auth::user()->branch_code)
											->where('fn_product_code',$code)
											->first();
		}
		return $price;
	}

   //check product category
	public static function check_product_category($code){
		$category = category::where('business_code',Auth::user()->business_code)->where('category_code',$code)->count();
		return $category;
	}

	//product category
	public static function product_category($code){
		$category = category::where('business_code',Auth::user()->business_code)->where('category_code',$code)->first();
		return $category;
	}

	//product inventory
	public static function inventory($code){
		$inventory = product_inventory::where('business_code',Auth::user()->business_code)->where('default_inventory','Yes')->where('product_code',$code)->first();
		return $inventory;
	}

	//product inventory for store
	public static function store_inventory($code){
		$mainBranch = Hr::get_main_branch();
		if($mainBranch->code == Auth::user()->branch_code){
			$inventory = product_inventory::where('business_code',Auth::user()->business_code)->where('default_inventory','Yes')->where('product_code',$code)->first();
		}elseif(Auth::user()->branch_code == Null || Auth::user()->branch_code == 0){
			$inventory = product_inventory::where('business_code',Auth::user()->business_code)->where('default_inventory','Yes')->where('product_code',$code)->first();
		}else{
			$inventory = product_inventory::join('hr_branches','hr_branches.branch_code','=','fn_product_inventory.branch_code')
													->where('fn_product_inventory.business_code',Auth::user()->business_code)
													->where('fn_product_inventory.branch_code',Auth::user()->branch_code)
													->where('product_code',$code)
													->first();
		}
		return $inventory;
	}

	//check if product is linked to specific store
	public static function check_product_store_link($code){
		$check = product_inventory::where('business_code',Auth::user()->business_code)->where('product_code',$code)->count();
		return $check;
	}

	//products by category
	public static function products_by_category_count($code){
		$products = product_category_product_information::join('fn_product_information','fn_product_information.product_code','=','fn_product_category_product_information.product')
			->where('business_code',Auth::user()->business_code)
			->where('category',$code)
			->count();

		return $products;
	}

	//products in a category
	public static function products_in_category($code){
		$count = product_category_product_information::where('category',$code)->count();

		return $count;
	}

	//get products in a category
	public static function get_products_categories($code){
		$categories = product_category_product_information::join('fn_product_category','fn_product_category.category_code','=','fn_product_category_product_information.category')
									->where('product',$code)
									->where('business_code',Auth::user()->business_code)
									->get();
		return $categories;
	}

	//check cover image
	public static function check_product_image($code){
		$check = file_manager::where('file_code',$code)->where('cover',1)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//get cover image
	public static function product_image($code){
		$image = file_manager::where('file_code',$code)->where('cover',1)->where('business_code',Auth::user()->business_code)->first();
		return $image;
	}

	//product count
	public static function product_count(){
		$count = product_information::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//count invoice products
	public static function count_invoice_products($code,$to,$from){
		$count = invoice_products::join('fn_product_information','fn_product_information.product_code','=','fn_invoice_products.product_code')
                           ->join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
                           ->whereBetween('fn_invoices.invoice_date',[$from,$to])
                           ->where('fn_invoice_products.product_code',$code)
                           ->where('fn_invoice_products.business_code',Auth::user()->business_code)
                           ->sum('quantity');
		return $count;
	}




	//count invoice pers salesperson
	public static function count_invoice_salesperson($code,$to,$from){
		$count = invoices::where('salesperson',$code)
					->where('business_code',Auth::user()->business_code)
               ->whereBetween('invoice_date',[$from,$to])
					->count();
		return $count;
	}

   //inventory notifications
   // public static function inventory_notification($product_code){
   //    //get product info
   //    $product = product_information::join('fn_product_inventory','fn_product_inventory.id','=','product_information.id')
   //                                  ->join('business','business.id','=','product_information.business_code')
   //                                  ->where('business_code',Auth::user()->business_code)
   //                                  ->where('product_information.id',$product_code)
   //                                  ->first();

   //    //get inventory settings
   //    $settings = pos_settings::where('business_code',Auth::user()->code)->first();

   //    $inventroyNotification = product_inventory::where('business_code',Auth::user()->business_code)
   //                                              ->where('default_inventory','Yes')
   //                                              ->where('product_code',$request->product_code[$k])
   //                                              ->first();
   //    $inventroyNotification->notification = $inventroyNotification->notification + 1;
   //    $inventroyNotification->save();

   //    //send email
   //    $subject = $product->product_name.' Inventory Notification';
   //    $to = $settings->notification_email;
   //    $content = '<p>The following product needs to be restocked<br><b>Product:</b> '.$product->product_name.'<br><b>Current Stock</b> '.$product->current_stock.'<br> <b>Reorder Quantity</b> '.$product->reorder_qty.'</p><p>Login to <a href="https://cloud.winguplus.com/">winguPlus</a> to update your stock</p>';

   //    Mail::to($to)->send(new systemMail($content,$subject));

   // }

	//======================================= suppliers  =========================================
	//=============================================================================================---->
	public static function supplier($code){
		$vendor = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $vendor;
	}

	// check if client exists
	public static function check_supplier($code){
		$check = suppliers::where('supplier_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	// check if client exists
	public static function count_suppliers(){
		$count = suppliers::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//======================================= brans  =========================================
	//=============================================================================================---->
	public static function brand($id){
		$brand = brand::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
		return $brand;
	}

	//check brand
	public static function check_brand($id){
		$check = brand::where('business_code',Auth::user()->business_code)->where('id',$id)->count();
		return $check;
	}

	//======================================= customers  =========================================
	//=============================================================================================---->

	// check if client exists
	public static function check_client($code){
		$check = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	//client information
	public static function client($code){
		$client = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $client;
	}

	public static function customer_invoices($code){
		$total = invoices::where('customer',$code)->where('business_code',Auth::user()->business_code)->select('total','paid','balance')->get();
		return $total;
	}

	//count customers
	public static function count_customers(){
		$count = customers::where('business_code',Auth::user()->business_code)->whereNull('category')->count();
		return $count;
	}

	//count customers
	public static function count_leads(){
		$count = customers::where('business_code',Auth::user()->business_code)->where('category','Lead')->count();
		return $count;
	}

	//check product cover
	public static function check_cover($code){
		$cover = file_manager::where('product_code',$code)->where('cover',1)->count();
		return $cover;
	}

	//check product cover
	public static function cover_image($code){
		$cover = file_manager::where('product_code',$code)->where('cover',1)->first()->image;
		return $cover;
	}

	//get tax info
	public static function tax($code){
		$tax = tax::where('tax_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $tax;
	}

	//======================================= sales orders  =========================================
	//=============================================================================================---->
	public static function salesorder_setting(){
		$estimate = salesorder_settings::where('business_code',Auth::user()->business_code)->first();
		return $estimate;
	}

	//create settings when not created
	public static function salesorder_setting_setup(){
		$create = new salesorder_settings;
		$create->number = 0;
		$create->prefix = 'SO';
		$create->business_code = Auth::user()->business_code;
		$create->created_by = Auth::user()->user_code;
		$create->save();
	}


	//======================================= quotes  =========================================
	//=============================================================================================---->
	public static function quote(){
		$invoice = quote_settings::where('business_code',Auth::user()->business_code)->first();;
		return $invoice;
    }

    //create settings when not created
	public static function quote_setting_setup(){
		$create = new quote_settings;
		$create->number = 0;
		$create->prefix = 'QUOTE';
		$create->business_code = Auth::user()->business_code;
		$create->created_by = Auth::user()->user_code;
		$create->save();
	}

	public static function count_quote(){
		$count = quotes::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//======================================= lpos  =========================================
	//=============================================================================================---->
	public static function lpo(){
		$invoice = lpo_settings::where('business_code',Auth::user()->business_code)->first();;
		return $invoice;
	}

	public static function lpo_count(){
		$count = lpo_settings::where('business_code',Auth::user()->business_code)->count();;
		return $count;
	}

	public static function lpo_items($code){
		$count = lpo_products::where('lpo_code',$code)->count();
		return $count;
	}

	//create settings when not created
	public static function lpo_setting_setup(){
		$create = new lpo_settings;
		$create->number = 0;
		$create->prefix = 'LPO';
		$create->business_code = Auth::user()->business_code;
		$create->created_by = Auth::user()->user_code;
		$create->save();
	}


	//======================================= credit note  =========================================
	//=============================================================================================---->
	public static function creditnote(){
		$invoice = creditnote_settings::where('business_code',Auth::user()->business_code)->first();;
		return $invoice;
	}

	//create settings when not created
	public static function creditnote_setting_setup(){
		$create = new creditnote_settings;
		$create->number = 0;
		$create->prefix = 'CN';
		$create->business_code = Auth::user()->business_code;
		$create->created_by = Auth::user()->user_code;
		$create->save();
	}

	//======================================= invoice  =========================================
	//=============================================================================================---->
	public static function invoice_products($code){
		$payment = invoice_products::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $payment;
	}

	//invoice payments
	public static function check_payment($code){
		$check = invoice_payments::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $check;
	}

	public static function invoice_payment($code){
		$payment = invoice_payments::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $payment;
	}

	public static function all_invoice_payments($code){
		$check = invoice_payments::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->get();
		return $check;
	}

	public static function invoice_creditnote($code){
		$credit = invoice_creditnote::join('creditnote','creditnote.id','=','invoice_creditnote.creditID')
					->where('invoice_code',$code)
					->where('creditnote.business_code',Auth::user()->business_code)
					->select('*','invoice_creditnote.created_at as creditnoteinvoicedate')
					->get();
		return $credit;
	}

	public static function invoice($code){
		$invoice = invoices::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $invoice;
	}

	public static function invoice_settings(){
		$invoice = invoice_settings::where('business_code',Auth::user()->business_code)->first();
		return $invoice;
	}

	//create settings when not created
	public static function invoice_setting_setup(){
		$create = new invoice_settings;
		$create->number = 0;
		$create->prefix = 'INV';
		$create->business_code = Auth::user()->business_code;
		$create->updated_by = Auth::user()->user_code;
		$create->save();
	}

	//count invoice
	public static function count_invoice(){
		$count = invoices::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//count

	//======================================= payments   =========================================
	//=============================================================================================---->
	//check default payment method
	public static function check_default_payment_method($code){
		$check = payment_methods::where('business_code',0)->where('method_code',$code)->count();
		return $check;
	}

	//get default payment method
	public static function default_payment_method($code){
		$method = payment_methods::where('business_code',0)->where('method_code',$code)->first();
		return $method;
	}

	//get account payment method information
	public static function payment_method($code){
		$payment = payment_methods::where('business_code',Auth::user()->business_code)->where('method_code',$code)->first();
		return $payment;
	}

	//check account pavement method
	public static function check_payment_method($code){
		$check = payment_methods::where('business_code',Auth::user()->business_code)->where('method_code',$code)->count();
		return $check;
	}

	public static function payment_gateway($getawayID){
		$gateway = business_gateways::where('id',$getawayID)->where('business_code',Auth::user()->business_code)->first();
		return $gateway;
	}

	public static function flow($invoiceID,$payCredit,$section){
		$flow = new flow;
		$flow->invoiceID = $invoiceID;
		$flow->payment_credit_id = $payCredit;
		$flow->section = $section;
		$flow->business_code = Auth::user()->business_code;
		$flow->save();

		$success = 'done';

		return $success;
	}

	public static function delete_flow($invoiceID,$payCredit,$section){
		$flow = flow::where('invoiceID',$invoiceID)
					->where('payment_credit_id',$payCredit)
					->where('section',$section)
					->where('business_code',Auth::user()->business_code)
					->delete();

		$success = 'done';

		return $success;
	}

	//======================================= subscription   =========================================
	//=============================================================================================---->
	public static function subscription_settings(){
		$settings = subscription_settings::where('business_code',Auth::user()->business_code)->first();
		return $settings;
	}

   //======================================= attributes   =========================================
	//=============================================================================================---->
	public static function values_per_attribute($id){
		$values = attributes::where('business_code',Auth::user()->business_code)->where('parentID',$id)->count();
		return $values;
	}

	//======================================= expense  ============================================
	//=============================================================================================---->
	public static function count_expense(){
		$count = expense::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	public static function count_expense_category(){
		$count = expense_category::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	public static function check_expense_category($code){
		$category = expense_category::where('category_code',$code)
												->where('business_code',Auth::user()->business_code)
												->count();
		return $category;
	}

   public static function expense_category($code){
      $expense = expense_category::where('category_code',$code)->where('business_code',Auth::user()->business_code);

      return response()->json([
         'check' => $expense->count(),
         'expense' => $expense->first()
      ]);
   }
	//======================================= creditnote   =========================================
	//=============================================================================================---->
	//count creditnote
	public static function count_creditnote(){
		$count = creditnote::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}


	//======================================= Bank and cash   =========================================
	//=============================================================================================---->
	public static function count_bank_and_cash(){
		$count = accounts::where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	//======================================= income category   =========================================
	//=============================================================================================---->

	public static function income_category($code){
		$category = income_category::where('category_code',$code)->where('business_code',Auth::user()->business_code)->first();
		return $category;
	}

	public static function check_income_category($code){
		$count = income_category::where('category_code',$code)->where('business_code',Auth::user()->business_code)->count();
		return $count;
	}

	public static function original_income_category($code){
		$category = income_category::where('category_code',$code)->where('business_code',0)->first();
		return $category;
	}

	//======================================= reports   =========================================
	//=============================================================================================---->
	//check invoice income category within a period
	public static function check_invoice_in_category_by_period($id,$from,$to){
		$check = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$from,$to])->where('income_category',$id)->count();
		return $check;
	}

	//get invoices by income category
	public static function invoices_per_income_category($id,$from,$to){
		$invoices = invoices::where('business_code',Auth::user()->business_code)
									->whereBetween('invoice_date',[$from,$to])
									->where('income_category',$id)
									->groupby('income_category')
									->orderby('id','desc')
									->get();
		return $invoices;
	}

	//get invoices by income category
	public static function invoices_per_income_category_sum($id,$from,$to){
		$sum = invoices::where('business_code',Auth::user()->business_code)->whereBetween('invoice_date',[$from,$to])->where('income_category',$id)->sum('main_amount');
		return $sum;
	}

	//get expense by category within a period
	public static function check_expense_per_category_by_period($code,$from,$to){
		$check = expense::whereBetween('expense_date',[$from,$to])->where('category',$code)->count();
		return $check;
	}

	public static function expense_per_category($code,$from,$to){
		$expenses = expense::where('business_code',Auth::user()->business_code)
									->whereBetween('expense_date',[$from,$to])
									->where('category',$code)
									->groupby('category')
									->orderby('id','desc')
									->get();
		return $expenses;
	}

	public static function expense_per_category_sum($code,$from,$to){
		$sum = expense::where('business_code',Auth::user()->business_code)->whereBetween('expense_date',[$from,$to])->where('category',$code)->sum('amount');
		return $sum;
	}

	//check if product has been sold
	public static function product_sales_report($code){
		$sales = invoice_products::join('fn_invoices','fn_invoices.invoice_code','=','fn_invoice_products.invoice_code')
										->where('fn_invoice_products.product_code',$code)
                              ->where('fn_invoices.business_code',Auth::user()->business_code)
										->select('fn_invoice_products.quantity as quantity',DB::raw('sum(quantity) quantity'))
										->first();

		return $sales;
	}

   //total client invoices
   public static function client_total_invoices_report($code,$from, $to){
		$count = invoices::where('customer',$code)
                        ->where('business_code',Auth::user()->business_code)
                        ->whereBetween('invoice_date',[$from, $to ])
                        ->count();
		return $count;
	}


	//================================ business payment integration   ==================================
	//=============================================================================================---->
	public static function check_business_payment_integrations($integration){
		$check = business_payment_integrations::where('business_code',wingu::business()->business_code)->where('integration_code',$integration)->count();
		return $check;
	}

}
