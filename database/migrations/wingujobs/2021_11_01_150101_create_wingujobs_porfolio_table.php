<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsPorfolioTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wingujobs_porfolio', function (Blueprint $table) {
         $table->id();
         $table->char('user_code')->nullable();
         $table->char('title')->nullable();
         $table->char('link')->nullable();
         $table->char('description')->nullable();
         $table->char('created_by')->nullable();
         $table->char('update_by')->nullable();
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
      Schema::dropIfExists('wingujobs_porfolio');
   }
}
