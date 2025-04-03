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
        'observacoes_admin',
        'status',
        'documento_path',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // Relação com o administrador que enviou o documento
     public function admin()
     {
         return $this->belongsTo(User::class, 'admin_id');
     }
}