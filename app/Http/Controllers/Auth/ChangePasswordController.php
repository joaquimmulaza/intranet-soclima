<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibir a página de configurações
    public function showConfig()
    {
        return view('auth.config');
    }

    // Solicitar e enviar o código de confirmação
    public function requestCode(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = auth()->user();

            // Verificar se a senha atual está correta
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'A palavra-passe atual está incorreta.'], 422);
            }

            // Gerar um código de confirmação
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Armazenar o código e a nova senha na sessão
            $request->session()->put('verification_code', $code);
            $request->session()->put('new_password', Hash::make($request->password));

            // Enviar o código por e-mail
            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

            return response()->json(['success' => 'Código enviado com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao solicitar código de verificação: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }

    // Confirmar o código e alterar a senha
    public function confirmCode(Request $request)
    {
        try {
            $request->validate([
                'confirmation_code' => 'required|numeric|digits:6',
            ]);

            $user = auth()->user();
            $storedCode = $request->session()->get('verification_code');
            $newPassword = $request->session()->get('new_password');

            if (!$storedCode || $storedCode !== $request->confirmation_code) {
                return response()->json(['error' => 'Código inválido.'], 422);
            }

            if (!$newPassword) {
                return response()->json(['error' => 'Nenhuma nova senha pendente.'], 422);
            }

            // Aplicar a nova senha
            $user->password = $newPassword;
            $user->save();

            // Limpar os dados da sessão
            $request->session()->forget(['verification_code', 'new_password']);

            return response()->json(['success' => 'Palavra-passe alterada com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao confirmar código: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }

    // Reenviar o código de confirmação
    public function resendCode(Request $request)
    {
        try {
            $user = auth()->user();
            $code = $request->session()->get('verification_code');

            if (!$code) {
                return response()->json(['error' => 'Nenhum código pendente.'], 422);
            }

            // Reenviar o código por e-mail
            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

            return response()->json(['success' => 'Código reenviado com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao reenviar código: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }
}