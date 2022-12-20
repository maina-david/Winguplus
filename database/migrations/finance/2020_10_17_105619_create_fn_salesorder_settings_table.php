<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnSalesorderSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_salesorder_settings', function (Blueprint $table) {
         $table->id();
         $table->integer('business_code');
         $table->char('name')->nullable();
         $table->integer('number');
         $table->char('prefix')->nullable();
         $table->integer('updated_by')->nullable();
         $table->char('is_default')->default('No');
         $table->integer('created_by');
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
      Schema::dropIfExists('fn_salesorder_settings');
   }
}
