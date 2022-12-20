<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnCustomersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_customers', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('customer_code')->nullable();
         $table->char('title')->nullable();
         $table->char('contact_type')->nullable();
         $table->char('category')->nullable();
         $table->char('customer_name')->nullable();
         $table->char('salutation')->nullable();
         $table->char('email')->nullable();
         $table->char('email_verified_at')->nullable();
         $table->char('remember_token')->nullable();
         $table->char('password')->nullable();
         $table->char('gender')->nullable();
         $table->char('ip')->nullable();
         $table->char('email_cc')->nullable();
         $table->char('other_phone_number')->nullable();
         $table->char('primary_phone_number')->nullable();
         $table->char('designation')->nullable();
         $table->char('department')->nullable();
         $table->char('website')->nullable();
         $table->char('currency')->nullable();
         $table->char('payment_terms')->nullable();
         $table->char('portal')->nullable();
         $table->char('facebook')->nullable();
         $table->char('twitter')->nullable();
         $table->char('linkedin')->nullable();
         $table->char('skypeID')->nullable();
         $table->char('image')->nullable();
         $table->text('remarks')->nullable();
         $table->char('referral')->nullable();
         $table->char('tax_pin')->nullable();
         $table->char('indentification_type')->nullable();
         $table->char('indentification_number')->nullable();
         $table->date('dob')->nullable();
         $table->integer('status')->nullable();
         $table->text('industry')->nullable();
         $table->char('assigned')->nullable();
         $table->char('source')->nullable();
         $table->text('group')->nullable();
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
      Schema::dropIfExists('fn_customers');
   }
}
