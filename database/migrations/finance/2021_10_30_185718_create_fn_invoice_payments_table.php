<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnInvoicePaymentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_invoice_payments', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('payment_code');
         $table->char('invoice_code');
         $table->char('amount')->nullable();
         $table->char('balance')->nullable();
         $table->char('bank_charges')->nullable();
         $table->date('payment_date')->nullable();
         $table->char('payment_method')->nullable();
         $table->char('reference_number')->nullable();
         $table->char('tax_deducted')->nullable();
         $table->text('note')->nullable();
         $table->char('display_in_portal')->nullable();
         $table->char('account')->nullable();
         $table->char('customer_code')->nullable();
         $table->char('payment_category')->nullable();
         $table->char('credited')->nullable();
         $table->char('creditnote_code')->nullable();
         $table->char('created_by')->nullable();
         $table->char('updated_by')->nullable();
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('fn_invoice_payments');
   }
}
