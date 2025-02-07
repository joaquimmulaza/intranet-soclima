<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_feriados_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeriadosTable extends Migration
{
    public function up()
    {
        Schema::create('feriados', function (Blueprint $table) {
            $table->id();
            $table->date('data'); // Data do feriado
            $table->string('descricao'); // Descrição do feriado
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('feriados'); // Remove a tabela caso precise reverter
    }
}
