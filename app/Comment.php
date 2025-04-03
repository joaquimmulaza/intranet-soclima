<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(CommentLike::class);
    }

    public function replies(){
        return $this->hasMany(CommentReply::class);
    }

    public function isLikedBy(User $user){
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}