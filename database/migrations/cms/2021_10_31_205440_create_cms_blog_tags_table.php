<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsBlogTagsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_blog_tags', function (Blueprint $table) {
         $table->id();
         $table->char('name')->nullable();
         $table->char('status')->nullable();
         $table->char('feature')->nullable();
         $table->char('section')->nullable();
         $table->char('url')->nullable();
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
      Schema::dropIfExists('cms_blog_tags');
   }
}
