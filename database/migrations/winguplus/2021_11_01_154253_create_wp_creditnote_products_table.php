<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpCreditnoteProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_creditnote_products', function (Blueprint $table) {
         $table->id();
         $table->char('creditnote_code')->nullable();
         $table->char('product_code')->nullable();
         $table->char('product_name')->nullable();
         $table->char('quantity')->nullable();
         $table->char('price')->nullable();
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
      Schema::dropIfExists('wp_creditnote_products');
   }
}
