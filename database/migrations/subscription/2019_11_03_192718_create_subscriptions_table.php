<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('subscriptions', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('subscription_code');
         $table->char('customer');
         $table->char('subscription_number');
         $table->char('reference')->nullable();
         $table->date('starts_on');
         $table->date('next_billing');
         $table->date('last_billing');
         $table->char('sales_person')->nullable();
         $table->char('expiration_cycle')->nullable();
         $table->char('cycles')->nullable();
         $table->char('amount');
         $table->char('price');
         $table->char('trial_days')->nullable();
         $table->date('trial_end_date')->nullable();
         $table->char('product');
         $table->char('plan');
         $table->char('qty');
         $table->char('tax_rate')->nullable();
         $table->char('status')->nullable();
         $table->char('created_by');
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
      Schema::dropIfExists('subscriptions');
   }
}
