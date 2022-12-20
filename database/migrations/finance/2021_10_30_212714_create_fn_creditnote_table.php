<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnCreditnoteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_creditnote', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('creditnote_code');
         $table->char('customer_code')->nullable();
         $table->char('status')->nullable();
         $table->char('title')->nullable();
         $table->char('reference_number')->nullable();
         $table->text('customer_note')->nullable();
         $table->char('terms')->nullable();
         $table->char('number')->nullable();
         $table->char('prefix')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('balance')->nullable();
         $table->char('discount')->nullable();
         $table->char('discount_type')->nullable();
         $table->date('creditnote_date')->nullable();
         $table->char('tax')->nullable();
         $table->char('invoice_link')->nullable();
         $table->char('payment_code')->nullable();
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
      Schema::dropIfExists('fn_creditnote');
   }
}
