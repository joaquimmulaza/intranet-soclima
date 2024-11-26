<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotificationUsers extends Model
{
    use HasFactory;
    protected $table = 'notification_users'; // Especificando o nome da tabela

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'rota',
        'lida',
        'vista',
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


    public function getTempoDecorridoFormatadoAttribute()
    {
        $tempo = Carbon::parse($this->created_at);
        $diferenca = $tempo->diffInSeconds(now());

        if ($diferenca < 60) {
            return "{$diferenca} s"; // Segundos
        } elseif ($diferenca < 3600) {
            return floor($diferenca / 60) . " min"; // Minutos
        } elseif ($diferenca < 86400) {
            return floor($diferenca / 3600 ) . " h"; // Horas
        } else {
            return floor($diferenca / 86400) . " d"; // Dias
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relaciona com o usuário responsável pela notificação
    }

}
