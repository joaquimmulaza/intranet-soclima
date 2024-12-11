<?php

namespace App\Jobs;
use App\Http\Controllers\NotificationController;
use App\NotificationUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\User;

class GerarNotificacaoAniversariantes
{
    public function handle()
    {
        $usuariosAniversariantes = User::whereDay('nascimento', now()->day)
            ->whereMonth('nascimento', now()->month)
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
        $nomes = $usuariosAniversariantes->pluck('name')->toArray();

        if (count($nomes) > 1) {
            $primeirosNomes = array_slice($nomes, 0, 2); // Pega os dois primeiros nomes para exibir
            $outros = count($nomes) - 2;

            if ($outros > 0) {
                return '<strong>' . implode('</strong>, <strong>', $primeirosNomes) . "</strong> e mais $outros pessoa(s) fazem anos hoje.";
            }
    
            return '<strong>' . implode('</strong> e <strong>', $primeirosNomes) . "</strong> fazem anos hoje.";
        }

        // Caso haja apenas um aniversariante
        return "<strong>{$nomes[0]}</strong> faz anos hoje.";

    }

}
