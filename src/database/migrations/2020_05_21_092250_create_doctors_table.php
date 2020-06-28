<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 100)->nullable();
            $table->string('name', 50)->nullable();
            $table->integer('doctor_title_id')->unsigned()->nullable();
            $table->char('profile_image_id', 26)->nullable();
            $table->integer('medical_school_id')->unsigned()->nullable();
            $table->string('phone_country_code', 5)->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->longText('office_hours')->nullable();
            $table->string('website', 255)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('gender', 255);
            $table->string('remember_token', 255)->nullable();
            $table->datetime('date_of_birth');
            $table->string('address', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('invited_by_doctor_id')->nullable();
            $table->tinyInteger('verification_status')->unsigned()->nullable();
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
        Schema::drop('doctors');
    }
}
