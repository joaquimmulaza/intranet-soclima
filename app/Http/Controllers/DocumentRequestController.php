<?php

namespace App\Http\Controllers;
use App\DocumentRequest;
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
        $validatedData = $request->validate([
            'tipo_documento' => 'required|string|max:255',
            'finalidade' => 'nullable|string',
            'forma_entrega' => 'required|in:email,fisica,intranet', // Validando os valores possíveis
            'prazo_entrega' => 'required|date',
            'observacoes' => 'nullable|string',
        ]);

        DocumentRequest::create([
            'user_id' => auth()->id(),
            'tipo_documento' => $validatedData['tipo_documento'],
            'finalidade' => $validatedData['finalidade'],
            'forma_entrega' => $validatedData['forma_entrega'],
            'prazo_entrega' => $validatedData['prazo_entrega'],
            'observacoes' => $validatedData['observacoes'],
            'status' => 'pendente',
        ]);

        return back()->with('success', 'Pedido de documento enviado com sucesso.');
    }
}
