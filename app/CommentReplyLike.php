<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReplyLike extends Model
{
    protected $table = 'comment_reply_likes';
    protected $fillable = ['user_id', 'comment_reply_id', 'like'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReply()
    {
        return $this->belongsTo(CommentReply::class);
    }
}