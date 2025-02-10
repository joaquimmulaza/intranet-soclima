<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ausencia;
use App\User;
use App\Feria;
use App\DiasFerias;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AusenciaController extends Controller
{
    public function index()
    {
        // Exibe o formulário de ausência
        $ausencias = Ausencia::with('user')->get();
        
    
        $id = auth()->id();
        return view('documents.index', [
            'id' => $id,
            'ausencias' => $ausencias,
        ]);
    }

    public function show($id)
{
    $ausencias = Ausencia::with('user')->orderBy('created_at', 'desc')->get();// ou você pode pegar as ausências para o usuário específico se necessário
    $tipo_falta = $ausencias->first()->tipo_falta ?? null;
    
    return view('documents.show', [
        'ausencias' => $ausencias,'document',
        'tipo_falta' => $tipo_falta,
    ]);
}

public function showById($id)
{
    // Busca a ausência pelo ID, com os dados do usuário relacionado
    $ausencia = Ausencia::with('user')->findOrFail($id);
    $ausencia->data_inicio = Carbon::parse($ausencia->data_inicio);

    // Retorna a view para exibir os detalhes de uma ausência específica
    return view('documents.visualizar', [
        'ausencia' => $ausencia,
    ]);
}


    public function store(Request $request)
    {
        \Log::info('Tipo de Falta: ' . $request->input('tipo_falta'));

        \Log::info($request->all());

        $validated = $request->validate([
            'tipo_falta' => 'required|string',
            'tipo_registo' => 'required|string',
            'motivo' => 'required|string',
            'data_inicio' => 'required|date|before_or_equal:today',
            'horas' => 'nullable|integer',
            'descontar_nas_ferias' => 'nullable|string|in:Sim,Não',
            'arquivo_comprovativo' => 'nullable',
        ],[
            'data_inicio.required' => 'Por favor, preencha este campo.',
            'data_inicio.date' => 'Data inválida.',
            'motivo.required' => 'Por favor, preencha este campo.',
        ]);

        $user = Auth::user();

        // Salvar arquivo se enviado
        $path = null;
        if ($request->hasFile('arquivo_comprovativo')) {
            $fileName = $user->name . '_' . 'justificativos'. '.'. $request->file('arquivo_comprovativo')->getClientOriginalExtension();
            $path = $request->file('arquivo_comprovativo')->storeAs('ausencias', $fileName, 'public');
        }

        // Gera o URL público
        $publicUrl = $path ? Storage::url($path) : null;

        // Criar registro de ausência
        $novaAusencia = Ausencia::create([
            'user_id' => Auth::id(),
            'tipo_falta' => $validated['tipo_falta'], 
            'tipo_registo' => $validated['tipo_registo'],
            'motivo' => $validated['motivo'] ?? null,
            'data_inicio' => $validated['data_inicio'],
            'horas' => $validated['horas'] ?? null,
            'descontar_nas_ferias' => $validated['descontar_nas_ferias'] ?? null,
            'arquivo_comprovativo' => $path,
            'status' => 'Pendente', // Status inicial
            'observacao' => null,   // Inicialmente sem observação
        ]);

         // Notificar o próprio usuário
        NotificationController::criar(
            'justificativa', 
            'Justificativo Enviado',
            'O seu justificativo foi enviado e está em revisão pelo Departamento de Recursos Humanos.',
            route('documents.visualizar', ['id' => $novaAusencia->id]), // Link para visualização
            $user->id // Notificar o usuário que criou o justificativo
        );

         // Notificar o admin
        NotificationController::criar(
            'justificativa', 
            'Solicitação',
            $user->name . ' Enviou um justificativo',
            route('documents.visualizar', ['id' => $novaAusencia->id]), // Ajuste para a URL da justificativa
            User::where('role_id', '1')->first()->id // Notificar o admin
        );

       
        return redirect()->back()->with('success', 'Justificativo Enviado');

        
    }

    public function aprovarRejeitar($id, Request $request)
    {

        $ausencia = Ausencia::findOrFail($id);

        // Validar a entrada do status (aprovada ou rejeitada) e a observação
    
        $ausencia->update([
            'status' => $request->status,
            'observacao' => $request->observacao ?? $ausencia->observacao,
            'descontar_nas_ferias' => $request->descontar_nas_ferias ?? $ausencia->descontar_nas_ferias, // Mantém o valor
        ]);


        // Atualizar o status e a observação
        $ausencia->status = $request['status'];
        $ausencia->observacao = $request['observacao'] ?? null;
        $ausencia->descontar_nas_ferias = $request['descontar_nas_ferias'] ?? null;
         // A observação será opcional
        $ausencia->save();

        // Criar a mensagem da notificação com base no status e na observação
        $mensagem = '';

        if ($ausencia->status == 'Pendente') {
            $mensagem = 'O seu justificativo foi enviado e está em revisão pelo Departamento de Recursos Humanos.';
        } elseif ($ausencia->status == 'Rejeitado') {
            if ($ausencia->observacao) {
                $mensagem = '<strong>Recursos Humanos</strong> rejeitou e adicionou uma observação à sua justificação de falta: "' . $ausencia->observacao . '"';
            } else {
                $mensagem = '<strong>Recursos Humanos</strong> rejeitou o seu justificativo de falta.';
            }
        } elseif ($ausencia->status == 'Aprovado') {
            if ($ausencia->observacao) {
                $mensagem = '<strong>Recursos Humanos</strong> aprovou e adicionou uma observação à sua justificação de falta: "' . $ausencia->observacao . '"';
            } else {
                $mensagem = '<strong>Recursos Humanos</strong> aprovou o seu justificativo de falta.';
            }
        }

        // Notificar o solicitante sobre a decisão
        NotificationController::criar(
            'justificativa', 
            'Aprovação',
            $mensagem,
            route('documents.visualizar', ['id' => $ausencia->id]),
            // route('ausencias.show', ['id' => $ausencia->id]),
            $ausencia->user_id // Notificar o solicitante
        );

        
      
        if ($request['status'] == 'Rejeitado') {
            return redirect()->route('documents.show')->with([
                'error' => 'Comprovativo rejeitado',
            ]);
        }

        \Log::info('Status atualizado para: ' . $ausencia->status);
        \Log::info('Descontar nas férias: ' . ($request['descontar_nas_ferias'] ?? 'Nao'));

        if ($request['status'] == 'Aprovado' && ($request['descontar_nas_ferias'] ?? 'Nao') == 'Sim') {
            FeriaController::descontarFeria($ausencia->user_id, 1);
        }
        

    // Agora o redirecionamento acontece apenas no final
    return redirect()->route('documents.show')->with([
        $request['status'] == 'Aprovado' ? 'success' : 'error' => 
        $request['status'] == 'Aprovado' ? 'Comprovativo aprovado' : 'Comprovativo rejeitado'
    ]);
    }


    public function downloadFile($id)
    {
        $ausencia = Ausencia::findOrFail($id);
        $file = storage_path('app/public/' . $ausencia->arquivo_comprovativo);

        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect()->route('documents.index')->with('error', 'Arquivo não encontrado.');
        }
    }


    public function destroy($id)
    {
        // Encontrar o documento ou retornar um erro 404
        $document = Ausencia::findOrFail($id);
    
        // Excluir o arquivo do sistema
        Storage::disk('public')->delete($document->file_path);
    
        // Excluir o registro do banco de dados
        $document->delete();
    
        // Retornar uma resposta JSON de sucesso
        return response()->json(['message' => 'Justificativo apagado'], 200);
    }
    
}