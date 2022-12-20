<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wp_invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->char('name')->nullable();
            $table->char('number')->nullable();
            $table->char('prefix')->nullable();
            $table->text('editing_of_Sent')->nullable();
            $table->text('automate_thank_you_note')->nullable();
            $table->text('default_terms_conditions')->nullable();
            $table->text('default_customer_notes')->nullable();
            $table->text('auto_archive')->nullable();
            $table->text('automatically_email_recurring')->nullable();
            $table->text('default_invoice_footer')->nullable();
            $table->text('show_discount_tab')->nullable();
            $table->text('show_tax_tab')->nullable();
            $table->text('default_footer')->nullable();
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
        Schema::dropIfExists('wp_invoice_settings');
    }
}
