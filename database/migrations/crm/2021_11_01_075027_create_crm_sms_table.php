<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmSmsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_sms', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('sms_code');
         $table->char('sms_to')->nullable();
         $table->char('sms_from')->nullable();
         $table->text('message')->nullable();
         $table->char('channel_code')->nullable();
         $table->integer('status')->nullable();
         $table->char('sent_mode')->nullable();
         $table->char('section')->nullable();
         $table->char('customer_code')->nullable();
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
      Schema::dropIfExists('crm_sms');
   }
}
