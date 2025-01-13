<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDescontarNasFeriasColumnInAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() { DB::statement("ALTER TABLE ausencias MODIFY COLUMN descontar_nas_ferias VARCHAR(255) DEFAULT NULL"); }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() { DB::statement("ALTER TABLE ausencias MODIFY COLUMN descontar_nas_ferias BOOLEAN DEFAULT 0"); }
}
