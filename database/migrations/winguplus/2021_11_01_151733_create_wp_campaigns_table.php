<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpCampaignsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_campaigns', function (Blueprint $table) {
         $table->id();
         $table->char('title')->nullable();
         $table->char('campaign')->nullable();
         $table->char('mail_from')->nullable();
         $table->text('template')->nullable();
         $table->char('status')->nullable();
         $table->char('total_sent')->nullable();
         $table->char('receipients')->nullable();
         $table->char('received')->nullable();
         $table->text('email_list')->nullable();
         $table->char('views')->nullable();
         $table->char('tracking_code')->nullable();
         $table->dateTime('sent_date')->nullable();
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
      Schema::dropIfExists('wp_campaigns');
   }
}
