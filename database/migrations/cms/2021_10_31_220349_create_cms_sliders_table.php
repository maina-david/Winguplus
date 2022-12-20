<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsSlidersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_sliders', function (Blueprint $table) {
         $table->id();
         $table->char('caption_one')->nullable();
         $table->char('caption_two')->nullable();
         $table->char('caption_three')->nullable();
         $table->char('url')->nullable();
         $table->integer('status')->nullable();
         $table->char('image')->nullable();
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
      Schema::dropIfExists('cms_sliders');
   }
}
