<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_stations', function (Blueprint $table) {
            $table->id();
            $table->char('business_code');
            $table->char('station_code');
            $table->char('title')->nullable();
            $table->char('location')->nullable();
            $table->char('address')->nullable();
            $table->char('phone_number')->nullable();
            $table->char('person_incharge')->nullable();
            $table->text('description')->nullable();
            $table->date('established')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('hr_stations');
    }
}
