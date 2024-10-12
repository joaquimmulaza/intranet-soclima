<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    //protected $table = 'survey_Responses';
    protected $guarded = [];

    public function survey(){
        return $this->belongsTo(Survey::class);
    }
}
