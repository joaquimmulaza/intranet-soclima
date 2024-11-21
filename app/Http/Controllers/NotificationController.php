<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\NotificationUsers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Carrega notificações não lidas
        $notificacoes = NotificationUsers::where('lida', false)->orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notificacoes'));
    }

    public function showNavbar()
    {
        $notificacoes = $this->carregarNotificacoes();
        return view('master.partials_master._nav', compact('notificacoes'));
    }
    


    public function marcarComoLida($id)
    {
        $notificacao = NotificationUsers::findOrFail($id);
        $notificacao->lida = true;
        $notificacao->save();

        return redirect($notificacao->rota ?? route('home'));
    }

    public static function criar($tipo, $titulo, $descricao, $rota = null, $userId = null)
    {
        NotificationUsers::create([
            'tipo' => $tipo,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'rota' => $rota,
            'user_id' => $userId,
        ]);
    }

 

public function obterNotificacoes()
{
    $userId = Auth::id();

    // Buscar notificações destinadas ao usuário logado
    $notificacoes = NotificationUsers::where('user_id', $userId)->get();

    return view('notificacoes.index', compact('notificacoes'));
}

}
