<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnoToDiasFeriasTable extends Migration
{
    public function up()
    {
        Schema::table('dias_ferias', function (Blueprint $table) {
            $table->year('ano')->after('user_id'); // Adiciona o campo 'ano' logo após o 'user_id'
        });
    }

    public function down()
    {
        Schema::table('dias_ferias', function (Blueprint $table) {
            $table->dropColumn('ano'); // Remove o campo 'ano' caso precise reverter a migration
        });
    }
}