<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_payroll_benefits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('benefit_code');
            $table->char('title');
            $table->char('taxable');
            $table->char('rate');
            $table->text('description')->nullable();
            $table->char('created_by');
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
        Schema::dropIfExists('hr_payroll_benefits');
    }
}
