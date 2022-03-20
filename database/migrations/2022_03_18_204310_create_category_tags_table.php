<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->timestamps();

            //index
            $table->index('category_id', 'category_tag_category_idx');
            $table->index('tag_id', 'category_tag_tag_idx');

            // foreign key
            $table->foreign('category_id', 'category_tag_category_fk')->on('categories')->references('id')->onDelete('cascade');
            $table->foreign('tag_id', 'category_tag_tag_fk')->on('tags')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_tags');
    }
}
