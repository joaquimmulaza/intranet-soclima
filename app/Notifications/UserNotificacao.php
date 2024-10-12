<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotificacao extends Notification
{
    use Queueable;

    private $usuario;

    public function __construct(User $user)
    {
        $this->usuario = $user;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('rafaelblumdigital@gmail.com')
                    ->cc('rafaelblumdigital@gmail.com')
                    ->greeting('Conta liberada com sucesso!')
                    ->subject('Liberacao de usuario')
                    ->line("Email de acesso: ". $this->usuario->email)
                    ->line("Senha de acesso: ". $this->usuario->password)
                    ->success()
                    ->action('Entre aqui', url('/'))
                    ->line('Obrigado por utilizacao CorporaTIX');
    }

    public function toDatabase(){
        return [
            'pedido' => $this->usuario->id,
            'solicitacao' => 'liberado'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
