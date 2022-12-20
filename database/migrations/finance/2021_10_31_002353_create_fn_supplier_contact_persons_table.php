<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnSupplierContactPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fn_supplier_contact_persons', function (Blueprint $table) {
            $table->id();
            $table->char('business_code');
            $table->char('supplier_code');
            $table->char('supplier_name')->nullable();
            $table->char('salutation')->nullable();
            $table->char('names')->nullable();
            $table->char('contact_email')->nullable();
            $table->char('phone_number')->nullable();
            $table->char('designation')->nullable();
            $table->char('position')->nullable();
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
        Schema::dropIfExists('fn_supplier_contact_persons');
    }
}
