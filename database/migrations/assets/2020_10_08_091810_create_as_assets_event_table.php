<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsAssetsEventTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up(){
      Schema::create('as_assets_event', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('event_code');
         $table->char('asset_code');
         $table->integer('status')->nullable();
         $table->date('due_action_date')->nullable();
         $table->date('action_date');
         $table->char('check_out_to')->nullable();
         $table->char('branch')->nullable();
         $table->char('allocated_to')->nullable();
         $table->char('site_location')->nullable();
         $table->char('department')->nullable();
         $table->text('note')->nullable();
         $table->char('cost')->nullable();
         $table->char('employee')->nullable();
         $table->char('deductible')->nullable();
         $table->char('created_by');
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
      Schema::dropIfExists('as_assets_event');
   }
}
