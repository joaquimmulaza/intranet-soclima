<?php

namespace App\Http\Middleware;

use Closure;
use App\NotificationUsers;

class ShareNotifications
{
    public function handle($request, Closure $next)
    {
        // Carrega as notificações não lidas
        $notificacoes = NotificationUsers::where('lida', false)->orderBy('created_at', 'desc')->get();

        // Compartilha as notificações com todas as views
        view()->share('notificacoes', $notificacoes);

        return $next($request);
    }
}
