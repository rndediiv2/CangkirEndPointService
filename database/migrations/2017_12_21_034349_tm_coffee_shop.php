<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TmCoffeeShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TmCoffeeShop', function (Blueprint $table) {
            $table->uuid('coffee_id')->unique();
            $table->string('coffee_name', 100);
            $table->string('coffee_address', 175);
            $table->string('coffee_phone', 30)->nullable();
            $table->string('coffee_mail', 35)->nullable();
            $table->time('coffee_start_at')->nullable();
            $table->time('coffee_stop_at')->nullable();
            $table->string('coffee_facilites', 255)->nullable();
            $table->string('coffee_tagsline', 100)->nullable();
            $table->string('coffee_avatar', 150)->nullable();
            $table->string('coffee_banner', 175)->nullable();
            $table->string('coffee_lat', 30)->nullable();
            $table->string('coffee_lang', 30)->nullable();
            $table->boolean('coffee_status')->default(true);
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
        Schema::dropIfExists('TmCoffeeShop');
    }
}
