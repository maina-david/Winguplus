<?php
namespace App\Mail;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Auth;
class sendPosReceipt extends Mailable
{
   use Queueable, SerializesModels;
   public $subject;
   public $saleID;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct($subject,$saleID)
   {
      $this->subject = $subject;
      $this->saleID = $saleID;
   }

   /**
       * Build the message.
      *
      * @return $this
      */
   public function build()
   {
      $subject = $this->subject;
      $invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
								->join('wp_status','wp_status.id','=','fn_invoices.status')
								->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
								->where('fn_invoices.invoice_code',$this->saleID)
								->where('fn_invoices.business_code',Auth::user()->business_code)
								->select('*','fn_invoices.invoice_code as invoiceID','wp_business.name as businessName','fn_invoices.status as invoiceStatusID','wp_business.business_code as business_code','wp_business.business_code as business_code')
								->first();

		$products = invoice_products::where('invoice_code',$invoice->invoiceID)->get();

		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->where('fn_customers.customer_code',$invoice->customer)
					->where('fn_customers.business_code',Auth::user()->business_code)
					->select('*','fn_customers.customer_code as clientID','bill_country as countryID')
					->first();

      $from = $invoice->email;
      $name = $invoice->businessName;

      return $this->view('email.pos_receipt', compact('invoice','products','client'))->from($from, $name)->subject($subject);
   }
}
