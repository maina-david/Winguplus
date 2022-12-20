<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbJobMemberTable extends Migration
{
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
      Schema::create('jb_job_member', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('user_code');
         $table->char('job_code');
         $table->char('created_by');
         $table->char('updated_by');
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
      Schema::dropIfExists('jb_job_member');
   }
}
