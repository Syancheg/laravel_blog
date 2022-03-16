<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->timestamps();

            //index
            $table->index('banner_id', 'banner_post_banner_idx');
            $table->index('post_id', 'banner_post_post_idx');

            // foreign key
            $table->foreign('banner_id', 'banner_post_banner_fk')->on('banners')->references('id');
            $table->foreign('post_id', 'banner_post_post_fk')->on('posts')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_posts');
    }
}
