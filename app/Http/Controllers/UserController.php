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
use App\DiasFerias;
use Carbon\Carbon;
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
use App\Imports\FeriasImport;
use Illuminate\Support\Facades\Log; // Importação do Log

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

    public function pedidos()
    {
        $responsavelId = Auth::id();
      

        // Recupera apenas as férias pendentes do responsável logado
        $ferias = Feria::where('status', 'pendente')
                    ->where('responsavel_id', $responsavelId)
                    ->get();

        // Recupera as férias de todos os usuários (independente do status)
        $feriasUsuarios = Feria::where('responsavel_id', $responsavelId)->get();

        // Recupera os dados do usuário logado (se precisar passá-los para a view)
        $user = Auth::user();
        
        // Criar um array associativo para armazenar os dias solicitados de cada pedido
        $diasSolicitados = [];
        // Criar um array para armazenar os usuários associados às féria

        foreach ($ferias as $feria) {
            $diasSolicitados[$feria->id] = $feria->diasSolicitados($feria->data_inicio, $feria->data_fim);
        }

       

        return view('user.pedidos', compact('ferias', 'diasSolicitados', 'feriasUsuarios', 'user', 'responsavelId'));
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
            // Aqui começa a parte do cálculo de férias
            $this->calcularFeriasAnoAdmissao($user); 

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

        public function calcularFeriasAnoAdmissao(User $user)
    {
        // Obter a data de admissão do usuário
        $dataAdmissao = Carbon::parse($user->data_admissao);
        $dataAtual = Carbon::now();  // Data atual

        // Calcular a diferença em meses completos
        $mesesTrabalhados = $dataAdmissao->diffInMonths($dataAtual);

        // Calcular os dias de férias proporcionais (2 dias por mês, no máximo 22 dias)
        $diasFeriasProporcionais = min($mesesTrabalhados * 2, 22);  // 2 dias úteis por mês, com limite máximo de 22 dias

        // Verificar se já existe um registro de dias de férias para o ano de admissão
        $anoAdmissao = $dataAdmissao->year;

        $diasFerias = $user->diasFerias()->where('ano', $anoAdmissao)->first();

        if (!$diasFerias) {
            // Se não existir, cria o registro de dias de férias para o ano de admissão
            $diasFerias = new DiasFerias();
            $diasFerias->user_id = $user->id;
            $diasFerias->ano = $anoAdmissao;
            $diasFerias->dias_disponiveis = $diasFeriasProporcionais;
            $diasFerias->save();
        } else {
            // Se já existir, apenas atualiza os dias de férias
            $diasFerias->dias_disponiveis = $diasFeriasProporcionais;
            $diasFerias->save();
        }

        return $diasFerias;
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
    public function ativacao(Request $request, $id)
    {
        // Encontrar o usuário pelo ID
        $user = User::find($id);

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // Alterar o status
        $user->status = $user->status == 'ativo' ? 'inativo' : 'ativo';
        $user->save();

        // Retornar sucesso
        return response()->json([
            'status' => $user->status,
            'message' => 'Status do usuário atualizado com sucesso!'
        ]);
    }

    public function mostrarContasSuspensas()
{
    $contasSuspensas = User::where('status', 'inativo')->get();

    // Retorna uma resposta JSON com os dados
    return response()->json($contasSuspensas);
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
            $user->responsavel_id = $request->responsavel_id;
          
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

            // Atualizar avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = $user->id . "_" . time() . '.' . $avatar->getClientOriginalExtension();

            // Definir o caminho onde a imagem será salva
            $path = public_path('public/avatar_users');

            // Criar o diretório se ele não existir
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Salvar a imagem no diretório 'public/uploads/avatar_users'
            $avatar->move($path, $filename);

            // Deletar o avatar anterior, se não for o padrão
            if ($user->avatar !== 'default.jpg' && file_exists(public_path('uploads/avatar_users/' . $user->avatar))) {
                unlink(public_path('uploads/avatar_users/' . $user->avatar));
            }

            // Atualizar o campo 'avatar' no banco de dados
            $user->avatar = $filename;
        }

        // Salvar alterações no banco de dados
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

    public function showUploadForm()
    {
        return view('user.upload');  // Aqui você cria uma view para o upload do Excel
    }


    public function importarFerias(Request $request)
{
    // Validação do arquivo enviado
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv',  // Valida se é um arquivo Excel ou CSV
    ]);

    // Verifica se o arquivo foi enviado
    if ($request->hasFile('file')) {
        // Salva o arquivo na pasta "laravel-excel" (padrão do pacote)
        $file = $request->file('file');
        $path = $file->store('framework/laravel-excel');  // O arquivo será salvo nesta pasta

        // Obtém o caminho do arquivo armazenado
        $filePath = $path; // Isso pega o caminho completo

        // Aqui você pode usar o pacote Excel para importar os dados
        try {
            // Passa o caminho do arquivo gerado dinamicamente
            Excel::import(new FeriasImport, $filePath);

            

            return redirect()->back()->with('success', 'Férias importadas com sucesso!');
        } catch (\Exception $e) {
            // Log de erro caso haja algum problema com a importação
            Log::error('Erro ao importar férias:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao importar o arquivo de férias!');
        }
    }

    return redirect()->back()->with('error', 'Erro ao fazer upload do arquivo!');
}

}
