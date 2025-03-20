<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'ativo', 'arquivo_imagem', 'arquivo_pdf', 'user_id'];
    // Permite que views_count seja tratado como um atributo dinâmico
    protected $appends = ['views_count'];
    public function getViewsCountAttribute()
    {
        return \DB::table('post_views')
            ->where('post_id', $this->id)
            ->count();
    }
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
