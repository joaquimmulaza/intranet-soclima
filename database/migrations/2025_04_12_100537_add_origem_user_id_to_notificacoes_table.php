<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrigemUserIdToNotificacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_users', function (Blueprint $table) {
            $table->unsignedBigInteger('origem_user_id')->nullable()->after('user_id');

            // Adiciona a chave estrangeira (opcional, mas recomendado)
            $table->foreign('origem_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_users', function (Blueprint $table) {
            $table->dropForeign(['origem_user_id']);
            $table->dropColumn('origem_user_id');
        });
    }
}
