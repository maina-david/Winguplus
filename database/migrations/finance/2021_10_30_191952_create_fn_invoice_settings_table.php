<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnInvoiceSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_invoice_settings', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('name')->nullable();
         $table->integer('number')->nullable();
         $table->char('prefix', 255)->nullable();
         $table->char('editing_of_sent', 20)->nullable();
         $table->char('notify_on_payment', 20)->nullable();
         $table->char('automate_thank_you_note', 20)->nullable();
         $table->text('default_terms_conditions')->nullable();
         $table->text('default_customer_notes')->nullable();
         $table->text('auto_archive')->nullable();
         $table->char('automatically_email_recurring', 20)->nullable();
         $table->text('default_invoice_footer')->nullable();
         $table->char('show_discount_tab',20)->nullable();
         $table->char('show_tax_tab',20)->nullable();
         $table->char('show_item_tax_tab', 20)->nullable();
         $table->char('auto_thank_you_payment_received', 20)->nullable();
         $table->char('is_default')->default('No');
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
      Schema::dropIfExists('fn_invoice_settings');
   }
}
