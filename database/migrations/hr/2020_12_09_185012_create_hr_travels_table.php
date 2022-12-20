<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrTravelsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_travels', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('travel_code');
         $table->char('expense_code')->nullable();
         $table->char('place_of_visit',255)->nullable();
         $table->char('department_code')->nullable();
         $table->date('date_of_arrival')->nullable();
         $table->date('departure_date')->nullable();
         $table->char('duration',50)->nullable();
         $table->char('purpose_of_visit',255)->nullable();
         $table->char('customer_code')->nullable();
         $table->char('bill_customer',20)->nullable();
         $table->char('status')->nullable();
         $table->char('approved_by')->nullable();
         $table->date('approval_date')->nullable();
         $table->char('amount')->nullable();
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
      Schema::dropIfExists('hr_travels');
   }
}
