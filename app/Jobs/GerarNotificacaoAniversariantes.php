<?php

namespace App\Jobs;
use App\Http\Controllers\NotificationController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GerarNotificacaoAniversariantes
{
    public function handle()
    {
        $usuariosAniversariantes = User::whereDay('data_nascimento', now()->day)
            ->whereMonth('data_nascimento', now()->month)
            ->get();

        if ($usuariosAniversariantes->isEmpty()) {
            return; // Não há aniversariantes hoje
        }

        $descricao = $this->gerarDescricaoAniversariantes($usuariosAniversariantes);

        // Para cada usuário que deve receber a notificação
        $usuariosParaNotificar = User::all(); // Ou outro critério para escolher os destinatários

        foreach ($usuariosParaNotificar as $usuario) {
            NotificationUsers::create([
                'user_id' => $usuario->id,
                'titulo' => 'Aniversariantes do dia',
                'descricao' => $descricao,
                'rota' => '#',
                'lida' => false,
                'vista' => false,
            ]);
        }
    }

    private function gerarDescricaoAniversariantes($usuariosAniversariantes)
    {
        $nomes = $usuariosAniversariantes->pluck('nome')->toArray();
        $primeiroNome = array_shift($nomes);

        if (count($nomes) > 0) {
            return "$primeiroNome e mais " . count($nomes) . " pessoas fazem anos hoje.";
        }

        return "$primeiroNome faz anos hoje.";
    }
}
