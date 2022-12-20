<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmLeadTasksTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_lead_tasks', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('task_code');
         $table->char('lead_code');
         $table->char('title')->nullable();
         $table->char('category')->nullable();
         $table->date('start_date')->nullable();
         $table->date('due_date')->nullable();
         $table->char('assigned_to')->nullable();
         $table->char('priority')->nullable();
         $table->integer('status')->nullable();
         $table->text('description')->nullable();
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
      Schema::dropIfExists('crm_lead_tasks');
   }
}
