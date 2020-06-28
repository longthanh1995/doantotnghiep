<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('patient_id');
            $table->integer('relationship_id')->unsigned()->nullable();
            $table->integer('user_patient_id')->nullable();
            $table->tinyInteger('is_guardian')->unsigned()->nullable();
            $table->string('description', 255)->nullable();
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('gender', 20)->nullable();
            $table->datetime('date_of_birth')->nullable();
            $table->string('id_number', 30)->nullable();
            $table->integer('issue_country_id')->unsigned()->nullable();
            $table->char('profile_image_id', 26)->nullable();
            $table->integer('resident_country_id')->unsigned()->nullable();
            $table->string('address_zip', 64)->nullable();
            $table->string('address_block', 64)->nullable();
            $table->string('apartment_number', 64)->nullable();
            $table->longText('medical_condition')->nullable();
            $table->longText('drug_allergy')->nullable();
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
        Schema::dropIfExists('user_relatives');
    }
}
