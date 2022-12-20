<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWcSpeakersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wc_speakers', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('event_code');
         $table->char('speaker_code');
         $table->char('name');
         $table->char('designation')->nullable();
         $table->text('bio')->nullable();
         $table->text('image')->nullable();
         $table->char('linkedin')->nullable();
         $table->char('twitter')->nullable();
         $table->char('facebook')->nullable();
         $table->char('medium')->nullable();
         $table->char('youtube')->nullable();
         $table->char('instagram')->nullable();
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
      Schema::dropIfExists('wc_speakers');
   }
}
