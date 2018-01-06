<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrReviewCommentShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrReviewCommentShop', function (Blueprint $table) {
            $table->string('comment_id', 20);
            $table->string('comment_review_id', 20)->references('review_id')->on('TrCoffeeShopReview');
            $table->integer('comment_user_id')->references('id')->on('users');
            $table->string('comment_name', 255);
            $table->string('comment_avatar', 175)->nullable();
            $table->text('comment_remarks');
            $table->dateTime('commment_at');
            $table->primary('comment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TrReviewCommentShop');
    }
}
