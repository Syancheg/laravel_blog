<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageGallaryFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_gallary_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_gallary_id')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();

            //index
            $table->index('image_gallary_id', 'image_gallary_file_image_gallary_idx');
            $table->index('file_id', 'image_gallary_file_file_idx');

            // foreign key
            $table->foreign('image_gallary_id', 'image_gallary_file_image_gallary_fk')->on('image_gallary')->references('id')->onDelete('cascade');
            $table->foreign('file_id', 'image_gallary_file_file_fk')->on('files')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('image_gallary_file');
    }
}
