<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpCountryTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_country', function (Blueprint $table) {
         $table->id();
         $table->char('iso')->nullable();
         $table->char('name')->nullable();
         $table->char('iso3')->nullable();
         $table->char('numcode')->nullable();
         $table->char('phonecode')->nullable();
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
      Schema::dropIfExists('wp_country');
   }
}
