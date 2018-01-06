<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrCoffeeProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrCoffeeProduct', function (Blueprint $table) {
            $table->uuid('coffee_product_id')->unique();
            $table->string('coffee_shop_owner', 36)->references('coffee_id')->on('TmCoffeeShop');
            $table->integer('coffee_category_id')->references('category_id')->on('TrProductCategory');
            $table->string('coffee_product_title', 150);
            $table->string('coffee_product_body', 500)->nullable();
            $table->string('coffee_product_thumbs', 175)->nullable();
            $table->decimal('coffee_product_disc', 8, 2)->default(0);
            $table->integer('coffee_product_active')->default(1);
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
        Schema::dropIfExists('TrCoffeeProduct');
    }
}
