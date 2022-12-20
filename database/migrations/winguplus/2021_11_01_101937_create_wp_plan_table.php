<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpPlanTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_plan', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('plan_code');
         $table->char('title')->nullable();
         $table->integer('status')->nullable();
         $table->char('intro')->nullable();
         $table->char('features')->nullable();
         $table->char('price')->nullable();
         $table->char('usd')->nullable();
         $table->integer('invoices')->default(0);
         $table->integer('employees')->default(0);
         $table->integer('lpos')->default(0);
         $table->integer('users')->default(0);
         $table->integer('leads')->default(0);
         $table->integer('customers')->default(0);
         $table->integer('suppliers')->default(0);
         $table->integer('projects')->default(0);
         $table->integer('products')->default(0);
         $table->integer('storage')->default(0);
         $table->integer('expenses')->default(0);
         $table->integer('quotes')->default(0);
         $table->integer('credit_note')->default(0);
         $table->integer('tasks')->default(0);
         $table->integer('task_groups')->default(0);
         $table->integer('notes')->default(0);
         $table->integer('tickets')->default(0);
         $table->integer('subscriptions')->default(0);
         $table->integer('assets')->default(0);
         $table->integer('roles')->default(0);
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
      Schema::dropIfExists('wp_plan');
   }
}
