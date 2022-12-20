<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeSalaryTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_salary', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('payment_basis')->nullable();
         $table->char('salary_amount')->nullable();
         $table->char('payment_method')->nullable();
         $table->char('total_deductions')->nullable();
         $table->char('total_additions')->nullable();
         $table->char('mpesa_number')->nullable();
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
      Schema::dropIfExists('hr_employee_salary');
   }
}
