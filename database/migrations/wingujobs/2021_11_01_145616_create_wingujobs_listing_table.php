<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsListingTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wingujobs_listing', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('code')->nullable();
         $table->char('job_code')->nullable();
         $table->date('start_date')->nullable();
         $table->date('closing_date')->nullable();
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
      Schema::dropIfExists('wingujobs_listing');
   }
}
