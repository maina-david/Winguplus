<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnInvoiceCreditnoteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_invoice_creditnote', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('credit_note')->nullable();
         $table->char('invoice_code')->nullable();
         $table->char('created_amount')->nullable();
         $table->char('credit_balance')->nullable();
         $table->char('invoice_balance')->nullable();
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
      Schema::dropIfExists('fn_invoice_creditnote');
   }
}
