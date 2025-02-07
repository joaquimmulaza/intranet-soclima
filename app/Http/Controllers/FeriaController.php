<?php
namespace App\Http\Controllers;

use App\Mail\FeriaSolicitadaMail;
use App\Mail\FeriaAprovadaOuReprovadaMail;
use Illuminate\Support\Facades\Mail;
use App\Feria;
use App\Feriado;
use App\User;
use App\DiasFerias;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user(); // Obtém o usuário logado
        $anoDesconto = $user->diasFerias()
            ->where('dias_disponiveis', '>', 0)
            ->orderBy('ano', 'asc')
            ->value('ano');

        return view('ferias.marcar', compact('user', 'anoDesconto'));
    }

    public function diasSolicitados($dataInicio, $dataFim)
    {
        $dataInicio = Carbon::parse($dataInicio);
        $dataFim = Carbon::parse($dataFim);

        Log::info("Calculando dias úteis de {$dataInicio->format('Y-m-d')} até {$dataFim->format('Y-m-d')}");
        
        // Calcular a diferença de dias úteis entre dataInicio e dataFim
        $diasSolicitados = 0;
        $feriados = Feriado::pluck('data')->toArray(); // Obter feriados cadastrados
        
        // Loop para contar os dias úteis
        while ($dataInicio->lte($dataFim)) {
            if ($dataInicio->isWeekend()) {
                Log::warning("Data é fim de semana: " . $dataInicio->toDateString());
            } elseif (in_array($dataInicio->format('Y-m-d'), $feriados)) {
                Log::warning("Data é feriado: " . $dataInicio->toDateString());
            } else {
                $diasSolicitados++;
            }
            $dataInicio->addDay(); // Avançar para o próximo dia
        }
        Log::info("Total de dias úteis contados: $diasSolicitados");

        Log::info("Total de dias úteis contados: $diasSolicitados");
    
        return $diasSolicitados;
    }

    public function calcularFeriasAnoAdmissao(User $user)
    {
        // Obter a data de admissão do usuário
        $dataAdmissao = Carbon::parse($user->data_admissao);
        $dataAtual = Carbon::now();  // Data atual

        // Calcular a diferença em meses completos
        $mesesTrabalhados = $dataAdmissao->diffInMonths($dataAtual);

        // Calcular os dias de férias proporcionais
        $diasFeriasProporcionais = max(6, $mesesTrabalhados * 2);  // 2 dias úteis por mês, mínimo 6 dias

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

    public function calcularDataRetorno($dataInicio, $diasSolicitados)
    {
        \Log::info("Data de Início: {$dataInicio}");
        \Log::info("Calculando data de retorno com base em {$dataInicio} e {$diasSolicitados} dias.");
        // Definindo a data de início e data fim
        $dataInicio = Carbon::parse($dataInicio);
        $diasRestantes = $diasSolicitados;

        // Adicionando log
       

        // Itera até que a data de retorno caia no dia útil correto
        while ($diasRestantes > 0) {
            $dataInicio->addDay();
            if ($dataInicio->isWeekend()) {
                \Log::warning("Data de retorno caiu em fim de semana: " . $dataInicio->toDateString());
            } elseif ($this->isFeriado($dataInicio)) {
                \Log::warning("Data de retorno caiu em feriado: " . $dataInicio->toDateString());
            } else {
                $diasRestantes--;
            }
        }

        \Log::info("Data de retorno calculada: {$dataInicio->toDateString()}");

        return $dataInicio->toDateString();
    }

    private function isFeriado(Carbon $data)
    {
        $feriados = Feriado::pluck('data')->toArray();
        return in_array($data->format('Y-m-d'), $feriados);
    }


    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $dataInicio = Carbon::parse($request->data_inicio);
        $dataFim = Carbon::parse($request->data_fim);
        $user = Auth::user();

        // Verifica se a data de início ou fim já existe em outro pedido de férias (pendente ou aprovado)
            $conflitoFérias = Feria::whereIn('status', ['pendente', 'aprovado'])  // Verifica pendente ou aprovado
            ->where(function($query) use ($dataInicio, $dataFim) {
                $query->whereBetween('data_inicio', [$dataInicio, $dataFim])
                    ->orWhereBetween('data_fim', [$dataInicio, $dataFim])
                    ->orWhere(function($query) use ($dataInicio, $dataFim) {
                        $query->where('data_inicio', '<=', $dataFim)
                                ->where('data_fim', '>=', $dataInicio);
                    });
            })
            ->exists();

        if ($conflitoFérias) {
        return redirect()->back()->withErrors('Já existem férias marcadas para este período.');
        }

         // Verifica se a data de início é um final de semana ou feriado
        if ($dataInicio->isWeekend()) {
            return redirect()->back()->withErrors("O período selecionado inclui sábado e/ou domingo, que não são considerados dias úteis de férias. Por favor, selecione só dias úteis.");
        }
        if ($this->isFeriado($dataInicio)) {
            return redirect()->back()->withErrors("A data de início não pode ser um feriado.");
        }

        // Verifica se a data de fim é um final de semana ou feriado
        if ($dataFim->isWeekend()) {
            return redirect()->back()->withErrors("O período selecionado inclui sábado e/ou domingo, que não são considerados dias úteis de férias. Por favor, selecione só dias úteis.");
        }
        if ($this->isFeriado($dataFim)) {
            return redirect()->back()->withErrors("A data de fim não pode ser um feriado.");
        }

        // Verifica a data de admissão e a data de início do pedido de férias
        $dataAdmissao = Carbon::parse($user->data_admissao); // Supondo que a data de admissão esteja no campo 'data_admissao'
        $diferencaMeses = $dataAdmissao->diffInMonths($dataInicio);

        // Verifica se o usuário tem pelo menos 6 meses de trabalho
        if ($diferencaMeses < 6) {
            return redirect()->back()->withErrors("Você precisa completar pelo menos 6 meses de trabalho efetivo para solicitar férias.");
        }

         // Calcular os dias solicitados
        $diasSolicitados = $this->diasSolicitados($dataInicio, $dataFim);

        // Buscar todos os anos com saldo de férias para o usuário
        $anosFerias = $user->diasFerias()->where('dias_disponiveis', '>', 0)->get();

        // Calcular o saldo total de férias disponível
        $saldoTotal = 0;
        foreach ($anosFerias as $ano) {
            $saldoTotal += $ano->dias_disponiveis;
        }

        // Verifica se há saldo suficiente de férias para o período solicitado
        if ($diasSolicitados > $saldoTotal) {
            return redirect()->back()->withErrors("Você não tem saldo suficiente de férias para este período.");
        }
        
        // Verifica o ano de referência das férias
        $anoReferencia = $dataInicio->year - 1; // Ano de trabalho referente às férias
        $diasFerias = $user->diasFerias()->where('ano', $anoReferencia)->first();
        
        // Se não houver saldo de férias no ano anterior, verifica o saldo do ano atual
        if (!$diasFerias || $diasFerias->dias_disponiveis <= 0) {
            $anoReferencia = $dataInicio->year; // Usar o ano atual
            $diasFerias = $user->diasFerias()->where('ano', $anoReferencia)->first();
        }
     

        // Criação do pedido de férias
        $diasRestantes = $diasSolicitados;
        $feria = new Feria();
        $feria->user_id = Auth::id();
        $feria->responsavel_id = Auth::user()->responsavel_id;
        $feria->data_inicio = $dataInicio;
        $feria->data_fim = $dataFim;
        $feria->status = 'pendente';
        $feria->data_retorno_prevista = Carbon::parse($feria->calcularDataRetorno($dataInicio, $diasSolicitados))->format('Y-m-d');

        // Variável temporária para armazenar os dias usados
        $diasUsadosDistribuidos = [];

        // Distribui os dias entre os anos
        foreach ($anosFerias as $ano) {
            if ($diasRestantes > 0) {
                // Calcular os dias a serem usados deste ano
                $diasUsados = min($ano->dias_disponiveis, $diasRestantes);
                $diasRestantes -= $diasUsados;

                // Armazenar os dias usados na variável temporária
                $diasUsadosDistribuidos[] = ['ano' => $ano->ano, 'dias_usados' => $diasUsados];
            }
        }

        $feria->save();
        $UserName = Auth::user()->name; 

        // Atualizar o saldo de dias disponíveis
    

        Log::info("Antes do desconto: {$diasFerias->dias_disponiveis} dias disponíveis.");
        $diasFerias->dias_disponiveis -= $diasSolicitados;
        Log::info("Depois do desconto: {$diasFerias->dias_disponiveis} dias disponíveis.");
        

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

       
        return redirect()->route('ferias.marcar')->with('success', 'Solicitação de férias enviada.');
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
    
        return redirect()->route('ferias.index')->with('success', 'Sucesso!');
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

        return redirect()->back()->with('success', 'Dias atribuido');
    }

    public function showDiasFeriasForm($userId)
    {
        // Obtendo o usuário específico
        $user = User::findOrFail($userId);

        // Carregando a view e passando o usuário
        return view('ferias.atribuir', compact('user'));
    }

    
 
    public function aprovar($id)
{
    $feria = Feria::findOrFail($id);
    $user = $feria->user;

    // Buscar todos os anos com saldo de férias para o usuário (inclusive o ano anterior)
    $anosFerias = $user->diasFerias()->where('dias_disponiveis', '>', 0)->orderBy('ano')->get();

    // Obter o total de dias solicitados para as férias
    $diasSolicitados = $this->diasSolicitados($feria->data_inicio, $feria->data_fim);
    $diasRestantes = $diasSolicitados;

    // Variável temporária para armazenar os dias usados distribuídos
    $diasUsadosDistribuidos = [];

    
    // 1. Desconta primeiro dos anos mais antigos disponíveis
    foreach ($anosFerias as $ano) {
        if ($diasRestantes > 0) {
            $diasUsados = min($ano->dias_disponiveis, $diasRestantes);
            $diasRestantes -= $diasUsados;

            // Armazenar os dias usados por ano
            $diasUsadosDistribuidos[] = ['ano' => $ano->ano, 'dias_usados' => $diasUsados];

            // Se não há mais dias a descontar, sai do loop
            if ($diasRestantes <= 0) {
                break;
            }
        }
    }

    // 2. Depois, tenta descontar os dias restantes no ano atual
    foreach ($anosFerias as $ano) {
        if ($diasRestantes > 0) {
            // Se o ano for o atual
            if ($ano->ano == Carbon::parse($feria->data_inicio)->year) {
                $diasUsados = min($ano->dias_disponiveis, $diasRestantes);
                $diasRestantes -= $diasUsados;

                // Armazenar os dias usados no ano atual
                $diasUsadosDistribuidos[] = ['ano' => $ano->ano, 'dias_usados' => $diasUsados];
            }
        }
    }

    // 3. Agora, vamos iterar sobre os anos e descontar os dias usados
    foreach ($diasUsadosDistribuidos as $diasUsadosPorAno) {
        // Encontre o ano correspondente
        $ano = $anosFerias->where('ano', $diasUsadosPorAno['ano'])->first();

        // Verifique se o ano foi encontrado e se há saldo suficiente
        if ($ano && $ano->dias_disponiveis >= $diasUsadosPorAno['dias_usados']) {
            // Subtrair os dias usados
            $ano->dias_disponiveis -= $diasUsadosPorAno['dias_usados'];
            $ano->save();
        } else {
            return redirect()->back()->withErrors("Erro: Saldo insuficiente para aprovar as férias.");
        }
    }

    // Atualiza o status da solicitação de férias para aprovado
    $feria->status = 'aprovado';
    $feria->save();

    // Enviar e-mail para o funcionário
    Mail::send(new FeriaAprovadaOuReprovadaMail($user, $feria, 'aprovada'));

    // Criar notificação para o usuário
    $responsavelNome = Auth::user()->name;
    $notificationController = app(NotificationController::class);
    $notificationController->criar(
        'aprovacao_pedido',
        'Pedido de Férias Aprovado',
        'Seu pedido de férias foi aprovado por <strong>' . $responsavelNome . '</strong>.',
        route('user.pedidos'),
        $feria->user_id
    );

    // Redirecionar com sucesso
    return redirect()->route('user.pedidos')->with('success', 'Férias Aprovadas');
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


        return redirect()->route('user.pedidos')->with('success', 'Ferias Rejeitadas');
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

    // Buscar os dados de férias do funcionário com ordenação
    $ferias = Feria::where('user_id', $id)
        ->where('status', 'Aprovado')  // Filtra apenas férias aprovadas
        ->orderBy('data_inicio', 'desc') // Ordena pela data de início mais recente
        ->get();  // Executa a consulta
// Obter os dias de férias anuais atualizados
$feriasAnuais = $funcionario->diasFerias->dias_disponiveis ?? 22; // Usa o valor da relação ou 22 como padrão

// Pega a férias mais recente em curso, baseada na data de início

$diasAcumulados = DB::table('dias_ferias')
        ->where('user_id', $funcionario->id)
        ->where('ano', '<', now()->year)
        ->sum('dias_disponiveis');

$feriasAtual = $ferias
    ->where('data_inicio', '<=', now())  // Já começou
    ->where('data_fim', '>=', now())    // Ainda não terminou
    ->first();                         // Pega a mais recente (em curso)

// Se não houver férias em curso, pegar a próxima férias futura
if (!$feriasAtual) {
    $feriasAtual = $ferias
        ->where('data_inicio', '>', now())  // Férias que ainda não começaram
        ->sortBy(function ($feria) {
            return \Carbon\Carbon::parse($feria->data_inicio);  // Ordena pela data de início, convertendo para Carbon
        })
        ->first();                          // Pega a mais próxima
}

$feriasGozadas = 0;
$feriasRestantes = 0;
$totalDiasFerias = 0;

if ($feriasAtual) {
    // Definir datas relevantes
    $dataInicio = $feriasAtual->data_inicio;
    $dataFim = $feriasAtual->data_fim;
    $dataAtual = now();

    // Dias já aproveitados (do início até hoje)
    $feriasGozadas = $this->diasSolicitados($dataInicio, min($dataAtual, $dataFim));

    // Total de dias dessa férias
    $totalDiasFerias = $this->diasSolicitados($dataInicio, $dataFim);

    // Dias restantes (total - já usados)
    $feriasRestantes = max($totalDiasFerias - $feriasGozadas, 0);
}

// Calcular os dias de férias restantes
$feriasRestantes = max($feriasAnuais - $feriasGozadas, 0);



    // Formatar os períodos de férias para exibição
    $historicoFerias = $ferias->reverse()->map(function ($feria, $index) {
        return [
            'periodo' => $index + 1,
            'data_inicio' => Carbon::parse($feria->data_inicio)->format('d/m/Y'),
            'data_fim' => Carbon::parse($feria->data_fim)->format('d/m/Y'),
            'data_retorno' => Carbon::parse($feria->data_retorno_prevista)->format('d/m/Y'), // Data de retorno prevista
        ];
    });
    

    // Enviar os dados para a view
    return view('ferias.show', compact('funcionario', 'feriasAnuais', 'feriasGozadas', 'feriasRestantes', 'historicoFerias', 'totalDiasFerias', 'diasAcumulados', 'id'));
}

}