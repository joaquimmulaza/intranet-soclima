<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndObservacaoToAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ausencias', function (Blueprint $table) {
            $table->enum('status', ['Pendente', 'Aprovado', 'Rejeitado'])->default('Pendente'); // Status
            $table->text('observacao')->nullable(); // Observação
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
            $table->dropColumn('status');
            $table->dropColumn('observacao');
        });
    }
}
