<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrProductFeedBack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrProductFeedBack', function (Blueprint $table) {
            $table->string('feedback_id', 20);
            $table->string('feedback_coffee_id', 36)->references('coffee_id')->on('TmCoffeeShop');
            $table->string('feedback_coffee_name', 100);
            $table->string('feedback_product_id', 36)->references('coffee_product_id')->on('TrCoffeeProduct');
            $table->string('feedback_product_name', 150);
            $table->integer('feedback_user_id')->references('id')->on('users');
            $table->string('feedback_name', 255);
            $table->string('feedback_avatar', 175)->nullable();
            $table->text('feedback_remarks');
            $table->integer('feedback_rate')->default(0);
            $table->dateTime('feedback_at');
            $table->primary('feedback_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TrProductFeedBack');
    }
}
