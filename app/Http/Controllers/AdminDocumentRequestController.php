<?php

namespace App\Http\Controllers;

use App\DocumentRequest;
use Illuminate\Http\Request;

class AdminDocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with('user')->latest()->paginate(10);
        return view('document-request.index', compact('requests'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);

        if ($request->hasFile('documento')) {
            $path = $request->file('documento')->store('documents');
            $documentRequest->update([
                'documento_path' => $path,
                'status' => 'concluído',
            ]);
        }

        return back()->with('success', 'Documento enviado com sucesso.');
    }

    public function markAsComplete($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);

        $documentRequest->update(['status' => 'concluído']);

        return back()->with('success', 'Solicitação marcada como concluída.');
    }
}