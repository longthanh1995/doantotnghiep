<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uri', 255)->nullable();
            $table->string('media_type', 45)->nullable();
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('size')->unsigned()->nullable();
            $table->string('extension', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('thumbnail_url', 255)->nullable();
            $table->string('container', 50)->default('images');
            $table->integer('creator_id')->default(0);
            $table->string('original_uri', 255);
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
        Schema::dropIfExists('images');
    }
}
