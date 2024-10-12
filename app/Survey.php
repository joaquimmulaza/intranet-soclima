<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';

    protected $guarded = [];

    public function questionaire(){
        return $this->belongsTo(Questionaire::class);
    }

    public function responses(){
        return $this->hasMany(SurveyResponse::class);
    }
}
