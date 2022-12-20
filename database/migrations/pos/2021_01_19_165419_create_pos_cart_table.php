<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCartTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pos_cart', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('product_code');
         $table->char('product_name');
         $table->char('qty')->default(1);
         $table->char('price')->default(1);
         $table->char('amount')->default(0);
         $table->char('tax_rate')->default(0);
         $table->char('tax_value')->default(0);
         $table->char('discount')->default(0);
         $table->char('total_amount')->default(0);
         $table->text('note')->default(0);
         $table->char('session_id')->default(0);
         $table->char('created_by');
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
      Schema::dropIfExists('pos_cart');
   }
}
