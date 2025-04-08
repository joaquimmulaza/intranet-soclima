<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilidadeToFeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ferias', function (Blueprint $table) {
            $table->boolean('visivel_para_user')->default(true);
            $table->boolean('visivel_para_responsavel')->default(true);
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
            $table->dropColumn(['visivel_para_user', 'visivel_para_responsavel']);
        });
    }
}
