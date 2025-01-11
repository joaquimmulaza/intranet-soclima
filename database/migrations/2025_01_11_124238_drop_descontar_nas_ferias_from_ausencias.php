<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDescontarNasFeriasFromAusencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ausencias', function (Blueprint $table) {
            $table->dropColumn('descontar_nas_ferias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ausencias', function (Blueprint $table) {
            $table->tinyInteger('descontar_nas_ferias')->after('horas');
        });
    }
}
