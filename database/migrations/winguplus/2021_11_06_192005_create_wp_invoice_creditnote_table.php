<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpInvoiceCreditnoteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_invoice_creditnote', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('user_code');
         $table->char('credit_code');
         $table->char('invoice_code');
         $table->char('credited_amount');
         $table->char('credit_balance');
         $table->char('invoice_balance');
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
      Schema::dropIfExists('wp_invoice_creditnote');
   }
}
