<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTipoFaltaColumnInAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rodar a alteração diretamente no SQL
        DB::statement('ALTER TABLE ausencias MODIFY COLUMN tipo_falta VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverter a alteração, voltando para o tipo enum
        DB::statement('ALTER TABLE ausencias MODIFY COLUMN tipo_falta ENUM("Justificada", "Injustificada", "Desejo ausentar-se")');
    }
}
