<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->char('iso', 2)->nullable();
            $table->char('iso3', 3)->nullable();
            $table->string('name', 80)->nullable();
            $table->string('nice_name', 80)->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('phone_country_code', 5)->nullable();
            $table->string('region', 10)->nullable();
            $table->string('sub_region', 100)->nullable();
            $table->char('currency_code', 3)->nullable();
            $table->integer('sub_currency_amount')->unsigned()->nullable();
            $table->tinyInteger('is_support_twilo_alp')->unsigned()->nullable();
            $table->integer('ordering')->unsigned()->nullable();
            $table->json('first_id_letters')->nullable();
            $table->tinyInteger('is_frequently_selected')->unsigned()->nullable();
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
        Schema::dropIfExists('countries');
    }
}
