<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected  $guarded = ['id'];

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    public function unidade(){
        return $this->belongsTo(Unidade::class);
    }

    public function questionaires(){
        return $this->belongsTo(Questionaire::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('slug', $permission)->first() ? true : false;
    }

    public function routeNotificationForMail($notification){
        return $this->email;
    }

    public function responsavel(){
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    // No modelo User
    public function diasFerias()
    {
        return $this->hasOne(DiasFerias::class, 'user_id');
    }

    // Relacionamento com os documentos
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    public function ausencias()
    {
        return $this->hasMany(Ausencia::class);
    }

}
