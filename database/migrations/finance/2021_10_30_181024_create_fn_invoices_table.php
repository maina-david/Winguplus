<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnInvoicesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_invoices', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('invoice_code');
         $table->char('subscription_code');
         $table->char('invoice_type');
         $table->char('reference')->nullable();
         $table->char('invoice_title')->nullable();
         $table->char('customer')->nullable();
         $table->char('status')->nullable();
         $table->char('credited')->nullable();
         $table->char('currency')->nullable();
         $table->char('lpo_number')->nullable();
         $table->char('project_code')->nullable();
         $table->char('subscription_code')->nullable();
         $table->char('transaction_code')->nullable();
         $table->char('customer_note')->nullable();
         $table->char('terms')->nullable();
         $table->char('invoice_number')->nullable();
         $table->char('invoice_prefix')->nullable();
         $table->text('description')->nullable();
         $table->char('main_amount')->nullable();
         $table->char('sub_total')->nullable();
         $table->char('total')->nullable();
         $table->char('paid')->nullable();
         $table->char('balance')->nullable();
         $table->char('discount')->nullable();
         $table->char('invoice_date')->nullable();
         $table->char('invoice_due')->nullable();
         $table->char('tax_value')->nullable();
         $table->char('tax_rate')->nullable();
         $table->char('attachment')->nullable();
         $table->char('income_category')->nullable();
         $table->char('invoice_type')->nullable();
         $table->char('cycles_option')->nullable();
         $table->char('cycles_count')->nullable();
         $table->char('frequency_count')->nullable();
         $table->char('frequency_duration')->nullable();
         $table->char('send_remainder')->nullable();
         $table->integer('remainder_count')->nullable();
         $table->char('source')->nullable();
         $table->char('tax_config')->nullable();
         $table->char('sent_status')->nullable();
         $table->date('view_date')->nullable();
         $table->integer('view_count')->nullable();
         $table->char('sales_person')->nullable();
         $table->char('branch')->nullable();
         $table->char('shipping_county')->nullable();
         $table->integer('delivery_status')->nullable();
         $table->date('delivery_date')->nullable();
         $table->text('note_1')->nullable();
         $table->text('note_2')->nullable();
         $table->text('note_3')->nullable();
         $table->char('sh_student_code')->nullable();
         $table->char('sh_structure_code')->nullable();
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
        Schema::dropIfExists('fn_invoices');
    }
}
