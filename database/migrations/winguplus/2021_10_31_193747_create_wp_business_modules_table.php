<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpBusinessModulesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_business_modules', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('module_code')->nullable();
         $table->date('start_date')->nullable();
         $table->date('end_date')->nullable();
         $table->char('version')->nullable();
         $table->char('price')->nullable();
         $table->integer('payment_status')->nullable();
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
      Schema::dropIfExists('wp_business_modules');
   }
}
