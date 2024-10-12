<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CorreioMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $user;

    public function __construct($details, User $user)
    {
        $this->details = $details;
        $this->user = $user;
    }

    public function build()
    {
        if($this->details['pedido'] != 'bloqueado'){
            $this->user->status = 'ativo';
            $pass = $this->user->remember_token;
            $this->user->remember_token = null;

            $this->user->save();
            return $this
                ->subject($this->details['title'])
                ->replyTo('marketing@soclima.com')
                ->to($this->user->email, $this->user->name)
                ->view('mail.confirmaMail', ['user'=> $this->user, 'admin'=> $this->details, 'senha'=> $pass]);


        }else{
            $this->user->status = 'bloqueado';

            $this->user->save();
            return $this
                ->subject($this->details['title'])
                ->replyTo('marketing@soclima.com')
                ->to($this->user->email, $this->user->name)
                ->view('mail.bloqueiaMail', ['user'=> $this->user, 'admin'=> $this->details]);
        }

    }
}
