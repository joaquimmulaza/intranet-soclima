<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentoEnviado extends Mailable
{
    use Queueable, SerializesModels;

    public $documentRequest;

    public function __construct($documentRequest)
    {
        $this->documentRequest = $documentRequest;
    }

    public function build()
    {
        return $this->subject($this->documentRequest->tipo_documento)
                    ->view('mail.documento_enviado')
                    ->with([
                        'nomeUsuario' => $this->documentRequest->user->name,
                        'tipoDocumento' => $this->documentRequest->tipo_documento,
                        'linkDownload' => url('/storage/' . $this->documentRequest->documento_path),
                    ]);
    }
}
