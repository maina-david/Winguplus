<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceStoreDetailsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('ecommerce_store_details', function (Blueprint $table) {
         $table->id();
         $table->char('business_code',255)->nullable();
         $table->char('store_code',255)->nullable();
         $table->char('store_title',255)->nullable();
         $table->char('domain',255)->nullable();
         $table->text('return_policy')->nullable();
         $table->text('refund_policy')->nullable();
         $table->text('payment_policy')->nullable();
         $table->text('privacy_policy')->nullable();
         $table->text('terms_and_conditions')->nullable();
         $table->char('show_available_quantity',20)->nullable();
         $table->char('notification_email',255)->nullable();
         $table->char('phone_number',100)->nullable();
         $table->char('promote_consent',20)->nullable();
         $table->text('store_description')->nullable();
         $table->char('store_meta_description',255)->nullable();
         $table->char('facebook',255)->nullable();
         $table->char('instagram',255)->nullable();
         $table->char('twitter',255)->nullable();
         $table->char('linkedin',255)->nullable();
         $table->char('pinterest',255)->nullable();
         $table->char('delivery_method',255)->nullable();
         $table->char('logo',255)->nullable();
         $table->char('facebook_pixel',255)->nullable();
         $table->char('google_analytics',255)->nullable();
         $table->char('location_address',255)->nullable();
         $table->integer('created_by');
         $table->integer('updated_by')->nullable();
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
      Schema::dropIfExists('ecommerce_store_details');
   }
}
