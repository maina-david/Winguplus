<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnPosCartTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_pos_cart', function (Blueprint $table) {
         $table->id();
         $table->char('product_code')->nullable();
         $table->char('product_name')->nullable();
         $table->integer('qty')->nullable();
         $table->char('price',50)->nullable();
         $table->char('amount',50)->nullable();
         $table->char('tax_rate',20)->nullable();
         $table->char('tax_value',20)->nullable();
         $table->char('discount',20)->nullable();
         $table->char('total_amount')->nullable();
         $table->char('note')->nullable();
         $table->char('business_code')->nullable();
         $table->char('session_id')->nullable();
         $table->char('created_by')->nullable();
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
      Schema::dropIfExists('fn_pos_cart');
   }
}
