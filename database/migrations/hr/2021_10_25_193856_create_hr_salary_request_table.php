<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrSalaryRequestTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_salary_request', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code')->nullable();
         $table->dateTime('date_of_request');
         $table->dateTime('date_needed');
         $table->char('amount');
         $table->char('reason')->nullable();
         $table->char('status')->nullable();
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
      Schema::dropIfExists('hr_salary_request');
   }
}
