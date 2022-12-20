<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbSections extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_sections', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('section_code');
         $table->char('job_code');
         $table->char('title');
         $table->integer('priority')->nullable();
         $table->integer('status')->nullable();
         $table->char('color')->nullable();
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
      Schema::dropIfExists('jb_sections');
   }
}
