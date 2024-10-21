<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataRetornoPrevistaToFeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ferias', function (Blueprint $table) {
            $table->date('data_retorno_prevista')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ferias', function (Blueprint $table) {
            $table->dropColumn('data_retorno_prevista');
        });
    }
}
