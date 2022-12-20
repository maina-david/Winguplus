<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wp_activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('activity');
            $table->char('module', 200);
            $table->char('section', 200);
            $table->char('action', 200);
            $table->char('user_code');
            $table->char('business_code');
            $table->char('activity_code');
            $table->char('ip_address', 200);
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
        Schema::dropIfExists('wp_activity_log');
    }
}
