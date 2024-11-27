<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\NotificationUsers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Notificações "Não Lidas" (Inclui vistas ou não vistas, mas não marcadas como lidas)
        $naoLidas = NotificationUsers::where('user_id', $userId)
            ->where('lida', false)
            ->orderBy('vista', 'asc') // Exibe não vistas primeiro
            ->orderBy('created_at', 'desc')
            ->get();

        // Notificações "Lidas"
        $lidas = NotificationUsers::where('user_id', $userId)
            ->where('lida', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('naoLidas', 'lidas'));
    }


    public function showNavbar()
    {
        $notificacoes = $this->carregarNotificacoes();
        return view('master.partials_master._nav', compact('notificacoes'));
    }
    


    public function marcarComoLida($id)
    {
        $notificacao = NotificationUsers::where('id', $id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('responsavel_id', auth()->id());
            })
            ->first();

        if ($notificacao) {
            $notificacao->lida = true;
            $notificacao->save();

            return response()->json(['success' => true, 'message' => 'Notificação marcada como lida.']);
        }

        return response()->json(['success' => false, 'message' => 'Notificação não encontrada.'], 404);
    }



    public static function criar($tipo, $titulo, $descricao, $rota = null, $userId = null)
    {
        NotificationUsers::create([
            'tipo' => $tipo,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'rota' => $rota,
            'user_id' => $userId,
            'vista' => false, // Notificação criada como "não vista"
        ]);
    }


 

public function obterNotificacoes()
{
    $userId = Auth::id();

    // Buscar notificações destinadas ao usuário logado
    $notificacoes = NotificationUsers::where('user_id', $userId)->get();

    return view('notificacoes.index', compact('notificacoes'));
}


public function marcarComoVista()
{
    $userId = Auth::id();

    // Atualiza todas as notificações do usuário para "vista"
    NotificationUsers::where('user_id', $userId)
        ->where('vista', false)
        ->update(['vista' => true]);

    return response()->json(['success' => true]);
}

public function marcarComoVistas(Request $request) {
    // Autenticação do usuário
    $user = auth()->user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Usuário não autenticado.'], 401);
    }

    // Marcar todas as notificações como vistas
    $notificacoes = NotificationUsers::where('user_id', $user->id)
        ->where('vista', false)
        ->update(['vista' => true, 'lida' => true]);

    return response()->json(['success' => true, 'mensagem' => 'Notificações marcadas como vistas.']);
}

}
