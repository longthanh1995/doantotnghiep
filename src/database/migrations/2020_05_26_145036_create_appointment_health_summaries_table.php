<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentHealthSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_health_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('original_id')->nullable();
            $table->integer('appointment_id')->default(0);
            $table->longText('summary')->nullable();
            $table->longText('note')->nullable();
            $table->longText('plan')->nullable();
            $table->longText('visit_doctor_if')->nullable();
            $table->string('title', 255)->nullable();
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
        Schema::dropIfExists('appointment_health_summaries');
    }
}
