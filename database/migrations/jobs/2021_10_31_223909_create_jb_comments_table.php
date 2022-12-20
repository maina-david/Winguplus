<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbCommentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('jb_comments', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('comment_code');
         $table->char('job')->nullable();
         $table->char('task')->nullable();
         $table->char('ticket')->nullable();
         $table->text('comment')->nullable();
         $table->integer('status')->nullable();
         $table->char('parent')->nullable();
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
      Schema::dropIfExists('jb_comments');
   }
}
