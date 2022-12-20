<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fn_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('tax_code');
            $table->char('name', 200);
            $table->integer('rate');
            $table->char('compound',10)->nullable();
            $table->text('description')->nullable();
            $table->char('created_by');
            $table->char('updated_by');
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
        Schema::dropIfExists('fn_taxes');
    }
}
