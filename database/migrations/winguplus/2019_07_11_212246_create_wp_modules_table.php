<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpModulesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_modules', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('module_code', 255);
         $table->char('title', 255);
         $table->text('name')->nullable();
         $table->text('orders')->nullable();
         $table->text('parent_code')->nullable();
         $table->text('caption')->nullable();
         $table->text('introduction')->nullable();
         $table->text('icon')->nullable();
         $table->text('description')->nullable();
         $table->text('price')->nullable();
         $table->char('offer')->nullable();
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
      Schema::dropIfExists('wp_modules');
   }
}
