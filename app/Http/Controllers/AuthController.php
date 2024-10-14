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
            if ($post) {
                $posts = Post::where('id', '!=', $post->id)
                    ->where('validate_at', '>=', $dataHoje->toDateString())
                    ->orderBy('id', 'DESC')
                    ->paginate(8);
            } else {
                // Se não houver posts, retorna uma coleção vazia
                $posts = collect();
            }
    
            // Busca os questionários
            $questionarios = Questionaire::where('status', '=', 'Finalizado')
                ->where('validate_at', '>=', $dataHoje->toDateString())
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

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return redirect()->back()->withInput()
                ->withErrors(['O email informado não é valido!']);
        }
         $credenciais = [
            'email'=> $request->email,
            'password'=> $request->password
        ];
        if(Auth::attempt($credenciais) && Auth::user()->status == "ativo"){
            return redirect()->route('home');
        }

        //notify()->success("Dados informado incorretos!","error","bottomRight");
        //return redirect()->route('admin.login');
        return redirect()->back()->withInput()->withErrors(['O email informado não é valido!']);
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
        try{
            $user = new User();
            $user->name = $request->name;

            $users = User::all();

            foreach($users as $u){
                if($request->email == $u->email){
                    notify()->success("Por favor registre","Success","bottomRight");
                    return redirect()->route('user.register');
                }
            }

            $user->email = $request->email;
            $user->remember_token = Str::random(8);
            $user->password = Hash::make($user->remember_token);
            $user->status = "inativo";
            $user->role_id = 2;
            $user->cargo_id = 2;
            $user->unidade_id = 1;

            $user->save();

            return redirect()->route('user.pedido');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->route('admin.login');
            }
            notify()->error("Ocorreu um erro ao tentar criar um usuário!","Error","bottomRight");
            return redirect()->back();
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
