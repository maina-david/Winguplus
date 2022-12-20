<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jb_tasks', function (Blueprint $table) {
			$table->increments('id');
         $table->char('business_code');
         $table->char('task_code');
			$table->char('job');
			$table->char('status')->nullable();
			$table->char('priority')->nullable();
			$table->char('type')->nullable();
			$table->char('label')->nullable();
			$table->char('group');
			$table->char('phase')->nullable();
			$table->char('version')->nullable();
			$table->char('title',255);
			$table->text('details')->nullable();
			$table->char('estimated_time', 10)->nullable();
			$table->date('due_date')->nullable();
			$table->date('close_date')->nullable();
			$table->char('start_date')->nullable();
			$table->char('progress',20)->nullable();
			$table->char('notify_client',100)->nullable();
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
		Schema::dropIfExists('jb_tasks');
	}
}
