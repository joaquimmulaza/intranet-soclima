<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_falta',
        'motivo',
        'arquivo_comprovativo',
        'data_inicio',
        'data_fim',
    ];

    /**
     * Relacionamento com o usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

