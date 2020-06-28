<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_timetables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->string('type', 255)->nullable();
            $table->tinyInteger('available')->unsigned()->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->tinyInteger('is_booked')->unsigned()->default(0);
            $table->integer('appointment_type_id')->unsigned()->nullable();
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
        Schema::dropIfExists('doctor_timetables');
    }
}
