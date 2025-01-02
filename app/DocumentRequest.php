<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_documento',
        'finalidade',
        'forma_entrega',
        'prazo_entrega',
        'observacoes',
        'status',
        'documento_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}