<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbTicketsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_tickets', function (Blueprint $table) {
         $table->id();
         $table->char('business_code')->nullable();
         $table->char('ticket_code')->nullable();
         $table->char('job')->nullable();
         $table->char('status')->nullable();
         $table->char('priority')->nullable();
         $table->char('customer')->nullable();
         $table->char('name')->nullable();
         $table->text('description')->nullable();
         $table->date('due_date')->nullable();
         $table->date('close_date')->nullable();
         $table->date('start_date')->nullable();
         $table->char('progress')->nullable();
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
      Schema::dropIfExists('jb_tickets');
   }
}
