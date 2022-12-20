<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnPaymentIntegrationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_payment_integrations', function (Blueprint $table) {
         $table->id();
         $table->char('integration_code');
         $table->char('name')->nullable();
         $table->char('logo')->nullable();
         $table->char('status')->nullable();
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
      Schema::dropIfExists('fn_payment_integrations');
   }
}
