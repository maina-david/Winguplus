<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnEstimatesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_estimates', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('estimate_code');
         $table->char('customer_code');
         $table->char('status')->nullable();
         $table->char('currency')->nullable();
         $table->char('reference_number')->nullable();
         $table->char('title')->nullable();
         $table->char('customer_note')->nullable();
         $table->text('terms')->nullable();
         $table->integer('estimate_number')->nullable();
         $table->integer('estimate_prefix')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('discount')->nullable();
         $table->char('discount_type')->nullable();
         $table->date('estimate_date')->nullable();
         $table->date('estimate_due')->nullable();
         $table->char('tax')->nullable();
         $table->char('invoice_link')->nullable();
         $table->char('attachment')->nullable();
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
      Schema::dropIfExists('fn_estimates');
   }
}
