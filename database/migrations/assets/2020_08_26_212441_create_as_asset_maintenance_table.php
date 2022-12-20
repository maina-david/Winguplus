<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsAssetMaintenanceTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('as_asset_maintenance', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('maintenance_code');
         $table->char('asset_code');
         $table->char('supplier')->nullable();
         $table->char('maintenance_type')->nullable();
         $table->char('title',255)->nullable();
         $table->datetime('start_date')->nullable();
         $table->datetime('completion_date')->nullable();
         $table->char('warranty_improvement',10)->nullable();
         $table->char('cost',20)->nullable();
         $table->text('note')->nullable();
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
      Schema::dropIfExists('asset_maintenance');
   }
}
