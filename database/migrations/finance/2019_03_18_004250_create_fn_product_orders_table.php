<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnProductOrdersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_product_orders', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('order_code')->nullable();
         $table->char('customer_code')->nullable();
         $table->char('payment_code')->nullable();
         $table->integer('payment_status')->nullable();
         $table->char('total')->nullable();
         $table->integer('qty')->nullable();
         $table->date('order_date')->nullable();
         $table->text('note')->nullable();
         $table->char('order_status')->nullable();
         $table->char('gateway_code')->nullable();
         $table->integer('delivery_status')->nullable();
         $table->char('delivery_location')->nullable();
         $table->char('country')->nullable();
         $table->char('ip')->nullable();
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
      Schema::dropIfExists('fn_product_orders');
   }
}
