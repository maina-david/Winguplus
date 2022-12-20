<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWcEventsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wc_events', function (Blueprint $table) {
         $table->id();
         $table->char('business_code',255);
         $table->char('event_code',255);
         $table->char('title')->nullable();
         $table->char('tagline')->nullable();
         $table->char('available_tickets',11)->nullable();
         $table->char('type')->nullable();
         $table->date('start_date')->nullable();
         $table->time('start_time')->nullable();
         $table->time('end_date')->nullable();
         $table->char('end_time')->nullable();
         $table->char('location',255)->nullable();
         $table->text('map')->nullable();
         $table->text('details')->nullable();
         $table->char('cover_image',255)->nullable();
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
      Schema::dropIfExists('wc_events');
   }
}
