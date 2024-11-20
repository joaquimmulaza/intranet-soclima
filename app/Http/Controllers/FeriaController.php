<?php

namespace App\Http\Controllers;

use App\Feria;
use App\Feriado;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeriaController extends Controller
{
    public function pedidos()
    {
        // Exibir todos os pedidos de férias do usuário logado
        $users = User::where('status', '!=', 'ativo')->get();
        $ferias = Feria::where('status', 'pendente')->get(); // Ajuste conforme sua lógica
        return view('user.pedidos', compact('users', 'ferias'));
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

    // Cálculo de dias de férias solicitados
    $dataInicio = Carbon::parse($request->data_inicio);
    $dataFim = Carbon::parse($request->data_fim);

    // Instanciar a variável $feria antes de acessar o método
    $feria = new Feria();

    // Calcular os dias solicitados com o método da instância
    $diasSolicitados = $feria->diasSolicitados($dataInicio, $dataFim); // Supondo que o método diasSolicitados utilize essas variáveis

    // Verificar dias úteis disponíveis (implementaremos essa lógica mais adiante)

    // Criação do pedido de férias
    $feria->user_id = Auth::id();
    $feria->responsavel_id = Auth::user()->responsavel_id; // O responsável atribuído ao usuário
    $feria->data_inicio = $dataInicio; // Usando a variável processada
    $feria->data_fim = $dataFim;       // Usando a variável processada
    $feria->status = 'pendente'; // O status será "pendente" até ser aprovado pelo responsável

    // Implementação da data de retorno prevista
    $feria->data_retorno_prevista = $feria->calcularDataRetorno($feria->data_inicio, $diasSolicitados);

    // Salvar o pedido de férias no banco de dados
    $feria->save();

    // **Criar uma notificação para o responsável**
    $notificationController = app(NotificationController::class);
    $notificationController->criar(
        'pedido_ferias',
        'Novo Pedido de Férias',
        Auth::user()->name . ' solicitou férias para o período de ' . $dataInicio->format('d/m/Y') . ' a ' . $dataFim->format('d/m/Y') . '.', // Agora usa $dataInicio e $dataFim
        route('user.pedidos'),
        $feria->responsavel_id
    );

    // Retornar uma resposta ou redirecionamento
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

    public function updateDiasFerias(Request $request, $userId) {
        $request->validate([
            'dias_disponiveis' => 'required|integer|min:0',
        ]);
    
        $user = User::findOrFail($userId);
    
        $user->diasFerias()->updateOrCreate(
            ['user_id' => $user->id],
            ['dias_disponiveis' => $request->dias_disponiveis]
        );
    
        return back()->with('success', 'Dias de férias atualizados com sucesso.');
    }

    public function showDiasFeriasForm($userId)
    {
        // Obtendo o usuário específico
        $user = User::findOrFail($userId);

        // Carregando a view e passando o usuário
        return view('ferias.atribuir', compact('user'));
    }


    

    // Função para calcular os dias úteis solicitados
    public function diasSolicitados($dataInicio, $dataFim)
    {
        $dataInicio = Carbon::parse($dataInicio);
        $dataFim = Carbon::parse($dataFim);

        // Calcular a diferença de dias, desconsiderando finais de semana e feriados
        $diasSolicitados = 0;
        $feriados = Feriado::pluck('data')->toArray(); // Obter feriados

        while ($dataInicio->lte($dataFim)) {
            if (!$dataInicio->isWeekend() && !in_array($dataInicio->format('Y-m-d'), $feriados)) {
                $diasSolicitados++;
            }
            $dataInicio->addDay();
        }

        return $diasSolicitados;
    }
    

    // Função para calcular a data de retorno prevista
    public function calcularDataRetorno($dataInicio, $diasSolicitados) {
        $data = Carbon::parse($dataInicio);
        $feriados = Feriado::pluck('data')->toArray(); // Obtém feriados da tabela feriados
    
        $diasUteisContados = 0;
    
        // Loop para contar os dias úteis, excluindo finais de semana e feriados
        while ($diasUteisContados < $diasSolicitados) {
            $data->addDay();
    
            if (!$data->isWeekend() && !in_array($data->format('Y-m-d'), $feriados)) {
                $diasUteisContados++;
            }
        }
    
        return $data->format('Y-m-d');
    }

    public function aprovar($id)
    {
        $feria = Feria::findOrFail($id);

        // Atualiza o status para aprovado
        $feria->status = 'aprovado';
        $feria->save();

        // Remove o registro do banco de dados
        $feria->delete();

        NotificationController::criar(
            'aprovacao_pedido',
            'Pedido de Férias Aprovado',
            'Seu pedido de férias foi aprovado!',
            route('user.pedidos'),
            $user->id // ID do usuário que fez o pedido
        );
        

        return redirect()->route('user.pedidos')->with('success', 'Pedido de férias aprovado e excluído com sucesso.');
    }

    public function rejeitar($id)
    {
        $feria = Feria::findOrFail($id);

        // Atualiza o status para rejeitado
        $feria->status = 'rejeitado';
        $feria->save();

        // Remove o registro do banco de dados
        $feria->delete();

        return redirect()->route('user.pedidos')->with('success', 'Pedido de férias rejeitado e excluído com sucesso.');
        
}

}

