<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeEquipmentAuthorizationTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_employee_equipment_authorization', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('employee_code');
         $table->char('equipment_name');
         $table->char('reff_number')->nullable();
         $table->date('date_allocated')->nullable();
         $table->text('condition_before_allocation')->nullable();
         $table->text('comments')->nullable();
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
      Schema::dropIfExists('hr_employee_equipment_authorization');
   }
}
