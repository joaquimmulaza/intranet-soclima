<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    public function create()
    {
        return view('document-request.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required|string|max:255',
            'finalidade' => 'required|string|max:255',
            'forma_entrega' => 'required|string|in:email,fisica,intranet',
            'prazo_entrega' => 'required|date|after:today',
            'observacoes' => 'nullable|string',
        ]);

        // Aqui você pode salvar a solicitação na base de dados
        // Exemplo:
        $user = Auth::user();

        $user->documentRequests()->create([
            'tipo_documento' => $request->tipo_documento,
            'finalidade' => $request->finalidade,
            'forma_entrega' => $request->forma_entrega,
            'prazo_entrega' => $request->prazo_entrega,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->route('document-request.create')->with('success', 'Solicitação enviada com sucesso!');
    }
}
