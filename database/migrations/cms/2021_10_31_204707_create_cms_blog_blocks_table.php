<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsBlogBlocksTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_blog_blocks', function (Blueprint $table) {
         $table->id();
         $table->char('code')->nullable();
         $table->char('title')->nullable();
         $table->char('blog_code')->nullable();
         $table->char('block_type')->nullable();
         $table->char('code_type')->nullable();
         $table->char('content')->nullable();
         $table->char('position')->nullable();
         $table->char('parent_code')->nullable();
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
      Schema::dropIfExists('cms_blog_blocks');
   }
}
