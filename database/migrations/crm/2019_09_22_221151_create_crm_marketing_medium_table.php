<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmMarketingMediumTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_marketing_medium', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('name');
         $table->char('created_by');
         $table->char('updated_by');
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
      Schema::dropIfExists('crm_marketing_medium');
   }
}
