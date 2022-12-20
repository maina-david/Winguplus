<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsPageTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_page', function (Blueprint $table) {
         $table->id();
         $table->char('parent_code');
         $table->char('title')->nullable();
         $table->text('content')->nullable();
         $table->char('url')->nullable();
         $table->char('custom_url')->nullable();
         $table->char('thumbnail')->nullable();
         $table->char('meta_tags')->nullable();
         $table->char('meta_description')->nullable();
         $table->char('status')->nullable();
         $table->char('visibility')->nullable();
         $table->char('publish_time')->nullable();
         $table->char('template')->nullable();
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
      Schema::dropIfExists('cms_page');
   }
}
