<?php

namespace App\Models\finance\invoice;

use Illuminate\Database\Eloquent\Model;
use Auth;

class invoices extends Model
{
   Protected $table = 'fn_invoices';

   //single invoice details
   public static function single_invoice($code){
      $invoice = invoices::join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                           ->join('wp_status','wp_status.id','=','fn_invoices.status')
                           ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                           ->where('fn_invoices.invoice_code',$code)
                           ->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->select('*','fn_invoices.invoice_code as invoiceCode','wp_business.name as businessName','fn_invoices.status as invoiceStatusID','wp_business.business_code as business_code','wp_status.name as status_name')
                           ->first();

      return $invoice;
   }

}
