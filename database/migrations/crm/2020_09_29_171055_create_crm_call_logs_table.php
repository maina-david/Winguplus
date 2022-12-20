<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCallLogsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_call_logs', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('log_code');
         $table->char('parent_code');
         $table->char('subject',255);
         $table->text('note')->nullable();
         $table->char('section',50);
         $table->char('phone_number',100);
         $table->char('contact_person',255);
         $table->char('hours',20);
         $table->char('minutes',20);
         $table->char('seconds',20);
         $table->char('call_type',100);
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
      Schema::dropIfExists('crm_call_logs');
   }
}
