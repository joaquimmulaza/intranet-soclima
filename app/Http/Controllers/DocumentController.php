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
        Document::create([
            'file_path' => $filePath,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'document_type' => $request->document_type,
            'recipient' => $request->recipient,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Documento enviado com sucesso.');
    }
}

