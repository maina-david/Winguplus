<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmNotesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_notes', function (Blueprint $table) {
         $table->id();
         $table->char('note_code');
         $table->char('business_code');
         $table->char('parent_code');
         $table->char('subject',255);
         $table->text('note')->nullable();
         $table->char('section',50);
         $table->integer('created_by');
         $table->integer('updated_by');
         $table->integer('businessID');
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
      Schema::dropIfExists('crm_notes');
   }
}
