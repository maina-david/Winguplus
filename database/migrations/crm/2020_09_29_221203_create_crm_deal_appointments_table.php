<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmDealAppointmentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_deal_appointments', function (Blueprint $table) {
         $table->id();
         $table->char('business_code',255);
         $table->char('appointment_code',255);
         $table->char('deal_code');
         $table->char('title',255);
         $table->char('priority',100);
         $table->char('status',100);
         $table->char('owner');
         $table->date('start_date',255);
         $table->char('start_time',20)->nullable();
         $table->date('end_date',255);
         $table->char('end_time',20)->nullable();
         $table->text('description');
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
      Schema::dropIfExists('crm_deal_appointments');
   }
}
