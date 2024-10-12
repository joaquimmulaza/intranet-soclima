<?php

namespace App\Mail;

use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;

class notificationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function build()
    {

        return $this
        ->subject('Conta de emal criada!!')
        ->replyTo('marketing@soclima.com')
        ->to('rafaelblum_digital@hotmail.com', 'teste')
        ->view('mail.notificationMail');

    }
}
