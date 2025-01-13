<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ausencia;
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
    $ausencias = Ausencia::with('user')->get();  // ou você pode pegar as ausências para o usuário específico se necessário
    return view('documents.show', [
        'ausencias' => $ausencias,'document'
    ]);
}

    public function store(Request $request)
    {
        \Log::info('Tipo de Falta: ' . $request->input('tipo_falta'));

        \Log::info($request->all());

        $validated = $request->validate([
            'tipo_falta' => 'required|string',
            'tipo_registo' => 'required|string',
            'motivo' => 'nullable|string',
            'data_inicio' => 'required|date',
            'horas' => 'nullable|integer',
            'descontar_nas_ferias' => 'nullable|string|in:Sim,Não',
            'arquivo_comprovativo' => 'nullable',
        ]);

        // Salvar arquivo se enviado
        $path = null;
        if ($request->hasFile('arquivo_comprovativo')) {
            $path = $request->file('arquivo_comprovativo')->store('ausencias', 'public');
        }

        // Criar registro de ausência
        Ausencia::create([
            'user_id' => Auth::id(),
            'tipo_falta' => $validated['tipo_falta'], 
            'tipo_registo' => $validated['tipo_registo'],
            'motivo' => $validated['motivo'] ?? null,
            'data_inicio' => $validated['data_inicio'],
            'horas' => $validated['horas'] ?? null,
            'descontar_nas_ferias' => $validated['descontar_nas_ferias'] ?? null,
            'arquivo_comprovativo' => $path,
        ]);

        return redirect()->back()->with('success', 'Ausência registrada com sucesso.',);
    }

    public function destroy($id)
    {
       
        $document = Ausencia::findOrFail($id);

        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Documento não encontrado.');
        }

        // Excluir o arquivo do sistema
        Storage::disk('public')->delete($document->file_path);

        // Excluir o registro do banco de dados
        $document->delete();

        return redirect()->route('documents.show')->with('success', 'Documento eliminado com sucesso.');
    }
}