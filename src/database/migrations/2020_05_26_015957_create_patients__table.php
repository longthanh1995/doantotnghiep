<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->string('phone_country_code', 5)->nullable();
            $table->string('address_street', 255)->nullable();
            $table->string('address_city', 255)->nullable();
            $table->string('address_zip', 255)->nullable();
            $table->integer('issue_country_id')->unsigned();
            $table->char('profile_image_id', 26)->nullable();
            $table->tinyInteger('is_locked')->unsigned()->nullable();
            $table->string('address', 255)->nullable();
            $table->string('medical_record_number', 20)->nullable();
            $table->string('race', 20)->nullable();
            $table->date('date_of_arrival')->nullable();
            $table->string('contact_number', 100)->nullable();
            $table->string('pass_port_number', 20)->nullable();
            $table->string('country_free_text', 20)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('guardian_patient_id')->nullable();
            $table->integer('created_by');
            $table->string('alias', 75)->nullable();
            $table->integer('resident_country_id')->unsigned()->nullable();
            $table->string('id_number', 30)->nullable();
            $table->tinyInteger('deceased')->default(0);
            $table->tinyInteger('verified')->default(0);
            $table->string('imported_phone', 20)->nullable();
            $table->string('imported_name', 100)->nullable();
            $table->string('imported_email', 100)->nullable();
            $table->tinyInteger('is_imported_record')->unsigned()->default(0);
            $table->longText('medical_condition')->nullable();
            $table->longText('drug_allergy')->nullable();
            $table->string('stripe_customer_id', 50)->nullable();
            $table->tinyInteger('has_already_appointment')->default(0);
            $table->string('address_block', 64)->nullable();
            $table->string('apartment_number', 64)->nullable();
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
        Schema::dropIfExists('patients');
    }
}
