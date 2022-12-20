<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeePersonalInfoTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_personal_info', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('passport_number')->nullable();
         $table->char('personal_email')->nullable();
         $table->char('personal_number')->nullable();
         $table->char('nationalID')->nullable();
         $table->date('dob')->nullable();
         $table->char('home_address')->nullable();
         $table->char('current_home_location')->nullable();
         $table->char('region_of_birth')->nullable();
         $table->char('nationality')->nullable();
         $table->char('marital_status')->nullable();
         $table->char('nssf_number')->nullable();
         $table->char('nhif_number')->nullable();
         $table->char('helb_loan_amount')->nullable();
         $table->char('hospital_of_choice')->nullable();
         $table->char('description')->nullable();
         $table->char('religion')->nullable();
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
      Schema::dropIfExists('hr_employee_personal_info');
   }
}
