<?php

namespace App\Http\Controllers;


use App\Post;
use App\Questionaire;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Str;
use Twilio\Rest\Client;

class AuthController extends Controller
{

    /*Annotation: --------------------------------------------------------------
    |   Auth::check() verificar se o usuario tem ou não login;
    |   Auth::user()  verificar o usuário logado;
    |
    |
    |--------------------------------------------------------------------------*/

    private $post;
    private $user;

    public function __construct(User $user, Post $post){
        $this->$user = $user;
        $this->$post = $post;
    }

    public function index(Request $request){

        if(Auth::check() === true && Auth::user()->status == "ativo"){
    
            // Busca todos os posts
            $posts = Post::all();
            $post = $posts->isNotEmpty() ? collect($posts)->last() : null; // Verifica se há posts
    
            $dataHoje = Carbon::now();
    
            // Se houver pelo menos um post, busca os outros posts com base nas condições
            // if ($post) {
            //     $posts = Post::where('id', '!=', $post->id)
            //         ->where('validate_at', '>=', $dataHoje->toDateString())
            //         ->orderBy('id', 'DESC')
            //         ->paginate(8);
            // } else {
            //     // Se não houver posts, retorna uma coleção vazia
            //     $posts = collect();
            // }
    
            // Busca os questionários
            $questionarios = Questionaire::where('status', '=', 'Finalizado')
                // ->where('validate_at', '>=', $dataHoje->toDateString())
                ->orderBy('id', 'DESC')
                ->paginate(10);
    
            // Retorna a view com os dados
            return view('public.home', compact('posts', 'post', 'questionarios'));
        }
        return redirect()->route('admin.login');
    }
    

    public function dashboard(Request $request){

        Gate::authorize('app.dashboard', auth::user());

        if(Auth::check() === true){
            $users = User::all();
            $questionarios = Questionaire::where('status', '=', 'Finalizado')->get();
            return view('admin.dashboard', compact('users', 'questionarios'));
        }
        return redirect()->route('admin.login');
    }

    public function loginForm(){
        return view('public.login');
    }

    public function login(Request $request)
    {
        // Validação simples para garantir que o número mecanográfico foi enviado
        if (!$request->numero_mecanografico || !$request->password) {
            return redirect()->back()->withInput()
                ->withErrors(['O número mecanográfico e a senha são obrigatórios.']);
        }

        // Definindo as credenciais para login
        $credenciais = [
            'numero_mecanografico' => $request->numero_mecanografico,
            'password' => $request->password
        ];

        // Tentando autenticar o usuário
        if (Auth::attempt($credenciais) && Auth::user()->status == "ativo") {
            return redirect()->route('home'); // Redireciona para a página principal
        }

        // Se não conseguiu autenticar, mostra uma mensagem de erro genérica
        return redirect()->back()->withInput()->withErrors(['Número mecanográfico ou senha incorretos!']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function registrarUsuario()
    {
        $msg = "Registre-se agora como novo colaborador";
        return view('public.register', compact('msg'));
    }

    public function registraPedido(){
        return view('public.pedido');
    }

    


    public function criarNovoUsuario(Request $request)
    {
        try {
            // Verifica se o email já está em uso
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                notify()->error("O email já está registrado, por favor, tente outro.", "Erro", "bottomRight");
                return redirect()->route('user.create');
            }

            // Cria o novo usuário com uma senha temporária
            $user = new User();
            $user->numero_mecanografico = $request->numero_mecanografico;
            $user->name = $request->name;
            $user->numero_bi = $request->numero_bi;
            $user->numero_beneficiario = $request->numero_beneficiario;
            $user->numero_contribuinte = $request->numero_contribuinte;
            $user->data_admissao = $request->data_admissao;
            $user->nascimento = $request->nascimento; // Utilizando 'nascimento'
            $user->role_id = 2;
            $user->cargo_id = 2;
            $user->unidade_id = 1;
            $user->email = $request->email;
            $user->data_emissao_bi = $request->data_emissao_bi;
            $user->data_validade_bi = $request->data_validade_bi;
            $user->fone = $request->fone;
            $user->genero = $request->genero;
            $user->responsavel_id = $request->responsavel_id;
            $temporaryPassword = Str::random(8);  // Gera uma senha aleatória de 8 caracteres
            $user->password = Hash::make($temporaryPassword);
            $user->status = 'ativo';

            // Salva o novo usuário
            $user->save();
            $phoneNumber = $user->fone;
            if (strpos($phoneNumber, '+') !== 0) {
                $phoneNumber = '+244' . ltrim($phoneNumber, '0'); // Adiciona o código +244 de Angola
            }
            // Envia uma mensagem SMS com o Twilio
            $this->sendWelcomeMessage($user, $temporaryPassword, $user->fone);

            return redirect()->route('user.index');

        } catch (\Exception $e) {
            \Log::error('Erro ao criar novo usuário: ' . $e->getMessage());
            if (env('APP_DEBUG')) {
                flash($e->getMessage())->warning();
                return redirect()->route('user.index');
            }
            notify()->error("Ocorreu um erro ao tentar criar um usuário!", "Error", "bottomRight");
            return redirect()->back();
        }
    }

    private function sendWelcomeMessage(User $user, $temporaryPassword, $phoneNumber)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($twilioSid, $twilioAuthToken);

        // Personalize a mensagem
        $message = "Olá, {$user->name}! Bem-vindo(a)! Seu ID de acesso é {$user->numero_mecanografico} e sua senha de acesso é: {$temporaryPassword}. para alterar clique no link:";

        // Envia a mensagem para o número de telefone do usuário
        $client->messages->create(
            $phoneNumber, // Certifique-se de que o campo 'phone' está preenchido corretamente no banco de dados
            
            [
                'from' => $twilioPhoneNumber,
                'body' => $message
            ]
        );
    }

    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $authUser = User::where('email', $user->email)->first();

        if($authUser){
            Auth::login($authUser);
            if(Auth::check() === true && Auth::user()->status == "ativo"){
                return redirect()->route('home');
            }
        }else{
            try{

                return redirect()->route('user.register');

            }catch (\Exception $e){
                if(env('APP_DEBUG')){
                    flash($e->getMessage())->warning();
                    return redirect()->route('admin.login');
                }

                return redirect()->back()->withInput()->withErrors(['O email informado não é valido!']);
            }
        }
    }

    public function redirectToProviderGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderGithubCallback()
    {
        $users = Socialite::driver('github')->user();

        dd($users);

        $eu = new User();

        $user = User::where('name', '=', $users->getName())->get();


        //$user = User::firstOrCreate([
        // 'email' => $user->email
        // ],[
        //'name' => $user->name,
        // 'password' => Hash::make(Str::random(24))
        //]);

        //Auth::login($user, true);

        return redirect()->route('admin.login.do');
    }


    public function testTwilio()
{
    try {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $client = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);

        // Número para onde enviar a mensagem de teste
        $toPhoneNumber = '+244923766405'; // Substitua pelo número de telefone com o código do país, exemplo: +5511999999999

        // Mensagem de teste
        $message = "Este é um teste de integração com o Twilio!";

        // Envia a mensagem de teste
        $client->messages->create(
            $toPhoneNumber,
            [
                'from' => $twilioPhoneNumber,
                'body' => $message
            ]
        );

        return "Mensagem de teste enviada com sucesso!";
    } catch (\Exception $e) {
        return "Erro ao enviar a mensagem: " . $e->getMessage();
    }
}


    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $authUser = User::where('email', $user->email)->first();

        if($authUser){
            Auth::login($authUser);
            if(Auth::check() === true && Auth::user()->status == "ativo"){
                return redirect()->route('home');
            }
        }else{
            try{

                return redirect()->route('user.register');

            }catch (\Exception $e){
                if(env('APP_DEBUG')){
                    flash($e->getMessage())->warning();
                    return redirect()->route('admin.login');
                }

                return redirect()->back()->withInput()->withErrors(['O email informado não é valido!']);
            }
        }
    }

}
