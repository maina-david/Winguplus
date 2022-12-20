<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnQuoteProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_quote_products', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('quote_code')->nullable();
         $table->char('product_code')->nullable();
         $table->char('quantity')->nullable();
         $table->char('price')->nullable();
         $table->char('discount')->nullable();
         $table->char('tax_rate')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('total_amount')->nullable();
         $table->char('main_amount')->nullable();
         $table->char('sub_total')->nullable();
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
      Schema::dropIfExists('fn_quote_products');
   }
}
