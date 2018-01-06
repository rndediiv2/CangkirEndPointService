<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrProductTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrProductTransaction', function (Blueprint $table) {
            $table->string('transaction_id', 20)->unique();
            $table->integer('transaction_user_id')->references('id')->on('users');
            $table->string('transaction_name', 175);
            $table->string('transaction_phone', 14);
            $table->string('transaction_mail');
            $table->string('transaction_coffee_id', 36)->references('coffee_id')->on('TmCoffeeShop');
            $table->string('transaction_coffee_name', 100);
            $table->dateTime('transaction_arrived')->nullable();
            $table->integer('transaction_method')->default(0);
            $table->string('transaction_references')->nullable();
            $table->decimal('transaction_tips', 8, 2)->default(0);
            $table->decimal('transaction_bills', 8, 2)->default(0);
            $table->string('transaction_notes', 255)->nullable();
            $table->integer('transaction_rate')->default(0);
            $table->string('transaction_remarks', 500)->nullable();
            $table->integer('transaction_progress')->default(0);
            $table->primary('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TrProductTransaction');
    }
}
