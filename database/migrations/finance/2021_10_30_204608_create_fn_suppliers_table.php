<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnSuppliersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_suppliers', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('supplier_code');
         $table->char('title')->nullable();
         $table->char('contract_type')->nullable();
         $table->text('category')->nullable();
         $table->char('reference_number')->nullable();
         $table->char('supplier_name')->nullable();
         $table->char('salutation')->nullable();
         $table->char('position')->nullable();
         $table->char('solution')->nullable();
         $table->char('email')->nullable();
         $table->char('email_verified_at')->nullable();
         $table->char('remeber_token')->nullable();
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
         $table->char('skypid')->nullable();
         $table->char('image')->nullable();
         $table->char('remarks')->nullable();
         $table->char('referral')->nullable();
         $table->char('status')->nullable();
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
      Schema::dropIfExists('fn_suppliers');
   }
}
