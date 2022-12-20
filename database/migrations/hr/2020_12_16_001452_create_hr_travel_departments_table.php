<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrTravelDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_travel_departments', function (Blueprint $table) {
            $table->id();
            $table->char('business_code');
            $table->char('travel_code');
            $table->char('department_code');
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
        Schema::dropIfExists('hr_travel_departments');
    }
}
