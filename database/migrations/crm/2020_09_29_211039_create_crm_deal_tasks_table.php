<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmDealTasksTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_deal_tasks', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('deal_code')->nullable();
         $table->char('task_code');
         $table->char('task',255);
         $table->date('date')->nullable();
         $table->char('time',20)->nullable();
         $table->char('assigned_to')->nullable();
         $table->char('priority',100)->nullable();
         $table->char('status',100)->nullable();
         $table->char('category',100)->nullable();
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
      Schema::dropIfExists('crm_deal_tasks');
   }
}
