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
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

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

        // Tentando encontrar o usuário com base no número mecanográfico
        $user = User::where('numero_mecanografico', $request->numero_mecanografico)->first();

        // Verificando se o usuário foi encontrado e se a senha está correta
        if ($user && Hash::check($request->password, $user->password) && $user->status == 'ativo') {
            Auth::login($user); // Faz o login do usuário
            return redirect()->route('home'); // Redireciona para a página principal
        }

        // Se não conseguiu autenticar, mostra uma mensagem de erro genérica
        return redirect()->back()->withInput()->withErrors(['Número mecanográfico ou senha incorretos!']);
    }


    // public function login(Request $request)
    // {

    //     if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
    //         return redirect()->back()->withInput()
    //             ->withErrors(['O email informado não é valido!']);
    //     }
    //      $credenciais = [
    //         'email'=> $request->email,
    //         'password'=> $request->password
    //     ];
    //     if(Auth::attempt($credenciais) && Auth::user()->status == "ativo"){
    //         return redirect()->route('home');
    //     }

    //     //notify()->success("Dados informado incorretos!","error","bottomRight");
    //     //return redirect()->route('admin.login');
    //     return redirect()->back()->withInput()->withErrors(['O email informado não é valido!']);
    // }

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

        // Envia uma mensagem SMS com o Vonage
        $this->sendWelcomeMessage($user, $temporaryPassword, $phoneNumber);

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
    $vonageKey = env('VONAGE_API_KEY');
    $vonageSecret = env('VONAGE_API_SECRET');
    $vonageFrom = env('VONAGE_FROM_NUMBER', 'Vonage APIs'); // Nome ou número de origem permitido pela Vonage

    // Personalize a mensagem

    $link = "https://cotarco.co.ao/intra-soclima";

    $message = "Olá, {$user->name},\nSeu ID de acesso é {$user->numero_mecanografico} e a sua\npalavra-passe é{$temporaryPassword}\nCaso queira alterar sua senha,\nclique no link a seguir:\n$link ";

    $client = new \Vonage\Client(new \Vonage\Client\Credentials\Basic($vonageKey, $vonageSecret));

    try {
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phoneNumber, $vonageFrom, $message)
        );

        $messageStatus = $response->current()->getStatus();
        if ($messageStatus != 0) {
            \Log::error("Falha ao enviar SMS para {$phoneNumber}. Status: {$messageStatus}");
        }
    } catch (\Exception $e) {
        \Log::error("Erro ao enviar SMS: " . $e->getMessage());
    }
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

    function iniciarVerificacao($numeroTelefone) {
        $twilioSid = getenv('TWILIO_SID');
        $twilioAuthToken = getenv('TWILIO_AUTH_TOKEN');
        $client = new Client($twilioSid, $twilioAuthToken);
    
        try {
            // Envia o código de verificação para o número fornecido
            $verification = $client->verify->v2->services("YOUR_VERIFICATION_SERVICE_SID")
                ->verifications
                ->create($numeroTelefone, "sms");
    
            return $verification->sid;
        } catch (\Exception $e) {
            echo "Erro ao iniciar a verificação: " . $e->getMessage();
            return null;
        }
    }

    function confirmarVerificacao($numeroTelefone, $codigoVerificacao) {
        $twilioSid = getenv('TWILIO_SID');
        $twilioAuthToken = getenv('TWILIO_AUTH_TOKEN');
        $client = new Client($twilioSid, $twilioAuthToken);
    
        try {
            // Verifica o código de verificação
            $verificationCheck = $client->verify->v2->services("YOUR_VERIFICATION_SERVICE_SID")
                ->verificationChecks
                ->create([
                    "to" => $numeroTelefone,
                    "code" => $codigoVerificacao
                ]);
    
            return $verificationCheck->status === "approved";
        } catch (\Exception $e) {
            echo "Erro ao confirmar a verificação: " . $e->getMessage();
            return false;
        }
    }
    
    $numero = "+244923766405";
    $verificacaoSid = iniciarVerificacao($numero);
    if ($verificacaoSid) {
        echo "Código de verificação enviado para " . $numero;
    }

    $codigo = "123456";  // Código de verificação recebido
    $resultado = confirmarVerificacao($numero, $codigo);

    if ($resultado) {
        echo "Número verificado com sucesso!";
    } else {
        echo "Falha na verificação do número.";
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
