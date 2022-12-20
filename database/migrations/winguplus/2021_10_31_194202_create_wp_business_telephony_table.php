<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpBusinessTelephonyTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_business_telephony', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('telephony_code');
         $table->char('at_username')->nullable();
         $table->char('at_apikey')->nullable();
         $table->char('sms_from')->nullable();
         $table->char('tw_sid')->nullable();
         $table->char('tw_token')->nullable();
         $table->integer('status')->nullable();
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
      Schema::dropIfExists('wp_business_telephony');
   }
}
