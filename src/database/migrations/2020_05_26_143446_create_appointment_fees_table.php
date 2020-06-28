<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_fees', function (Blueprint $table) {
            $table->integer('appointment_id')->primary();
            $table->decimal('booking_fee', 13, 4)->default(0.0000);
            $table->decimal('tax_amount', 13, 4)->nullable();
            $table->string('currency_code', 255)->nullable();
            $table->decimal('discount_amount', 13, 4)->nullable();
            $table->char('fee_currency', 3)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('fail_message', 256)->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('tax_name', 255)->nullable();
            $table->decimal('tax_percent', 5, 2)->default(0.00);
            $table->string('tax_code', 32)->nullable();
            $table->string('tax_type', 64)->default('GST');
            $table->tinyInteger('has_tax')->unsigned()->default(0);
            $table->decimal('surcharge', 13, 4)->default(0.0000);
            $table->decimal('total', 13, 4)->default(0.0000);
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
        Schema::dropIfExists('appointment_fees');
    }
}
