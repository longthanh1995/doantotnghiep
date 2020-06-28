<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_number', 11)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->char('profile_image_id', 26)->nullable();
            $table->string('phone_country_code', 5)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('address_street', 255)->nullable();
            $table->string('address_city', 255)->nullable();
            $table->string('address_zip', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('national_id_number', 20)->nullable();
            $table->tinyInteger('account_type')->unsigned()->default(1);
            $table->integer('account_id')->nullable();
            $table->string('password', 255)->nullable();
            $table->rememberToken();
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->tinyInteger('accepted_policy')->unsigned()->default(0);
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
        Schema::dropIfExists('users');
    }
}
