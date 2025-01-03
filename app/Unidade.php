<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected  $guarded = ['id'];
    protected $table = 'unidades';

    public function user(){
        return $this->hasMany(User::class);
    }

    public function responsaveis() {
        return $this->belongsToMany(User::class, 'unidade_responsaveis', 'unidade_id', 'responsavel_id');
    }
}
