<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
        $user->verification_code = $code;
        $user->new_password = Hash::make($request->password); // Armazenar temporariamente a nova senha
        $user->save();

        // Enviar o código por e-mail
        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return response()->json(['success' => 'Código enviado com sucesso.']);
    }

    // Confirmar o código e alterar a senha
    public function confirmCode(Request $request)
    {
        $request->validate([
            'confirmation_code' => 'required|numeric|digits:6',
        ]);

        $user = auth()->user();

        if ($user->verification_code !== $request->confirmation_code) {
            return response()->json(['error' => 'Código inválido.'], 422);
        }

        // Aplicar a nova senha
        $user->password = $user->new_password;
        $user->verification_code = null;
        $user->new_password = null;
        $user->save();

        return response()->json(['success' => 'Palavra-passe alterada com sucesso.']);
    }

    // Reenviar o código de confirmação
    public function resendCode(Request $request)
    {
        $user = auth()->user();

        if (!$user->verification_code) {
            return response()->json(['error' => 'Nenhum código pendente.'], 422);
        }

        // Reenviar o código por e-mail
        Mail::to($user->email)->send(new VerificationCodeMail($user->verification_code));

        return response()->json(['success' => 'Código reenviado com sucesso.']);
    }
}