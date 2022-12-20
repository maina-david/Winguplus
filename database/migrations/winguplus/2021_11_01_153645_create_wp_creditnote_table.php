<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpCreditnoteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_creditnote', function (Blueprint $table) {
         $table->id();
         $table->char('business_code')->nullable();
         $table->char('customer_code')->nullable();
         $table->integer('status')->nullable();
         $table->char('title')->nullable();
         $table->char('reference_number')->nullable();
         $table->text('customer_note')->nullable();
         $table->text('terms')->nullable();
         $table->char('creditnote_number')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('balance')->nullable();
         $table->char('discount')->nullable();
         $table->char('discount_type')->nullable();
         $table->char('creditnote_date')->nullable();
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
      Schema::dropIfExists('wp_creditnote');
   }
}
