<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsBlogCategoryTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_blog_category', function (Blueprint $table) {
         $table->id();
         $table->char('parent_code')->nullable();
         $table->char('name')->nullable();
         $table->char('url')->nullable();
         $table->text('description')->nullable();
         $table->char('keywords')->nullable();
         $table->char('meta_description')->nullable();
         $table->char('image')->nullable();
         $table->char('featured')->nullable();
         $table->integer('status')->nullable();
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
      Schema::dropIfExists('cms_blog_category');
   }
}
