<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmMarketingPostTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_marketing_post', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('business_code');
         $table->char('post_code');
         $table->char('account_code')->nullable();
         $table->char('channel_code')->nullable();
         $table->text('post')->nullable();
         $table->text('title')->nullable();
         $table->text('link')->nullable();
         $table->text('link_description')->nullable();
         $table->char('media')->nullable();
         $table->char('status')->nullable();
         $table->char('upload_time')->nullable();
         $table->integer('post_count')->nullable();
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
      Schema::dropIfExists('crm_marketing_post');
   }
}
