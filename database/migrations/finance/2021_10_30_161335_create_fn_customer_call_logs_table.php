<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnCustomerCallLogsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_customer_call_logs', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('customer_code')->nullable();
         $table->char('subject')->nullable();
         $table->text('note')->nullable();
         $table->char('phone_code')->nullable();
         $table->char('phone_number')->nullable();
         $table->char('call_type')->nullable();
         $table->char('status')->nullable();
         $table->integer('hours')->default(0);
         $table->integer('minutes')->default(0);
         $table->integer('seconds')->default(0);
         $table->char('contact_person')->nullable();
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
      Schema::dropIfExists('fn_customer_call_logs');
   }
}
