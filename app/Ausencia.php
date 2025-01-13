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
        'tipo_registo',
        'motivo',
        'data_inicio',
        'horas',
        'descontar_nas_ferias',
        'arquivo_comprovativo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
