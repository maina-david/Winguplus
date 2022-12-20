<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnFeeStructureTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_fee_structure', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('structure_code');
         $table->char('title');
         $table->char('amount');
         $table->integer('status')->nullable();
         $table->char('note')->nullable();
         $table->date('start_date')->nullable();
         $table->date('end_date')->nullable();
         $table->char('created_by');
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
      Schema::dropIfExists('fn_fee_structure');
   }
}
