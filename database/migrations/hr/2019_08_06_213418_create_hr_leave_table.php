<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('leave_code');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('days')->nullable();
            $table->integer('statusID')->nullable();
            $table->text('reason')->nullable();
            $table->char('type_code')->nullable();
            $table->char('employee_code')->nullable();
            $table->char('head_code')->nullable();
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
        Schema::dropIfExists('hr_leave');
    }
}
