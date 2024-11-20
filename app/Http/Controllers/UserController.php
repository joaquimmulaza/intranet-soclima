<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Feria;
use App\Comment;
use App\Exports\PedidosExport;
use App\Exports\UsersExport;
use App\Mail\notificationMail;
use App\Notifications\UserNotificacao;
use App\Mail\correioMail;
use App\Questionaire;
use App\Role;
use App\Survey;
use App\Unidade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Str;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class UserController extends Controller
{
    /*Annotation: --------------------------------------------------------------
    |1.Lista todos usuário ativos.
    |2.Lista todos usuário inativos.
    |3.Chama tela de cadastro e lista em combo cargos, unidades e funções.
    |4.Realiza o cadastro.
    |5.Mostra usuário selecionado.
    |6.Chama tela de edição e lista em combo cargos, unidades e funções.
    |7.Deleta usuário, avatar personalizado e comentários deste usuário.
    |8.Exporta lista de usuários ativos Excel.
    |9.Exporta lista de usuários inativos Excel.
    |10.Libera pedido de um usuário.
    |11.Nega pedido de usuário.
    |--------------------------------------------------------------------------*/

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = User::where('status', '=', 'ativo')->get();
        return view('user.index', compact('users'));
    }

    public function envio(){
        //Mail::to('rafaelblumdigital@gmail.com')->send(new CorreioMail());

        $details = [
            'title'=> 'Confirmação Soclima',
            'body'=> 'Seu acesso ao sistema foi aceite!'
        ];

        $novo = User::find(1);
        Mail::to($novo->email)->send(new CorreioMail($details, $novo));

        return redirect()->route('user.index');
    }

    public function pedidos() {
        $users = User::where('status', '!=', 'ativo')->get();
        $ferias = Feria::where('status', 'pendente')->get(); // Ajuste conforme sua lógica
        return view('user.pedidos', compact('users', 'ferias'));
    }

    public function liberaPedido(User $user){
        $autor = Auth::user();
        $details = [
            'title'=> 'Confirmação Soclima',
            'body'=> 'Seu acesso ao sistema foi aceite!',
            'user' => $autor->name,
            'pedido'=> 'liberado'
        ];
        //Mail::to('rafaelblum_digital@hotmail.com')->send(new CorreioMail($details, $user));
        Mail::send(new CorreioMail($details, $user));

        notify()->success("Usuário liberado com sucesso!","Success","bottomRight");
        return redirect()->route('user.pedidos');
    }

    public function negarPedido(User $user){
        $autor = Auth::user();

        $details = [
            'title'=> 'Pedido negado - Soclima',
            'body'=> 'Seu pedido ao sistema foi negado!',
            'user' => $autor->name,
            'pedido'=> 'bloqueado'
        ];


        //Mail::to($autor->email)->send(new CorreioMail($details, $user));
        Mail::send(new CorreioMail($details, $user));

        notify()->success("Usuário bloqueado com sucesso!","Success","bottomRight");
        return redirect()->route('user.pedidos');
    }

    public function create()
    {
        $responsaveis = User::whereHas('unidade')->get();
        $unidades = Unidade::all();
        $cargos = Cargo::all();
        $unidades = Unidade::all();
        $funcoes = Role::all();
        return view('user.create', compact('cargos', 'unidades', 'funcoes', 'responsaveis'));
    }

    public function store(Request $request)
    {
        try{
            // Verifica se o email já está em uso
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                notify()->error("O email já está registrado, por favor, tente outro.", "Erro", "bottomRight");
                return redirect()->route('user.create');
            }
            $user = new User();
            $user->numero_mecanografico = $request->numero_mecanografico;
            $user->name = $request->name;
            $user->numero_bi = $request->numero_bi;
            $user->numero_beneficiario = $request->numero_beneficiario;
            $user->numero_contribuinte = $request->numero_contribuinte;
            $user->data_admissao = $request->data_admissao;
            $user->nascimento = $request->nascimento; // Utilizando 'nascimento'
            $user->cargo_id = $request->funcao;
            $user->unidade_id = $request->departamento;
            $user->email = $request->email;
            $user->data_emissao_bi = $request->data_emissao_bi;
            $user->data_validade_bi = $request->data_validade_bi;
            $user->fone = $request->fone;
            $user->genero = $request->genero;
            $user->responsavel_id = $request->responsavel_id;
            $user->status = 'ativo';
            $temporaryPassword = Str::random(8); // Gera a senha temporária
            $user->password = Hash::make($temporaryPassword); // Criptografa a senha

            $cargo = Cargo::find($request->cargo);
            $user->cargo_id = $cargo->id;

            $unidade = Unidade::find($request->unidade);
            $user->unidade_id = $unidade->id;

            $role = Role::find($request->role);
            $user->role_id = $role->id;



            // $user->nascimento = $request->nascimento;

            // $user->state_civil = $request->stateCivil;
            // $user->formacao = $request->formacao;
            // $user->fone = $request->fone;
            // $user->ramal = $request->ramal;
            // $user->descricao = $request->descricao;

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save(public_path('public/avatar_users/' . $filename));
                $user->avatar = $filename;
            }

            $user->save();
            // dd('SALVO USER');
            $phoneNumber = $user->fone;
            if (strpos($phoneNumber, '+') !== 0) {
                $phoneNumber = '+244' . ltrim($phoneNumber, '0'); // Adiciona o código +244 de Angola
            }
            $this->sendWelcomeMessage($user, $temporaryPassword, $phoneNumber);

            notify()->success("Usuário criado com sucesso!","Success","bottomRight");
            return redirect()->route('user.index');

        }catch (\Exception $e){
            dd('ERRO!!'. ' - '. $e);
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar criar um usuário!","Error","bottomRight");
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

        $message = "Olá, {$user->name},\nSeu ID de acesso é {$user->numero_mecanografico} e a sua\npalavra-passe é {$temporaryPassword}\nCaso queira alterar sua senha,\nclique no link a seguir:\n$link ";

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

    public function show(User $user)
    {
        $questionarios = Questionaire::where('user_id', $user->id)->get();
        $enquetes = Survey::where('email', Auth::user()->email)->get();

        //$myPosts = Post::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(5); , 'myPosts'
        return view('user.show', compact('user', 'questionarios', 'enquetes'));
    }

    public function edit(User $user)
    {
        $responsaveis = User::whereHas('unidade')->get();  // Assumindo que os responsáveis têm unidades associadas
    
        // Outras variáveis que você já está passando para a view
        $unidades = Unidade::all(); 
        $cargos = Cargo::all();
        $unidades = Unidade::all();
        $funcoes = Role::all();
        return view('user.create', compact('user', 'cargos', 'unidades', 'funcoes', 'responsaveis'));
    }

    //SEM USO - toggle ativa usuario
    public function ativacao(Request $request){
        /*DATA - REQUEST TEM:
         * status: ativo ou inativo
         * member_id: O ID do usuario
         * */

        $user = User::find($request->member_id);
        $user->status = $request->status;
        $user->save();
        notify()->success("Usuário editado com sucesso!","Success","bottomRight");
        return redirect()->route('home');
    }

    public function update(Request $request, User $user)
    {
        try{

            $user->name = $request->name;
            $user->email = $request->email;
            $user->numero_mecanografico = $request->numero_mecanografico;
            $user->numero_bi = $request->numero_bi;
            $user->numero_beneficiario = $request->numero_beneficiario;
            $user->numero_contribuinte = $request->numero_contribuinte;
            $user->data_admissao = $request->data_admissao;
            $user->nascimento = $request->nascimento;
            $user->data_emissao_bi = $request->data_emissao_bi;
            $user->data_validade_bi = $request->data_validade_bi;
            $user->fone = $request->fone;
            $user->genero = $request->genero;
            if(!empty($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->status = 'ativo';

            if($request->cargo != null){
                $cargo = Cargo::find($request->cargo);
                $user->cargo_id = $cargo->id;
            }
            if($request->unidade != null ){
                $unidade = Unidade::find($request->unidade);
                $user->unidade_id = $unidade->id;
            }
            if($request->role != null ){
                $role = Role::find($request->role);
                $user->role_id = $role->id;
            }
            
            // $user->state_civil = $request->stateCivil;
            // $user->formacao = $request->formacao;
            // $user->fone = $request->fone;
            // $user->ramal = $request->ramal;
            // $user->descricao = $request->descricao;


            

            //dd($user);

            if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = $user->id . "_" . time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save(public_path('public/avatar_users/' . $filename));

                if($user->avatar !== 'default.jpg'){
                    File::delete(public_path('public/avatar_users/' . $user->avatar));
                }
                $user->avatar =  $filename;
            }

            $user->save();

            notify()->success("Usuário editado com sucesso!","Success","bottomRight");
            return redirect()->route('user.index', compact('user'));

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                //dd($e->getMessage());
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar editar um usuário!","Error","bottomRight");
            return redirect()->back();
        }

    }

    public function destroy(User $user)
    {
        try{
            $user->load('comments');
            if($user->avatar !== 'default.jpg'){
                File::delete(public_path('public/avatar_users/' . $user->avatar));
            }
            $user->delete();

            notify()->success("Usuário excluido com sucesso!","Success","bottomRight");
            return redirect()->route('user.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar excluir um usuário!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function export(){
        return Excel::download(new UsersExport, 'Lista_usuarios.xlsx');
    }

    public function exportPedidos(){
        return Excel::download(new PedidosExport, 'Lista_pedidos.xlsx');
    }
}
