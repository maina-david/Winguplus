<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employees', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('names')->nullable();
         $table->char('gender')->nullable();
         $table->char('employee_image')->nullable();
         $table->char('leave_days')->nullable();
         $table->integer('status')->nullable();
         $table->text('job_description')->nullable();
         $table->char('department')->nullable();
         $table->char('branch')->nullable();
         $table->char('position')->nullable();
         $table->char('companyID')->nullable();
         $table->char('company_email')->nullable();
         $table->char('company_phone_number')->nullable();
         $table->char('office_phone_extension')->nullable();
         $table->char('source_of_hire')->nullable();
         $table->char('contract_type')->nullable();
         $table->date('hire_date')->nullable();
         $table->char('current_status')->nullable();
         $table->char('employment_status')->nullable();
         $table->date('termination_date')->nullable();
         $table->char('image')->nullable();
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
      Schema::dropIfExists('hr_employees');
   }
}
