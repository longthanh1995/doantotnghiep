<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('rescheduled_user_id')->nullable();
            $table->integer('rescheduled_from_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('doctor_timetable_id')->nullable();
            $table->integer('appointment_status_id')->unsigned()->nullable();
            $table->integer('appointment_type_id')->unsigned()->nullable();
            $table->integer('patient_condition_id')->unsigned()->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->mediumText('cancel_reason')->nullable();
            $table->string('booking_reason', 800)->nullable();
            $table->integer('user_patient_id')->nullable();
            $table->char('book_source', 1);
            $table->integer('verify_attempted')->unsigned()->default(0);
            $table->longText('note')->nullable();
            $table->tinyInteger('is_finished_summary')->unsigned()->default(0);
            $table->integer('reason_id')->nullable();
            $table->text('extra_note')->nullable();
            $table->tinyInteger('has_patient_arrived')->unsigned()->default(0);
            $table->integer('referred_doctor_id')->nullable();
            $table->integer('referred_clinic_id')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
