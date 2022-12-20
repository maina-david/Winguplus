<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingujobsApplicationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wingujobs_applications', function (Blueprint $table) {
         $table->id();
         $table->char('user_code');
         $table->char('job_code')->nullable();
         $table->char('listing_code')->nullable();
         $table->char('name')->nullable();
         $table->text('cover_letter')->nullable();
         $table->char('salary_expectation')->nullable();
         $table->char('salary_currency')->nullable();
         $table->char('experience')->nullable();
         $table->char('qualification')->nullable();
         $table->char('phone_number')->nullable();
         $table->char('views')->nullable();
         $table->char('status')->nullable();
         $table->char('job_title')->nullable();
         $table->date('job_date')->nullable();
         $table->char('location')->nullable();
         $table->char('business_name')->nullable();
         $table->char('job_experice')->nullable();
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
      Schema::dropIfExists('wingujobs_applications');
   }
}
