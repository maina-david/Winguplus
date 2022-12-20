<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpModulesFunctionalityTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_modules_functionality', function (Blueprint $table) {
         $table->id();
         $table->char('module_code');
         $table->char('function_code');
         $table->char('parent_code');
         $table->char('title')->nullable();
         $table->integer('status')->nullable();
         $table->char('icon')->nullable();
         $table->text('introduction')->nullable();
         $table->text('description')->nullable();
         $table->char('code_details')->nullable();
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
      Schema::dropIfExists('wp_modules_functionality');
   }
}
