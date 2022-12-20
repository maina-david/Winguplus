<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbJobsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_jobs', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('job_code');
         $table->char('image')->nullable();
         $table->char('job_title')->nullable();
         $table->text('description')->nullable();
         $table->text('brief_info')->nullable();
         $table->char('customer')->nullable();
         $table->char('job_type')->nullable();
         $table->char('lead')->nullable();
         $table->char('start_date')->nullable();
         $table->char('end_date')->nullable();
         $table->char('progress')->nullable();
         $table->char('status')->nullable();
         $table->char('budget')->nullable();
         $table->char('visibility_status')->nullable();
         $table->char('notify_client')->nullable();
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
      Schema::dropIfExists('jb_jobs');
   }
}
