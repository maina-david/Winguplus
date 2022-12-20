<?php
namespace App\Http\Controllers\app\pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoices;
Use Auth;
use Session;
use Wingu;
use PDF;

class salesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $sales = invoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                        ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                        ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                        ->join('wp_status','wp_status.id','=','fn_invoices.status')
                        ->where('invoice_type','POS')
                        ->where('fn_invoices.business_code',Auth::user()->business_code)
                        ->select('*','wp_status.name as statusName')
                        ->get();

      return view('app.pos.sales.index', compact('sales'));
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($code)
   {
      $transaction = invoices::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->first();
      $business = Wingu::business();

      $items = invoice_products::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->get();

      return view('backend.pos.sales.history.show', compact('transaction','items','business'));
   }

   /**
   * print receipt
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function print($code){
      $details = invoices::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->orderby('id','desc')->first();

      $products = invoice_products::where('invoice_code',$code)->where('business_code',Auth::user()->business_code)->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business()->template_code)->template_name.'/pos/receipt', compact('products','details','client'));

		return $pdf->stream($details->prefix.$details->invoice_number.'.pdf');
   }
}
