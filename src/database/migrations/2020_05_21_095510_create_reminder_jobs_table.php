<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReminderJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminder_jobs', function (Blueprint $table) {
            $table->string('id', 26)->primary();
            $table->integer('appointment_id');
            $table->integer('schedule_for');
            $table->string('status', 10)->default('pending');
            $table->softDeletes();
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
        Schema::drop('reminder_jobs');
    }
}
