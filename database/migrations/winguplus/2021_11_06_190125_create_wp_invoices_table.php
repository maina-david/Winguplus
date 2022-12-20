<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpInvoicesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_invoices', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('invoice_code');
         $table->char('module_code')->nullable();
         $table->char('number')->nullable();
         $table->char('prefix')->nullable();
         $table->char('reference')->nullable();
         $table->char('invoice_title')->nullable();
         $table->char('status')->nullable();
         $table->char('credited')->nullable();
         $table->char('currency')->nullable();
         $table->char('customer_note')->nullable();
         $table->text('terms')->nullable();
         $table->text('description')->nullable();
         $table->char('main_amount')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('paid')->nullable();
         $table->char('balance')->nullable();
         $table->char('discount')->nullable();
         $table->datetime('invoice_date')->nullable();
         $table->datetime('invoice_due')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('send_remainder')->nullable();
         $table->char('remainder_count')->nullable();
         $table->char('tax_config')->nullable();
         $table->char('sent_status')->nullable();
         $table->datetime('view_date')->nullable();
         $table->char('view_count')->nullable();
         $table->char('sales_person')->nullable();
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
      Schema::dropIfExists('wp_invoices');
   }
}
