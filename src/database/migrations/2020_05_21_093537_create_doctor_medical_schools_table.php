<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorMedicalSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_medical_schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('medical_school_id')->unsigned()->nullable();
            $table->datetime('date_of_graduation')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('doctor_id')->unsigned()->nullable();
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
        Schema::drop('doctor_medical_schools');
    }
}
