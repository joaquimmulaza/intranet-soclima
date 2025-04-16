<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\NotificationUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\User;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Notificações "Não Lidas" (Inclui vistas ou não vistas, mas não marcadas como lidas)
        $naoLidas = NotificationUsers::where('user_id', $userId)
            ->where('lida', false)
            ->orderBy('vista', 'desc') // Exibe não vistas primeiro
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
        $userId = Auth::id();
        // Carregar notificações específicas do usuário ou globais
        $notificacoes = NotificationUsers::where(function ($query) use ($userId) {
            $query->where('user_id', $userId) // Notificações específicas
                ->orWhereNull('user_id');  // Notificações globais
        })
        ->orderBy('created_at', 'desc')
        ->get();
        return view('master.partials_master._nav', compact('notificacoes'));
    }

    public function markAsRead($id)
    {
        $notificacao = NotificationUsers::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if ($notificacao) {
            $notificacao->lida = true;
            $notificacao->save();
            return response()->json(['success' => true, 'message' => 'Notificação marcada como lida.']);
        }
        Log::warning('Notificação não encontrada ou não pertence ao usuário.', ['id' => $id, 'user_id' => auth()->id()]);
        return response()->json(['success' => false, 'message' => 'Notificação não encontrada.'], 404);
    }

    public static function criar($tipo, $titulo, $descricao, $rota = null, $userId = null, $origem_user_id = null)
    {
        NotificationUsers::create([
            'tipo' => $tipo,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'rota' => $rota,
            'user_id' => $userId,
            'origem_user_id' => $origem_user_id, // quem gerou a notificação
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

    public function marcarComoVistas()
    {
        $userId = Auth::id();

        // Atualiza todas as notificações do usuário para "vista", mas sem marcar como "lida"
        NotificationUsers::where('user_id', $userId)
            ->where('vista', false) // Marca apenas as notificações que ainda não foram vistas
            ->update(['vista' => true]);

        return response()->json(['success' => true]);
    }

    public function gerarNotificacaoAniversariantes()
    {
        $hoje = Carbon::now()->format('m-d');

        // Filtra usuários que fazem aniversário hoje
        $aniversariantes = User::whereRaw("DATE_FORMAT(nascimento, '%m-%d') = ?", [$hoje])->get();

        if ($aniversariantes->count() > 0) {
            if ($aniversariantes->count() === 1) {
                $descricao = "{$aniversariantes[0]->nome} faz anos hoje.";
            } else {
                $primeiroNome = $aniversariantes[0]->nome;
                $descricao = "$primeiroNome e mais " . ($aniversariantes->count() - 1) . " pessoas fazem anos hoje.";
            }

            // Cria a notificação global para os usuários
            NotificationUsers::create([
                'user_id' => null, // null indica que é uma notificação global
                'titulo' => 'Aniversariantes do dia',
                'descricao' => $descricao,
                'rota' => '#', // Pode ajustar para uma rota específica, se desejar
                'lida' => false,
                'vista' => false,
            ]);
        }
    }

    public function congratulate(Request $request)
    {
        $userId = $request->input('user_id');
        $currentUser = Auth::user();

        // Find the user being congratulated
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        // Check if a congratulation notification exists for this user today
        $today = Carbon::today();
        $existingNotification = NotificationUsers::where('user_id', $userId)
            ->where('tipo', 'congratulation')
            ->whereDate('created_at', $today)
            ->first();

        // Prepare congratulators list
        $congratulators = $existingNotification ? json_decode($existingNotification->congratulators ?? '[]', true) : [];
        if (!in_array($currentUser->name, $congratulators)) {
            $congratulators[] = $currentUser->name;
        }

        // Determine notification text based on number of congratulators
        $count = count($congratulators);
        if ($count === 1) {
            $message = "{$congratulators[0]} parabenizou você.";
        } elseif ($count === 2) {
            $message = "{$congratulators[0]} e {$congratulators[1]} parabenizaram você.";
        } else {
            $message = "{$congratulators[0]} e outras " . ($count - 1) . " pessoas parabenizaram você.";
        }

        // Delete existing notification if it exists
        if ($existingNotification) {
            $existingNotification->delete();
        }

        // Create new notification
        NotificationUsers::create([
            'tipo' => 'congratulation',
            'titulo' => $message,
            'descricao' => $message,
            'congratulators' => json_encode($congratulators), // Store congratulators separately
            'rota' => '#',
            'user_id' => $userId,
            'origem_user_id' => $currentUser->id,
            'vista' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Parabéns enviados com sucesso.']);
    }

    
    public function checkCongratulation(Request $request)
    {
        $userId = $request->input('user_id');
        $currentUser = Auth::user();

        // Check if the current user has congratulated this user today
        $today = Carbon::today();
        $hasCongratulated = NotificationUsers::where('user_id', $userId)
            ->where('tipo', 'congratulation')
            ->whereDate('created_at', $today)
            ->whereRaw('JSON_CONTAINS(congratulators, ?)', [json_encode($currentUser->name)])
            ->exists();

        return response()->json(['hasCongratulated' => $hasCongratulated]);
    }
}