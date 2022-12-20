<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnPurchaseorderProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_purchaseorder_products', function (Blueprint $table) {
         $table->id();
         $table->char('business_code')->nullable();
         $table->char('lpo_code');
         $table->char('product_code')->nullable();
         $table->char('quantity',50)->nullable();
         $table->char('discount',50)->nullable();
         $table->char('tax_rate',50)->nullable();
         $table->char('tax_value',50)->nullable();
         $table->char('sub_total',50)->nullable();
         $table->char('price',50)->nullable();
         $table->char('total',50)->nullable();
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
      Schema::dropIfExists('fn_purchaseorder_products');
   }
}
