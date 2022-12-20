<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbEventsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_events', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('event_code');
         $table->char('job');
         $table->char('title');
         $table->text('description')->nullable();
         $table->text('results')->nullable();
         $table->date('start_date')->nullable();
         $table->time('start_time')->nullable();
         $table->date('end_date')->nullable();
         $table->time('end_time')->nullable();
         $table->char('status')->nullable();
         $table->char('venue', 255)->nullable();
         $table->char('priority')->nullable();
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
      Schema::dropIfExists('jb_events');
   }
}
