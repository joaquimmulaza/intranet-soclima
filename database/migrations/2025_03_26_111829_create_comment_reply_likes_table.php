<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentReplyLikesTable extends Migration
{
    public function up()
    {
        Schema::create('comment_reply_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_reply_id')->constrained()->onDelete('cascade');
            $table->boolean('like')->default(true); // Opcional, se quiser manter flexibilidade
            $table->timestamps();

            // Índice único para evitar curtidas duplicadas do mesmo usuário
            $table->unique(['user_id', 'comment_reply_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comment_reply_likes');
    }
}