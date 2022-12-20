<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeInstitutionTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_institution', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('institution_code');
         $table->char('school_name')->nullable();
         $table->char('result_type')->nullable();
         $table->char('field_of_study')->nullable();
         $table->char('year_of_study')->nullable();
         $table->char('year_of_completion')->nullable();
         $table->text('results')->nullable();
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
      Schema::dropIfExists('hr_employee_institution');
   }
}
