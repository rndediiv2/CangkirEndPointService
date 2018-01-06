<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrProductTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrProductTransactionDetails', function (Blueprint $table) {
            $table->string('details_id', 20)->references('transaction_id')->on('TrProductTransaction');
            $table->integer('details_serial')->default(0);
            $table->string('details_product_id', 36)->references('coffee_product_id')->on('TrCoffeeProduct');
            $table->string('details_product_title', 150);
            $table->string('details_product_type', 75);
            $table->integer('details_product_qty')->default(0);
            $table->decimal('details_product_price', 8, 2)->default(0);
            $table->decimal('details_product_disc', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TrProductTransactionDetails');
    }
}
