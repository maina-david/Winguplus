<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpGoalsTable extends Migration
{
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
      Schema::create('wp_goals', function (Blueprint $table) {
         $table->id();
         $table->char('subject')->nullable();
         $table->char('goal_type')->nullable();
         $table->char('achievement')->nullable();
         $table->date('start_date')->nullable();
         $table->date('end_date')->nullable();
         $table->char('notify_when_achieve')->nullable();
         $table->char('notify_when_fail')->nullable();
         $table->text('description')->nullable();
         $table->integer('status')->nullable();
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
      Schema::dropIfExists('wp_goals');
   }
}
