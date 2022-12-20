<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpBusinessTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_business', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code',255);
         $table->char('plan_code',255)->nullable();
         $table->date('due_date')->nullable();
         $table->date('date_joined')->nullable();
         $table->char('name',255)->nullable();
         $table->char('logo',255)->nullable();
         $table->char('industry')->nullable();
         $table->char('country')->nullable();
         $table->char('postal_address', 100)->nullable();
         $table->char('location',255)->nullable();
         $table->char('city', 255)->nullable();
         $table->char('state_province', 255)->nullable();
         $table->char('zip_code', 50)->nullable();
         $table->char('phone_number', 100)->nullable();
         $table->char('fax', 255)->nullable();
         $table->char('email', 255)->nullable();
         $table->dateTime('email_verified_at')->nullable();
         $table->char('update_address_in_all',10)->nullable();
         $table->char('currency')->nullable();
         $table->char('fiscal_year')->nullable();
         $table->char('website', 255)->nullable();
         $table->char('company_size', 100)->nullable();
         $table->char('language')->nullable();
         $table->char('time_zone', 255)->nullable();
         $table->char('date_format')->nullable();
         $table->char('signature')->nullable();
         $table->char('template_code')->nullable();
         $table->char('telephony_code')->nullable();
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
      Schema::dropIfExists('wp_business');
   }
}
