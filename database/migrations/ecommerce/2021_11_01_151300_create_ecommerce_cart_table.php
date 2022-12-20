<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceCartTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('ecommerce_cart', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('product_code')->nullable();
         $table->char('product_name')->nullable();
         $table->char('qty')->nullable();
         $table->char('price')->nullable();
         $table->char('amount')->nullable();
         $table->char('tax_rate')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('discount')->nullable();
         $table->char('total_amount')->nullable();
         $table->char('note')->nullable();
         $table->char('session_id')->nullable();
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
      Schema::dropIfExists('ecommerce_cart');
   }
}
