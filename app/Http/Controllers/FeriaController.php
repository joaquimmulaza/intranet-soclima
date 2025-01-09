<?php
namespace App\Http\Controllers;

use App\Mail\FeriaSolicitadaMail;
use App\Mail\FeriaAprovadaOuReprovadaMail;
use Illuminate\Support\Facades\Mail;
use App\Feria;
use App\Feriado;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeriaController extends Controller
{
    public function pedidos()
    {
        // Obtém o ID do responsável logado
        $responsavelId = Auth::id();

        // Recupera apenas as férias pendentes do responsável logado
        $ferias = Feria::where('status', 'pendente')
                    ->where('responsavel_id', $responsavelId)
                    ->get();

        return view('user.pedidos', compact('ferias'));
    }

    public function create()
    {
        // Exibir o formulário para solicitar férias
        return view('ferias.marcar');
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $dataInicio = Carbon::parse($request->data_inicio);
        $dataFim = Carbon::parse($request->data_fim);

        $feria = new Feria();
        $diasSolicitados = $feria->diasSolicitados($dataInicio, $dataFim);

        // Criação do pedido de férias
        $feria->user_id = Auth::id();
        $feria->responsavel_id = Auth::user()->responsavel_id; // O responsável atribuído ao usuário
        $feria->data_inicio = $dataInicio;
        $feria->data_fim = $dataFim;
        $feria->status = 'pendente';
        $feria->data_retorno_prevista = $feria->calcularDataRetorno($dataInicio, $diasSolicitados);
        $feria->save();
        $UserName = Auth::user()->name; 

        // Criar notificação apenas para o responsável
        $notificationController = app(NotificationController::class);
        $notificationController->criar(
            'pedido_ferias',
            'Pedido de Férias',
            '<strong>' . $UserName . '</strong> solicitou férias de ' . $dataInicio->format('d/m/Y') . ' a ' . $dataFim->format('d/m/Y'),
            route('ferias.pedidos'),
            $feria->responsavel_id
        );

        $responsavel = User::find($feria->responsavel_id);
        $funcionario = Auth::user();

         // Enviar e-mail para o responsável
        Mail::send(new FeriaSolicitadaMail($funcionario, $feria));

        return redirect()->route('home')->with('success', 'Férias solicitadas com sucesso!');
    }

    public function update(Request $request, Feria $feria) {
        // Validação do formulário
        $request->validate([
            'user_id' => 'required',
            'responsavel_id' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);
    
        // Atualizando o pedido de férias existente
        $feria->user_id = $request->user_id;
        $feria->responsavel_id = $request->responsavel_id;
        $feria->data_inicio = $request->data_inicio;
        $feria->data_fim = $request->data_fim;
        $feria->status = 'Pendente';
    
        // Calculando a quantidade de dias solicitados
        $diasSolicitados = $feria->diasSolicitados();
    
        // Calculando a data de retorno prevista
        $feria->data_retorno_prevista = $feria->calcularDataRetorno($feria->data_inicio, $diasSolicitados);
    
        // Salvando as alterações no banco de dados
        $feria->save();
    
        return redirect()->route('ferias.index')->with('success', 'Pedido de férias atualizado com sucesso!');
    }

    public function updateDiasFerias(Request $request)
    {
        $request->validate([
            'dias_disponiveis' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->diasFerias()->updateOrCreate(
            ['user_id' => $user->id],
            ['dias_disponiveis' => $request->dias_disponiveis]
        );

        return redirect()->back()->with('success', 'Dias de férias atualizados com sucesso.');
    }

    public function showDiasFeriasForm($userId)
    {
        // Obtendo o usuário específico
        $user = User::findOrFail($userId);

        // Carregando a view e passando o usuário
        return view('ferias.atribuir', compact('user'));
    }


    

   
    

    public function calcularDataRetorno($dataInicio, $dataFim)
{
    \Log::info("Data de Início: {$dataInicio}");

    // Definindo a data de início e data fim
    $dataInicio = Carbon::parse($dataInicio);
    $dataFim = Carbon::parse($dataFim);

    // Adicionando log
    \Log::info("Data final: {$dataFim}");

    // Itera até que a data de retorno caia no dia útil correto
    while ($dataInicio->lte($dataFim)) {
        \Log::info("Verificando data: " . $dataInicio->toDateString());

        if ($dataInicio->isWeekend()) {
            \Log::info("Data é final de semana: " . $dataInicio->toDateString());
            // Se for sábado ou domingo, avance para a segunda-feira
            if ($dataInicio->isSaturday()) {
                $dataInicio->addDays(2); // Avançar para segunda-feira
            } elseif ($dataInicio->isSunday()) {
                $dataInicio->addDay(); // Avançar para segunda-feira
            }
        }

        // Adiciona um dia de cada vez
        $dataInicio->addDay();
    }

    return $dataInicio->toDateString();
}

    


 
    public function aprovar($id)
    {
        $feria = Feria::findOrFail($id);

        // Atualiza o status para aprovado
        $feria->status = 'aprovado';
        $feria->save();
        $responsavelNome = Auth::user()->name; 
        $funcionario = User::find($feria->user_id);

        // Enviar e-mail para o funcionário
        Mail::send(new FeriaAprovadaOuReprovadaMail($funcionario, $feria, 'aprovada'));
        // Cria uma notificação para o usuário que fez o pedido
        $notificationController = app(NotificationController::class);
        $notificationController->criar(
            'aprovacao_pedido',
            'Pedido de Férias Aprovado',
            'Seu pedido de férias foi aprovado por <strong>'. $responsavelNome . '</strong>.',
            route('user.pedidos'),
            $feria->user_id // ID do usuário que fez o pedido
        );

        return redirect()->route('user.pedidos')->with('success', 'Pedido de férias aprovado com sucesso.');
    }


        public function rejeitar($id)
    {
        $feria = Feria::findOrFail($id);

        // Atualiza o status para rejeitado
        $feria->status = 'rejeitado';
        $feria->save();
        $responsavelNome = Auth::user()->name; 

        $funcionario = User::find($feria->user_id);

        // Enviar e-mail para o funcionário
        Mail::send(new FeriaAprovadaOuReprovadaMail($funcionario, $feria, 'reprovada'));
    

        // Cria uma notificação para o usuário que fez o pedido
        $notificationController = app(NotificationController::class);
        $notificationController->criar(
            'rejeicao_pedido',
            'Pedido de Férias Rejeitado',
            'Seu pedido de férias foi rejeitado por <strong>'. $responsavelNome . '</strong>.',
            route('user.pedidos'),
            $feria->user_id // ID do usuário que fez o pedido
        );


        return redirect()->route('user.pedidos')->with('success', 'Pedido de férias rejeitado com sucesso.');
    }

    public function getEventos()
    {
        // Recupera todos os pedidos de férias aprovados
        $ferias = Feria::where('status', 'aprovado')->get();

        $events = [];
        foreach ($ferias as $feria) {
            $responsavelNome = $feria->responsavel ? $feria->responsavel->name : 'Desconhecido'; // Nome do responsável ou 'Desconhecido' se nulo
            
            // Ajusta a data de fim para incluir o último dia
            $endDate = Carbon::parse($feria->data_fim)->addDay(); 

            $events[] = [
                'title' => 'Férias de ' . $feria->user->name,
                'start' => Carbon::parse($feria->data_inicio)->toIso8601String(),
                'end' => $endDate->toIso8601String(),
                'description' => 'Aprovado por ' . $responsavelNome,
                'status' => $feria->status,
            ];
        }

        return response()->json($events);  // Retorna os eventos no formato JSON
    }


    public function show($id)
    {
        // Buscar o funcionário pelo ID
        $funcionario = User::findOrFail($id);
        // Verificar se o registro na tabela `dias_ferias` existe para o usuário
        if (!$funcionario->diasFerias) {
            // Criar o registro com o valor padrão de 22 dias disponíveis
            $funcionario->diasFerias()->create([
                'dias_disponiveis' => 22,
            ]);
        }

        // Buscar os dados de férias do funcionário
        $ferias = Feria::where('user_id', $id)
            ->where('status', 'Aprovado')  // Filtra apenas férias aprovadas
            ->get();

        // Obter os dias de férias anuais atualizados
        $feriasAnuais = $funcionario->diasFerias->dias_disponiveis ?? 22; // Usa o valor da relação ou 22 como padrão

        // Calcular os dias de férias já gozados
        $feriasGozadas = $ferias->sum(function ($feria) {
            return $this->diasSolicitados($feria->data_inicio, $feria->data_fim);
        });

        // Calcular os dias de férias restantes
        $feriasRestantes = max($feriasAnuais - $feriasGozadas, 0);

        // Formatar os períodos de férias para exibição
        $historicoFerias = $ferias->map(function ($feria, $index) {
            return [
                'periodo' => $index + 1,
                'data_inicio' => Carbon::parse($feria->data_inicio)->format('d/m/Y'),
                'data_fim' => Carbon::parse($feria->data_fim)->format('d/m/Y'),
                'data_retorno' => Carbon::parse($feria->data_fim)->addDay()->format('d/m/Y'), // Data de retorno prevista
            ];
        });

        // Enviar os dados para a view
        return view('ferias.show', compact('funcionario', 'feriasAnuais', 'feriasGozadas', 'feriasRestantes', 'historicoFerias'));
    }

}