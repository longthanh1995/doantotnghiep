<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('location')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('clinic_type_id')->unsigned()->nullable();
            $table->string('phone_country_code', 5)->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->string('profile_image_id', 255)->nullable();
            $table->string('time_zone', 30)->nullable();
            $table->integer('tax_profile_id')->unsigned()->nullable();
            $table->json('working_week_days')->nullable();
            $table->tinyInteger('enable_queue_feature')->unsigned()->nullable();
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
        Schema::dropIfExists('clinics');
    }
}
