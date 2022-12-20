<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmDealsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_deals', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('deal_code');
         $table->char('title',255);
         $table->char('pipeline')->nullable();
         $table->char('stage')->nullable();
         $table->char('value',50)->nullable();
         $table->char('contact',255)->nullable();
         $table->char('owner',255)->nullable();
         $table->char('account',255)->nullable();
         $table->char('status')->nullable();
         $table->date('close_date')->nullable();
         $table->text('description')->nullable();
         $table->char('created_by',255)->nullable();
         $table->char('updated_by',255)->nullable();
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
      Schema::dropIfExists('crm_deals');
   }
}
