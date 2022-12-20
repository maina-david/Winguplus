<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsUsersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wingujobs_users', function (Blueprint $table) {
         $table->id();
         $table->char('name')->nullable();
         $table->char('email')->nullable();
         $table->timestamp('email_verified_at')->nullable();
         $table->char('password')->nullable();
         $table->char('remember_token')->nullable();
         $table->date('dob')->nullable();
         $table->text('headline')->nullable();
         $table->char('gender')->nullable();
         $table->char('nationality')->nullable();
         $table->char('location')->nullable();
         $table->char('country_code')->nullable();
         $table->char('phone_number')->nullable();
         $table->char('qualification_level')->nullable();
         $table->char('current_job_function')->nullable();
         $table->text('preferred_jobs')->nullable();
         $table->text('preferred_locations')->nullable();
         $table->char('experience_duration')->nullable();
         $table->char('work_type')->nullable();
         $table->char('availability')->nullable();
         $table->char('min_expectation')->nullable();
         $table->char('max_expectation')->nullable();
         $table->char('avatar')->nullable();
         $table->text('bio')->nullable();
         $table->text('skills')->nullable();
         $table->text('language')->nullable();
         $table->text('cover_letter')->nullable();
         $table->char('cv_title')->nullable();
         $table->char('currency')->nullable();
         $table->char('current_cv')->nullable();
         $table->char('facebook')->nullable();
         $table->char('twitter')->nullable();
         $table->char('instagram')->nullable();
         $table->char('tiktok')->nullable();
         $table->char('linkedin')->nullable();
         $table->char('github')->nullable();
         $table->char('ip')->nullable();
         $table->dateTime('last_login')->nullable();
         $table->char('last_login_ip')->nullable();
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
      Schema::dropIfExists('wingujobs_users');
   }
}
