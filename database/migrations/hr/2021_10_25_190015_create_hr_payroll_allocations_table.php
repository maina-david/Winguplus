<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrPayrollAllocationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_payroll_allocations', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee')->nullable();
         $table->char('deduction')->nullable();
         $table->char('benefit')->nullable();
         $table->char('rate')->nullable();
         $table->char('amount')->nullable();
         $table->char('category')->nullable();
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
      Schema::dropIfExists('hr_payroll_allocations');
   }
}
