<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    protected $table = 'questions';

    public function questionaire(){
        return $this->belongsTo(Questionaire::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    /*Quantas respostas uma determinada pergunta tem:
    * */
    public function responses(){
        return $this->hasMany(SurveyResponse::class);
    }
}
