<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnEstimateProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_estimate_products', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('estimate_code');
         $table->char('product_code');
         $table->char('product_name')->nullable();
         $table->char('quantity')->nullable();
         $table->char('price')->nullable();
         $table->char('total_amount')->nullable();
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
      Schema::dropIfExists('fn_estimate_products');
   }
}
