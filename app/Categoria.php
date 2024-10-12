<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
