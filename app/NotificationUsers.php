<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUsers extends Model
{
    use HasFactory;
    protected $table = 'notification_users'; // Especificando o nome da tabela

    protected $fillable = [
        'tipo', 'titulo', 'descricao', 'rota', 'lida', 'user_id'
    ];

    protected $casts = [
        'data' => 'array', // Para acessar os dados da notificação como array
    ];

    // Método para marcar a notificação como lida
    public function markAsRead()
    {
        $this->lida = 1;
        $this->save();
    }
}
