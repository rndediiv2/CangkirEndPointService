<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrCoffeeProductPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrCoffeeProductPrice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coffee_product_id',36)->references('coffee_product_id')->on('TrCoffeeProduct');
            $table->string('coffee_price_name', 75);
            $table->decimal('coffee_price_value', 8, 2)->default(0);
            $table->decimal('coffee_price_offer', 8, 2)->default(0);
            $table->integer('coffee_price_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TrCoffeeProductPrice');
    }
}
