<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // Ex.: 'aniversariante', 'pedido_ferias'
            $table->string('titulo'); // Título da notificação
            $table->text('descricao'); // Descrição da notificação
            $table->string('rota')->nullable(); // Link para redirecionamento
            $table->boolean('lida')->default(false); // Status de leitura
            $table->unsignedBigInteger('user_id')->nullable(); // Relacionada ao usuário, se aplicável
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_users');
    }
}
