<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeBankInfoTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_bank_info', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code')->nullable();
         $table->char('account_number')->nullable();
         $table->char('bank_name')->nullable();
         $table->char('bank_branch')->nullable();
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
      Schema::dropIfExists('hr_employee_bank_info');
   }
}
