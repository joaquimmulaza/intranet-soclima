<?php

namespace App\Http\Middleware;

use Closure;
use App\NotificationUsers;
use Illuminate\Support\Facades\Auth;
class ShareNotifications
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $notificacoes = NotificationUsers::where('user_id', $userId)->get();
            view()->share('notificacoes', $notificacoes);
            $lidas = NotificationUsers::where('user_id', $userId)
                ->where('lida', true)
                ->orderBy('created_at', 'desc')
                ->get();

            $naoLidas = NotificationUsers::where('user_id', $userId)
                ->where('lida', false)
                ->orderBy('vista', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            view()->share(compact('lidas', 'naoLidas'));
        }

        return $next($request);
    }
}
