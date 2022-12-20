<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnProductInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fn_product_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('product_code');
            $table->char('product_name', 255)->nullable();
            $table->char('parent_product', 100)->nullable();
            $table->char('type')->nullable();
            $table->char('sku_code')->nullable();
            $table->char('manufacture_code')->nullable();
            $table->text('tags')->nullable();
            $table->text('brand')->nullable();
            $table->char('units')->nullable();
            $table->char('measure')->nullable();
            $table->char('weight')->nullable();
            $table->char('supplier')->nullable();
            $table->char('pos_item')->nullable();
            $table->char('track_inventory')->nullable();
            $table->char('same_price')->nullable();
            $table->char('ecommerce_item')->nullable();
            $table->char('size')->nullable();
            $table->char('color')->nullable();
            $table->char('short_description')->nullable();
            $table->char('notification_email')->nullable();
            $table->char('bill_count')->nullable();
            $table->char('billing_period')->nullable();
            $table->char('billing_type')->nullable();
            $table->char('bill_cycle')->nullable();
            $table->char('trial_days')->nullable();
            $table->char('url')->nullable();
            $table->text('description')->nullable();
            $table->char('trash')->nullable();
            $table->char('attribute')->nullable();
            $table->char('value')->nullable();
            $table->integer('status')->nullable();
            $table->char('active')->nullable();
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
        Schema::dropIfExists('fn_product_information');
    }
}
