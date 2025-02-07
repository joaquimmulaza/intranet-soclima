<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiasFerias extends Model
{
    protected $table = 'dias_ferias';

    protected $fillable = ['user_id', 'ano', 'dias_disponiveis'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
