<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Telefone extends Model
{
    use HasFactory; // Importação correta da trait

    /**
     * Os campos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'nome',
        'departamento',
        'funcao',
        'telefone',
        'email',
    ];
}
