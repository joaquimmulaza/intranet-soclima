<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relacionamento com o usuário que fez o pedido
            $table->string('tipo_documento');
            $table->text('finalidade')->nullable();
            $table->enum('forma_entrega', ['email', 'fisica', 'intranet']); // Correspondendo aos valores dos radio buttons
            $table->date('prazo_entrega')->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['pendente', 'em andamento', 'concluído'])->default('pendente');
            $table->string('documento_path')->nullable(); // Caminho para o documento, caso aplicável
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_requests');
    }
}
