<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnFeeItemsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_fee_items', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('item_code');
         $table->char('name')->nullable();
         $table->char('description')->nullable();
         $table->char('price')->nullable();
         $table->char('group')->nullable();
         $table->char('status')->nullable();
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
      Schema::dropIfExists('fn_fee_items');
   }
}
