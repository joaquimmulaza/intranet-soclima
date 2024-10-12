<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = [
        'nome',
        'departamento',
        'funcao',
        'telefone',
        'email',
    ];
}
