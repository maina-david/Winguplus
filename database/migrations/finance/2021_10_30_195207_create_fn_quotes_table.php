<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnQuotesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_quotes', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('quote_code');
         $table->char('customer_code')->nullable();
         $table->char('status')->nullable();
         $table->char('reference_number')->nullable();
         $table->text('customer_note')->nullable();
         $table->char('subject')->nullable();
         $table->text('description')->nullable();
         $table->text('terms')->nullable();
         $table->char('quote_number')->nullable();
         $table->char('main_amount')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('discount')->nullable();
         $table->char('discount_type')->nullable();
         $table->char('quote_date')->nullable();
         $table->char('quote_due')->nullable();
         $table->char('tax')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('tax_config')->nullable();
         $table->char('invoice_link')->nullable();
         $table->char('remainder_count')->nullable();
         $table->char('sent_status')->nullable();
         $table->char('view_count')->nullable();
         $table->date('view_date')->nullable();
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
      Schema::dropIfExists('fn_quotes');
   }
}
