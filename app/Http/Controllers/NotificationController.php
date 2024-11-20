<?php

namespace App\Http\Controllers;

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
    // Carrega notificações não lidas para a navegação
    $notificacoes = NotificationUsers::where('lida', false)->orderBy('created_at', 'desc')->get();
    
    // Passa a variável para a view que renderiza o menu de navegação
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

}
