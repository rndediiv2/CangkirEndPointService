<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone',14);
            $table->string('avatar', 175)->nullable();
            $table->boolean('has_coffee')->default(false);
            $table->string('coffee_id', 36)->default(0);
            $table->integer('sms_token')->default(0);
            $table->string('sms_expired')->nullable();
            $table->string('last_lat', 25)->nullable();
            $table->string('last_lang', 25)->nullable();
            $table->integer('activated')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
