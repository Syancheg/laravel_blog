<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_dogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('children_id');
            $table->timestamps();

            //index
            $table->index('parent_id', 'parent_dog_children_dog_parend_dog_idx');
            $table->index('children_id', 'parent_dog_children_dog_children_dog_idx');

            // foreign key
            $table->foreign('parent_id', 'parent_dog_children_dog_parend_dog_fk')->on('dogs')->references('id')->onDelete('cascade');
            $table->foreign('children_id', 'parent_dog_children_dog_children_dog_fk')->on('dogs')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_dogs');
    }
}
