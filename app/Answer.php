<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];
    protected $table = 'answers';

    public function question(){
        return $this->belongsTo(Question::class);
    }

    /*Retorna quantas pessoas escolheram cada resposta:
     * */
    public function responses(){
        return $this->hasMany(SurveyResponse::class);
    }
}
