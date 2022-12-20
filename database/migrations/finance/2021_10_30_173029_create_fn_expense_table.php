<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnExpenseTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_expense', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('expense_code');
         $table->char('travel_code')->nullable();
         $table->date('expense_date')->nullable();
         $table->char('expence_type')->nullable();
         $table->char('category')->nullable();
         $table->char('account')->nullable();
         $table->char('amount')->nullable();
         $table->char('tax_rate')->nullable();
         $table->char('deduct')->nullable();
         $table->char('refrence_number')->nullable();
         $table->char('expense_name')->nullable();
         $table->text('description')->nullable();
         $table->char('supplier')->nullable();
         $table->char('expense_type')->nullable();
         $table->char('calculate_type')->nullable();
         $table->char('distance')->nullable();
         $table->char('start_time')->nullable();
         $table->char('end_time')->nullable();
         $table->char('status')->nullable();
         $table->char('payment_method')->nullable();
         $table->char('mileage_rate')->nullable();
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
      Schema::dropIfExists('fn_expense');
   }
}
