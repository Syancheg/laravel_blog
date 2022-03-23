<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->date('date_receiving')->nullable();
            $table->unsignedBigInteger('dog_id');

            //index
            $table->index('dog_id', 'dog_achievements_dog_idx');

            // foreign key
            $table->foreign('dog_id', 'dog_achievements_dog_fk')->on('dogs')->references('id');

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
        Schema::dropIfExists('dogs_achievements');
    }
}
