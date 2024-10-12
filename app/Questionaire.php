<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Questionaire extends Model
{
    protected $table = 'questionaires';

    public function path(){
        return url('/questionarios/' . $this->id);
    }

    public function publicPath(){
        return url('/surveys/' . $this->id . '-' . Str::slug($this->title));
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function surveys(){
        return $this->hasMany(Survey::class);
    }
}
