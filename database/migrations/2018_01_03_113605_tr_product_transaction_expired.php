<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrProductTransactionExpired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('TrProductTransaction', function (Blueprint $table) {
            $table->dateTime('transaction_expired')->after('transaction_progress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('TrProductTransaction', function (Blueprint $table) {
            //
        });
    }
}
