<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_payroll_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('payroll_code');
            $table->char('employee_code');
            $table->char('salary')->nullable();
            $table->char('net_pay')->nullable();
            $table->char('gross_pay')->nullable();
            $table->char('deduction')->nullable();
            $table->char('addition')->nullable();
            $table->char('payment_type')->nullable();
            $table->char('period')->nullable();
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
        Schema::dropIfExists('hr_payroll_people');
    }
}
