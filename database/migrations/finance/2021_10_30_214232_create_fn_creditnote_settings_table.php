<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnCreditnoteSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_creditnote_settings', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('name')->nullable();
         $table->char('number')->nullable();
         $table->char('prefix')->nullable();
         $table->char('editing_of_sent')->nullable();
         $table->char('default_terms_conditions')->nullable();
         $table->char('default_customer_notes')->nullable();
         $table->char('default_footer')->nullable();
         $table->char('show_discount_lab')->nullable();
         $table->char('show_tax_tab')->nullable();
         $table->char('is_default')->default('No');
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
      Schema::dropIfExists('fn_creditnote_settings');
   }
}
