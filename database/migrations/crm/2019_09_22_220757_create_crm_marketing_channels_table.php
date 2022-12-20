<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmMarketingChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_marketing_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('channel_code');
            $table->char('customer_code');
            $table->char('medium_code');
            $table->char('account_name');
            $table->char('client_id');
            $table->char('client_secret');
            $table->char('redirect');
            $table->char('default_graph_version');
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
        Schema::dropIfExists('crm_marketing_channels');
    }
}
