<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->string('code', 32);
            $table->string('name', 64);
            $table->decimal('percent', 4, 2);
            $table->string('tax_type', 64)->default('GST');
            $table->tinyInteger('is_active')->unsigned()->default(1);
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
        Schema::dropIfExists('tax_profiles');
    }
}
