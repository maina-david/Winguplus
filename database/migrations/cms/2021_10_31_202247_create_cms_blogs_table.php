<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsBlogTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_blog', function (Blueprint $table) {
         $table->id();
         $table->char('code');
         $table->char('title')->nullable();
         $table->char('synopsis')->nullable();
         $table->char('thumbnail')->nullable();
         $table->char('blog_type')->nullable();
         $table->char('url')->nullable();
         $table->char('meta_tags')->nullable();
         $table->char('meta_description')->nullable();
         $table->char('status')->nullable();
         $table->char('visibility')->nullable();
         $table->char('publish_time')->nullable();
         $table->char('featured')->nullable();
         $table->char('view_count')->nullable();
         $table->char('comment')->nullable();
         $table->char('trash')->nullable();
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
      Schema::dropIfExists('cms_blog');
   }
}
