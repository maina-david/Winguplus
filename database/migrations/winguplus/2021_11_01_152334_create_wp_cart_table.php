<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpCartTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_cart', function (Blueprint $table) {
         $table->id();
         $table->char('business_code')->nullable();
         $table->char('module_code');
         $table->char('module_name')->nullable();
         $table->text('description')->nullable();
         $table->char('qty')->nullable();
         $table->char('price')->nullable();
         $table->char('amount')->nullable();
         $table->char('tax_rate')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('discount')->nullable();
         $table->char('total_amount')->nullable();
         $table->text('note')->nullable();
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
      Schema::dropIfExists('wp_cart');
   }
}
