<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\finance\creditnote\creditnote;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoices as InvoiceInvoices;
use App\Models\wingu\file_manager;
use Livewire\WithPagination;
use Livewire\Component;
use Auth;
use Wingu;

class Invoices extends Component
{
   public $search,$perPage=20,$status,$month,$year,$invoiceCode;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }

   public function render()
   {
      $currency = Wingu::business()->currency;
      $currentYear = date('Y');
      $query = InvoiceInvoices::join('fn_customers','fn_customers.customer_code','=','fn_invoices.customer')
                              ->join('wp_business','wp_business.business_code','=','fn_invoices.business_code')
                              ->join('fn_invoice_settings','fn_invoice_settings.business_code','=','fn_invoices.business_code')
                              ->join('wp_status','wp_status.id','=','fn_invoices.status');
                              if($this->search){
                                 $query->Where('customer_name','like','%'.$this->search.'%');
                              }
                              if($this->status){
                                 $query->where('fn_invoices.status',$this->status);
                              }
                              if($this->month){
                                 $query->whereMonth('invoice_date',$this->month);
                              }
                              if($this->year){
                                 $query->whereYear('invoice_date',$this->year);
                              }
      $invoices = $query->where('fn_invoices.business_code',Auth::user()->business_code)
                           ->select('*','fn_invoices.invoice_code as invoiceCode','wp_status.name as statusName')
                           ->orderby('fn_invoices.id','desc')
                           ->paginate($this->perPage);

      //count invoices
      $query2 = InvoiceInvoices::where('business_code',Auth::user()->business_code);
                                 if($this->month){
                                    $query2->whereMonth('invoice_date',$this->month);
                                 }
                                 if($this->year){
                                    $query2->whereYear('invoice_date',$this->year);
                                 }

      $totalInvoices = $query2->count();

      //count paid
      $paidQuery = InvoiceInvoices::where('business_code',Auth::user()->business_code)
                                 ->where('status',1);
                                 if($this->month){
                                    $paidQuery->whereMonth('invoice_date',$this->month);
                                 }
                                 if($this->year){
                                    $paidQuery->whereYear('invoice_date',$this->year);
                                 }

      $paid = $paidQuery->get();

      //count partially paid
      $partiallyQuery = InvoiceInvoices::where('business_code',Auth::user()->business_code)
                                 ->where('status',3);
                                 if($this->month){
                                    $partiallyQuery->whereMonth('invoice_date',$this->month);
                                 }
                                 if($this->year){
                                    $partiallyQuery->whereYear('invoice_date',$this->year);
                                 }

      $partially = $partiallyQuery->get();

      //count overdue
      $overdueQuery = InvoiceInvoices::where('business_code',Auth::user()->business_code)
                                 ->where('invoice_due', '>=', date('Y-m-d'));
                                 if($this->month){
                                    $overdueQuery->whereMonth('invoice_date',$this->month);
                                 }
                                 if($this->year){
                                    $overdueQuery->whereYear('invoice_date',$this->year);
                                 }

      $overdue = $overdueQuery->get();

      //count unpaid
      $unpaidQuery = InvoiceInvoices::where('business_code',Auth::user()->business_code)
                                 ->where('status',2);
                                 if($this->month){
                                    $unpaidQuery->whereMonth('invoice_date',$this->month);
                                 }
                                 if($this->year){
                                    $unpaidQuery->whereYear('invoice_date',$this->year);
                                 }

      $unpaid = $unpaidQuery->get();

      return view('livewire.finance.invoice.invoices', compact('invoices','paid','totalInvoices','currency','partially','overdue','unpaid'));
   }

   public function confirm_delete($code){
      $this->invoiceCode = $code;
   }

   public function delete(){

      // check for payments
		$payments = invoice_payments::where('invoice_code', $this->invoiceCode)->where('business_code',Auth::user()->business_code)->count();

		//check if linked to creditnote
		$creditNote = creditnote::where('invoice_link', $this->invoiceCode)->where('business_code',Auth::user()->business_code)->count();

		if($payments == 0 && $creditNote == 0){

			//delete all files linked to the invoice_settings
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/';

			$check_files = file_manager::where('file_code', $this->invoiceCode)
                           ->where('business_code',Auth::user()->business_code)
                           ->count();

			if($check_files > 0){
				$files = file_manager::where('file_code', $this->invoiceCode)->where('section','invoice')->where('business_code',Auth::user()->business_code)->get();
				foreach($files as $file){
					$doc = file_manager::where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();

                //delete logo
               $unlinkPath = public_path('/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/invoices/'.$doc->file_name);
               unlink($unlinkPath);

					$doc->delete();
				}
			}

			//delete invoice_settings products
			invoice_products::where('invoice_code', $this->invoiceCode)->delete();

			//delete invoice_settings plus attachment
			$invoice = InvoiceInvoices::where('invoice_code', $this->invoiceCode)->where('business_code',Auth::user()->business_code)->first();
			if($invoice->attachment != ""){
				$delete = $directory.$invoice->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$invoice->delete();

			//delete payments
			$payments = invoice_payments::where('invoice_code', $this->invoiceCode)->where('business_code',Auth::user()->business_code)->get();
			foreach ($payments as $payment) {
				$payment->delete();
			}

         //recored activity
         $activity     = 'Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' had been deleted by '.Auth::user()->name;
         $module       = 'Finance';
         $section      = 'invoice';
         $action       = 'delete';
         $activityCode = $this->invoiceCode;

         Wingu::activity($activity,$module,$section,$action,$activityCode);

			// Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Invoice has been successfully deleted"
         ]);

         $this->invoiceCode = "";

         $this->emit('Modal');
		}else{

			// Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"You have recorded transactions for this Invoice. Hence, this Invoice cannot be deleted."
         ]);

         $this->invoiceCode = "";

         $this->emit('Modal');
		}

   }

   public function close(){
      $this->invoiceCode = "";
      $this->emit('Modal');
   }
}
