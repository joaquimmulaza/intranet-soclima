<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $table = 'posts';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categorias(){
        return $this->belongsToMany(Categoria::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function images(){
        return $this->hasMany(PostImage::class);
    }
}
