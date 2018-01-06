<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrProductCategory', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('category_title', 150);
            $table->string('category_desc', 255)->nullable();
            $table->string('category_thumbs', 255)->nullable();
            $table->boolean('category_status')->default(true);
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
        Schema::dropIfExists('TrProductCategory');
    }
}
