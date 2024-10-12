<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected  $guarded = ['id'];
    protected $table = 'cargos';

    public function user(){
        return $this->hasMany(User::class);
    }
}
