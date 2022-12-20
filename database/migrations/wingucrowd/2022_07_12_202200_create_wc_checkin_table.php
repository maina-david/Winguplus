<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWcCheckinTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wc_checkin', function (Blueprint $table) {
         $table->id();
         $table->char('business_code',255);
         $table->char('ticket_code',255);
         $table->char('names')->nullable();
         $table->char('email')->nullable();
         $table->char('phone_number')->nullable();
         $table->char('otp')->nullable();
         $table->char('confirm_otp')->nullable();
         $table->char('longitude')->nullable();
         $table->char('latitude')->nullable();
         $table->char('mobile_device')->nullable();
         $table->char('browser')->nullable();
         $table->char('operating_system')->nullable();
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
      Schema::dropIfExists('wc_checkin');
   }
}
