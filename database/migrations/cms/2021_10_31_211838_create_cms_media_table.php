<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsMediaTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_media', function (Blueprint $table) {
         $table->id();
         $table->char('section_code')->nullable();
         $table->char('folder')->nullable();
         $table->char('name')->nullable();
         $table->char('file_name')->nullable();
         $table->char('file_size')->nullable();
         $table->char('file_mime')->nullable();
         $table->char('cover')->nullable();
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
      Schema::dropIfExists('cms_media');
   }
}
