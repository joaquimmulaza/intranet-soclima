<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeriaAprovadaOuReprovadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $funcionario;
    public $feria;
    public $status; // "aprovada" ou "reprovada"

    public function __construct($funcionario, $feria, $status)
    {
        $this->funcionario = $funcionario;
        $this->feria = $feria;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'aprovada!'
            ? 'Sua solicitação de férias foi reprovada!'
            : 'Sua solicitação de férias foi aprovada!';

        return $this
            ->subject($subject)
            ->to($this->funcionario->email) // E-mail do funcionário
            ->view('mail.aprovacao')
            ->with([
                'funcionario' => $this->funcionario,
                'feria' => $this->feria,
                'status' => $this->status,
            ]);
    }
}
