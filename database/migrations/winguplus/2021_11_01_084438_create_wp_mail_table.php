<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpMailTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('wp_mail', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('mail_code');
         $table->text('message')->nullable();
         $table->char('names')->nullable();
         $table->char('customer_code')->nullable();
         $table->char('supplier')->nullable();
         $table->char('lead_code')->nullable();
         $table->char('invoice_code')->nullable();
         $table->char('purchase_order_code')->nullable();
         $table->char('subject')->nullable();
         $table->char('mail_from')->nullable();
         $table->char('mail_to')->nullable();
         $table->char('cc')->nullable();
         $table->char('attachment')->nullable();
         $table->char('category')->nullable();
         $table->char('folder')->nullable();
         $table->integer('status')->nullable();
         $table->char('ip')->nullable();
         $table->char('view_status')->nullable();
         $table->char('date_view')->nullable();
         $table->char('view_count')->nullable();
         $table->char('type')->nullable();
         $table->char('section')->nullable();
         $table->char('module')->nullable();
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
      Schema::dropIfExists('wp_mail');
   }
}
