<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrCoffeeShopReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrCoffeeShopReview', function (Blueprint $table) {
            $table->string('review_id', 20);
            $table->string('review_coffee_id', 36)->references('coffee_id')->on('TmCoffeeShop');
            $table->string('review_coffee_name', 100);
            $table->integer('review_user_id')->references('id')->on('users');
            $table->string('review_name', 255);
            $table->string('review_avatar', 175)->nullable();
            $table->text('review_remarks');
            $table->integer('review_rate')->default(0);
            $table->dateTime('review_at');
            $table->primary('review_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('TrCoffeeShopReview', function (Blueprint $table) {
            //
        });
    }
}
