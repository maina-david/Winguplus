<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnProductInventoryTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_product_inventory', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('branch_code')->nullable();
         $table->char('inventory_code');
         $table->char('product_code');
         $table->integer('current_stock')->default(0);
         $table->char('reorder_point')->nullable();
         $table->char('reorder_qty')->nullable();
         $table->date('expiration_date')->nullable();
         $table->char('default_inventory')->nullable();
         $table->char('notification')->nullable();
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
      Schema::dropIfExists('fn_product_inventory');
   }
}
