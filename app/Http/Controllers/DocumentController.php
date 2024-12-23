<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'recipient' => 'required|string',
            'file' => 'required|file|max:2048',
            'description' => 'nullable|string',
        ]);

        // Salvar o arquivo
        $filePath = $request->file('file')->store('uploads', 'public');

        // Salvar no banco
        auth()->user()->documents()->create([
            'file_path' => $filePath,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'document_type' => $request->document_type,
            'recipient' => $request->recipient,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Documento enviado com sucesso.');
    }

    public function showDocuments()
    {
        $documents = Document::with('user') // Certifique-se de que há um relacionamento com o modelo User.
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('documents.show', compact('documents'));
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Remover o arquivo do armazenamento
        if (\Storage::disk('public')->exists($document->file_path)) {
            \Storage::disk('public')->delete($document->file_path);
        }

        // Remover do banco de dados
        $document->delete();

        return redirect()->route('documents.show')->with('success', 'Documento eliminado com sucesso.');
    }


}

