<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeFamilyInfoTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_family_info', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('family_code');
         $table->char('family_name')->nullable();
         $table->char('relationship')->nullable();
         $table->char('contact_type')->nullable();
         $table->char('family_dob')->nullable();
         $table->char('family_contact')->nullable();
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
      Schema::dropIfExists('hr_employee_family_info');
   }
}
