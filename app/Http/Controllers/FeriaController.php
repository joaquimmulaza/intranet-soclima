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
        $diasSolicitados = $feria->diasSolicitados();

        // Verificar dias úteis disponíveis (implementaremos essa lógica mais adiante)
        // Aqui você deve implementar a lógica para verificar se o usuário possui dias disponíveis

        // Criação do pedido de férias
        $feria = new Feria();
        $feria->user_id = Auth::id();
        $feria->responsavel_id = Auth::user()->responsavel_id; // O responsável atribuído ao usuário
        $feria->data_inicio = $request->data_inicio;
        $feria->data_fim = $request->data_fim;
        $feria->status = 'pendente'; // O status será "pendente" até ser aprovado pelo responsável

        // Implementação da data de retorno prevista
        $feria->data_retorno_prevista = $feria->calcularDataRetorno($feria->data_inicio, $diasSolicitados);

        $feria->save();

        // Aqui você pode implementar a notificação para o responsável

        return redirect()->route('ferias.index')->with('success', 'Pedido de férias solicitado com sucesso!');
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
}

