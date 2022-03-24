<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_cache', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->string('resolution', 50);
            $table->text('path');

            //index
            $table->index('file_id', 'file_image_cache_file_idx');

            // foreign key
            $table->foreign('file_id', 'file_image_cache_file_fk')->on('files')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('images_cache');
    }
}
