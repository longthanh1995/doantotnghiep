<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->nullabe();
            $table->string('issuer', 100)->nullable();
            $table->datetime('issued_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('doctor_id')->nullable();
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
        Schema::drop('doctor_qualifications');
    }
}
