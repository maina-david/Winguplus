<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsEducationTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wingujobs_education', function (Blueprint $table) {
         $table->id();
         $table->char('user_code');
         $table->char('name_of_education_institution')->nullable();
         $table->char('minmum_qualification')->nullable();
         $table->char('qualification')->nullable();
         $table->date('start_date')->nullable();
         $table->date('end_date')->nullable();
         $table->char('is_current')->nullable();
         $table->char('description')->nullable();
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
      Schema::dropIfExists('wingujobs_education');
   }
}
