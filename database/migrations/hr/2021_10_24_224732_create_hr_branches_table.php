<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrBranchesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_branches', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('branch_code');
         $table->char('name');
         $table->char('country')->nullable();
         $table->char('city')->nullable();
         $table->char('address')->nullable();
         $table->char('phone_number')->nullable();
         $table->char('email')->nullable();
         $table->char('longitude')->nullable();
         $table->char('latitude')->nullable();
         $table->char('is_main')->nullable();
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
      Schema::dropIfExists('hr_branches');
   }
}
