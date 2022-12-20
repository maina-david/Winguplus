<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fn_product_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('product_code');
            $table->char('price_code');
            $table->char('buying_price')->default(0);
            $table->char('selling_price')->default(0);
            $table->char('offer_price')->default(0);
            $table->char('branch_code')->default(0);
            $table->char('default_price')->default(0);
            $table->char('setup_fee')->default(0);
            $table->integer('taxID')->default(0);
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
        Schema::dropIfExists('fn_product_price');
    }
}
