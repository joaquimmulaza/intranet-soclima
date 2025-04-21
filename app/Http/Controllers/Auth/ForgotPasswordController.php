<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\User;

class ForgotPasswordController extends Controller
{
    // Exibir o formulário de recuperação de senha
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Verificar se o usuário existe e enviar o código de confirmação
    public function verifyUser(Request $request)
    {
        try {
            $request->validate([
                'numero_mecanografico' => 'required',
                'email' => 'required|email',
            ]);

            $user = User::where('numero_mecanografico', $request->numero_mecanografico)
                        ->where('email', $request->email)
                        ->first();

            if (!$user) {
                return response()->json(['error' => 'Nenhum usuário encontrado com esse ID e e-mail.'], 422);
            }

            // Gerar um código de confirmação
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Armazenar o código na sessão
            $request->session()->put('forgot_password_verification_code', $code);
            $request->session()->put('forgot_password_user_id', $user->id);

            // Enviar o código por e-mail
            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

            return response()->json(['success' => 'Código de confirmação enviado com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao verificar usuário: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }

    // Confirmar o código de verificação
    public function confirmCode(Request $request)
    {
        try {
            $request->validate([
                'confirmation_code' => 'required|numeric|digits:6',
            ]);

            $storedCode = $request->session()->get('forgot_password_verification_code');

            if (!$storedCode || $storedCode !== $request->confirmation_code) {
                return response()->json(['error' => 'Código inválido.'], 422);
            }

            return response()->json(['success' => 'Código confirmado com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao confirmar código: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }

    // Redefinir a senha
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);

            $userId = $request->session()->get('forgot_password_user_id');
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado.'], 422);
            }

            // Atualizar a senha
            $user->password = Hash::make($request->password);
            $user->save();

            // Limpar os dados da sessão
            $request->session()->forget(['forgot_password_verification_code', 'forgot_password_user_id']);

            // Retornar sucesso com a URL de redirecionamento
            return response()->json(['success' => 'Senha redefinida com sucesso.', 'redirect' => route('admin.login')]);
        } catch (\Exception $e) {
            \Log::error('Erro ao redefinir senha: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.'], 500);
        }
    }
}