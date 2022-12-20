<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fn_bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('account_code');
            $table->char('title',255);
            $table->text('description')->nullable();
            $table->char('initial_balance')->nullable();
            $table->char('account_number')->nullable();
            $table->char('contact_person')->nullable();
            $table->char('phone_number')->nullable();
            $table->char('banking_url',255)->nullable();
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
        Schema::dropIfExists('fn_bank_accounts');
    }
}
