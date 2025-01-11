<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescontarNasFeriasNullableToAusencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ausencias', function (Blueprint $table) {
            $table->boolean('descontar_nas_ferias')->nullable()->after('horas');
            // Agora o campo pode ser nulo
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
            $table->dropColumn('descontar_nas_ferias');
        });
    }
}
