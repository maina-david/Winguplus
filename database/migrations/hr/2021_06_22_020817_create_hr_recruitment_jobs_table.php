<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrRecruitmentJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_recruitment_jobs', function (Blueprint $table) {
            $table->id();
            $table->char('business_code');
            $table->char('code',255);
            $table->char('title',255);
            $table->integer('status');
            $table->char('contract_type');
            $table->char('hiring_lead')->nullable();
            $table->char('department')->nullable();
            $table->char('experience')->nullable();
            $table->char('headcount')->nullable();
            $table->char('min_salary')->nullable();
            $table->char('max_salary')->nullable();
            $table->char('location')->nullable();
            $table->char('country')->nullable();
            $table->text('job_description')->nullable();
            $table->char('job_stage')->nullable();
            $table->char('listed',20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('hr_recruitment_jobs');
    }
}
