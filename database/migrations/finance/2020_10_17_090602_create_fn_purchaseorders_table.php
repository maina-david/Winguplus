<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnPurchaseordersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fn_purchaseorders', function (Blueprint $table) {
			$table->id();
         $table->char('po_code');
			$table->char('supplier_code');
         $table->char('business_code');
         $table->char('lpo_prefix')->nullable();
			$table->char('lpo_number')->nullable();
			$table->char('reference_number')->nullable();
			$table->char('title')->nullable();
			$table->date('lpo_date')->nullable();
			$table->date('lpo_due')->nullable();
			$table->char('customer_note')->nullable();
			$table->char('terms')->nullable();
			$table->integer('status')->nullable();
			$table->char('expense_code')->nullable();
         $table->char('expense_category')->nullable();
			$table->char('sub_total')->nullable();
			$table->char('discount')->nullable();
			$table->char('total')->nullable();
			$table->char('tax_value')->nullable();
         $table->char('type')->nullable();
         $table->integer('delivered_status')->nullable();
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
		Schema::dropIfExists('fn_purchaseorders');
	}
}
