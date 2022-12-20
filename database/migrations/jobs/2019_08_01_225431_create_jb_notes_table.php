<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jb_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('business_code');
            $table->char('note_code');
            $table->char('job');
            $table->char('title',255);
            $table->char('brief')->nullable();
            $table->text('content')->nullable();
            $table->text('label')->nullable();
            $table->char('status')->nullable();
            $table->char('created_by');
            $table->char('updated_by');
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
        Schema::dropIfExists('jb_notes');
    }
}
