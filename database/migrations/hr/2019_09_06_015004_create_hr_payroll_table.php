<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_payroll', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('payroll_code')->nullable();
         $table->char('total_net_pay')->nullable();
         $table->char('total_gross_pay')->nullable();
         $table->char('total_additions')->nullable();
         $table->char('total_deductions')->nullable();
         $table->char('total_salary')->nullable();
         $table->date('payroll_date')->nullable();
         $table->char('payroll_type')->nullable();
         $table->char('branch_code')->nullable();
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
      Schema::dropIfExists('hr_payroll');
   }
}
