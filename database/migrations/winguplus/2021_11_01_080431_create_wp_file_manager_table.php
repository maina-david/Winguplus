<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpFileManagerTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_file_manager', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('file_code');
         $table->char('parent_link')->nullable();
         $table->char('name')->nullable();
         $table->char('file_name')->nullable();
         $table->text('description')->nullable();
         $table->char('file_mime')->nullable();
         $table->char('file_size')->nullable();
         $table->char('cover')->nullable();
         $table->char('attach')->nullable();
         $table->char('folder')->nullable();
         $table->char('section')->nullable();
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
      Schema::dropIfExists('wp_file_manager');
   }
}
