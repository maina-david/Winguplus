<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbTicketAllocationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_ticket_allocations', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('ticket');
         $table->char('user');
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
      Schema::dropIfExists('jb_ticket_allocations');
   }
}
