<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('secret_key', 255)->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('table_type')->unsigned()->nullable();
            $table->char('otp_token', 64)->nullable();
            $table->integer('otp_token_used')->unsigned()->default(0);
            $table->char('call_token', 32)->nullable();
            $table->integer('send_attempts')->unsigned()->default(0);
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
        Schema::drop('otp_passwords');
    }
}
