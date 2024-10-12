<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table = 'post_images';

    public $timestamps = false;

    public function posts(){
        return $this->belongsTo(Post::class);
    }
}
