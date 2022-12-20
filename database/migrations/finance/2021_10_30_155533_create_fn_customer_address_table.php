<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnCustomerAddressTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_customer_address', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('customer_code');
         $table->char('bill_street')->nullable();
         $table->char('bill_city')->nullable();
         $table->char('bill_state')->nullable();
         $table->char('bill_postal_address')->nullable();
         $table->char('bill_zip_code')->nullable();
         $table->char('bill_country')->nullable();
         $table->char('bill_fax')->nullable();
         $table->char('ship_street')->nullable();
         $table->char('ship_city')->nullable();
         $table->char('ship_state')->nullable();
         $table->char('ship_zip_code')->nullable();
         $table->char('ship_postal_address')->nullable();
         $table->char('ship_country')->nullable();
         $table->char('ship_fax')->nullable();
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
      Schema::dropIfExists('fn_customer_address');
   }
}
