<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorBookingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_booking_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('doctor_id');
            $table->integer('clinic_id');
            $table->char('fee_currency', 3)->nullable();
            $table->decimal('fee_amount', 13, 4)->nullable();
            $table->integer('appointment_type_id')->unsigned()->default(0);
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
        Schema::dropIfExists('doctor_booking_fees');
    }
}
