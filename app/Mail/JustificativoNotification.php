<?php

namespace App\Mail;

use App\Ausencia;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JustificativoNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ausencia;
    public $user;
    public $admin;
    public $mensagem;
    public $tipo;

    public function __construct(Ausencia $ausencia, User $user, User $admin = null, $mensagem, $tipo)
    {
        $this->ausencia = $ausencia;
        $this->user = $user;
        $this->admin = $admin;
        $this->mensagem = $mensagem;
        $this->tipo = $tipo; // 'novo' para novo justificativo, 'aprovacao' para aprovação/rejeição
    }

    public function build()
    {
        $subject = $this->tipo === 'novo' ? 'Novo Justificativo Enviado' : 'Atualização do Justificativo';

        // Configura o destinatário
        $to = $this->tipo === 'novo' ? $this->admin->email : $this->user->email;

        // Monta o e-mail
        return $this->to($to)
                    ->subject($subject)
                    ->view('mail.justificativo')
                    ->with([
                        'ausencia' => $this->ausencia,
                        'user' => $this->user,
                        'mensagem' => $this->mensagem,
                        'tipo' => $this->tipo,
                        'downloadUrl' => $this->ausencia->arquivo_comprovativo ? route('downloadFile', ['id' => $this->ausencia->id]) : null,
                    ]);
    }
}