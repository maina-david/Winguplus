<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbTaskGroupsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_task_groups', function (Blueprint $table) {
         $table->increments('id');
         $table->char('business_code');
         $table->char('job');
         $table->char('group_code');
         $table->char('section_code')->nullable();
         $table->char('name')->nullable();
         $table->char('priority')->nullable();
         $table->char('visibility')->nullable();
         $table->char('description')->nullable();
         $table->char('created_by')->nullable();
         $table->char('Updated_by')->nullable();
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
      Schema::dropIfExists('jb_task_groups');
   }
}
