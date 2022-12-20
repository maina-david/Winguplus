<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsAssetsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('as_assets', function (Blueprint $table) {
         $table->id();
         $table->char('business_code',255);
         $table->char('asset_code',255);
         $table->char('asset_name',255);
         $table->char('status')->nullable();
         $table->char('category',255)->nullable();
         $table->char('asset_type')->nullable();
         $table->char('asset_image',255)->nullable();
         $table->text('asset_tag',255)->nullable();
         $table->char('serial',255)->nullable();
         $table->char('manufacture',255)->nullable();
         $table->char('brand')->nullable();
         $table->char('supplier')->nullable();
         $table->char('asset_model',255)->nullable();
         $table->char('assigned_to')->nullable();
         $table->char('order_number',100)->nullable();
         $table->char('purches_cost',50)->nullable();
         $table->date('purchase_date')->nullable();
         $table->date('next_inspection_date')->nullable();
         $table->date('insurance_expiry_date')->nullable();
         $table->char('warranty',255)->nullable();
         $table->date('warranty_expiration')->nullable();
         $table->char('default_location',255)->nullable();
         $table->char('latitude',255)->nullable();
         $table->char('longitude',255)->nullable();
         $table->char('requestable',255)->nullable();
         $table->text('note')->nullable();
         $table->char('has_inurance_cover',50)->nullable();
         $table->date('last_audit')->nullable();
         $table->date('end_of_life')->nullable();
         $table->char('depreciable_assets')->nullable();
         $table->char('asset_color')->nullable();
         $table->char('link_to_expence')->nullable();
         $table->char('mileage')->nullable();
         $table->char('asset_condition')->nullable();
         $table->char('oil_change')->nullable();
         $table->char('licence_plate')->nullable();
         $table->char('vehicle_type')->nullable();
         $table->char('vehicle_make')->nullable();
         $table->char('vehicle_year_of_manufacture')->nullable();
         $table->char('vehicle_model')->nullable();
         $table->char('vehicle_color')->nullable();
         $table->char('department')->nullable();
         $table->char('employee')->nullable();
         $table->char('customer')->nullable();
         $table->char('company_branch')->nullable();
         $table->char('product_key')->nullable();
         $table->char('maintained')->nullable();
         $table->date('next_maintenance')->nullable();
         $table->char('seats')->nullable();
         $table->char('licensed_to_name')->nullable();
         $table->char('licensed_to_email')->nullable();
         $table->char('reassignable')->nullable();
         $table->integer('current_status')->nullable();
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
      Schema::dropIfExists('as_assets');
   }
}
