<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpTelephonyTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_telephony', function (Blueprint $table) {
         $table->id();
         $table->char('telephony_code');
         $table->char('name');
         $table->char('logo');
         $table->integer('status');
         $table->char('created_by');
         $table->char('updated_by');
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
      Schema::dropIfExists('wp_telephony');
   }
}
