<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wingujobs_experience', function (Blueprint $table) {
            $table->id();
            $table->char('user_code');
            $table->char('employer')->nullable();
            $table->char('job_title')->nullable();
            $table->char('job_level')->nullable();
            $table->char('country')->nullable();
            $table->char('industry')->nullable();
            $table->char('job_function')->nullable();
            $table->char('monthly_salary')->nullable();
            $table->char('work_type')->nullable();
            $table->char('city')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->char('is_current')->nullable();
            $table->text('job_responsibility')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
            $table->char('user_code')->nullable();
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
        Schema::dropIfExists('wingujobs_experience');
    }
}
