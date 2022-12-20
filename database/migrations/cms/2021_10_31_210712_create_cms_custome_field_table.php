<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsCustomeFieldTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cms_custome_field', function (Blueprint $table) {
         $table->id();
         $table->char('page_code')->nullable();
         $table->char('title')->nullable();
         $table->text('content')->nullable();
         $table->char('section')->nullable();
         $table->char('textarea')->nullable();
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
      Schema::dropIfExists('cms_custome_field');
   }
}
