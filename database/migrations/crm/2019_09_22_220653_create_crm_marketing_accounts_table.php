<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmMarketingAccountsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_marketing_accounts', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('account_code');
         $table->char('customer_code');
         $table->char('channel_code');
         $table->text('description');
         $table->char('budget');
         $table->integer('status')->nullable();
         $table->date('account_date');
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
      Schema::dropIfExists('crm_marketing_accounts');
   }
}
