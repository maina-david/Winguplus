<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnPurchaseorderSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_purchaseorder_settings', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('name')->nullable();
         $table->char('number');
         $table->char('prefix')->nullable();
         $table->char('is_default')->default('No');
         $table->char('created_by');
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
      Schema::dropIfExists('fn_purchaseorder_settings');
   }
}
