<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmLeadEventsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_lead_events', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('event_code')->nullable();
         $table->char('lead_code')->nullable();
         $table->char('priority')->nullable();
         $table->char('status')->nullable();
         $table->char('owner')->nullable();
         $table->date('start_date')->nullable();
         $table->date('start_time')->nullable();
         $table->date('end_date')->nullable();
         $table->date('end_time')->nullable();
         $table->text('description')->nullable();
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
      Schema::dropIfExists('crm_lead_events');
   }
}
