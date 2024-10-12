<?php

namespace App\Http\Controllers;

use App\Telefone; // Certifique-se de que você criou um modelo Telefone
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelefoneController extends Controller
{
    public function show($id)
    {
        // Se você não precisar exibir um item específico, pode simplesmente redirecionar ou deixar vazio
        return redirect()->route('telefones.index');
    }

    public function create()
    {
        return view('telefones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'funcao' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'nullable|email',
        ]);

        Telefone::create($validated);
        return redirect()->route('telefones.index')->with('success', 'Telefone adicionado com sucesso!');
    }

    public function index()
    {
        $telefones = Telefone::orderBy('departamento')->get();
        return view('telefones.index', compact('telefones'));
    }

    public function edit($id)
{
    $telefone = Telefone::findOrFail($id);
    return view('telefones.edit', compact('telefone'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nome' => 'required|string|max:255',
        'departamento' => 'required|string|max:255',
        'funcao' => 'required|string|max:255',
        'telefone' => 'required|string|max:15',
        'email' => 'nullable|email',
    ]);

    $telefone = Telefone::findOrFail($id);
    $telefone->update($validated);
    return redirect()->route('telefones.index')->with('success', 'Telefone atualizado com sucesso!');
}

public function destroy($id)
{
    $telefone = Telefone::findOrFail($id);
    $telefone->delete();
    return redirect()->route('telefones.index')->with('success', 'Telefone excluído com sucesso!');
}

}