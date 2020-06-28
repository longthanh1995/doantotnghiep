<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorTimetableConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_timetable_configs', function (Blueprint $table) {
            $table->integer('doctor_id')->unsigned();
            $table->integer('appointment_type_id');
            $table->primary(['doctor_id', 'appointment_type_id']);
            $table->integer('duration')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_timetable_configs');
    }
}
