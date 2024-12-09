<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeriaSolicitadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $funcionario;
    public $feria;

    public function __construct($funcionario, $feria)
    {
        $this->funcionario = $funcionario; // Dados do funcionário que solicitou as férias
        $this->feria = $feria;             // Informações das férias
    }

    public function build()
    {
        return $this
            ->subject("Solicitação de férias - {$this->funcionario->name}")
            ->to($this->feria->responsavel->email) // E-mail do responsável
            ->view('mail.solicitacao')
            ->with([
                'funcionario' => $this->funcionario,
                'feria' => $this->feria,
            ]);
    }
}
