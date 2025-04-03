<?php

namespace App\Http\Controllers;

use App\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\DocumentoEnviado;
use Illuminate\Support\Facades\Mail;


class AdminDocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with('user')->latest()->paginate(10);
        return view('document-request.index', compact('requests'));
    }

    public function uploadDocument(Request $request, $id)
    {
        

        $validatedData = $request->validate([
            'documento_path' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'observacoes_admin' => 'nullable|string|max:255',
        ]);
    
        $documentRequest = DocumentRequest::findOrFail($id);
        $user = $documentRequest->user; // Obtendo o usuário que fez a solicitação
    
        if ($request->hasFile('documento_path')) {
            $path = $request->file('documento_path')->store('documents');
    
            $documentRequest->update([
                'documento_path' => $path,
                'observacoes_admin' => $validatedData['observacoes_admin'] ?? null,
                'status' => 'concluído',
                'admin_id' => auth()->id(),
            ]);
    
            // Verifica se a forma de entrega é "E-mail"
            if ($documentRequest->forma_entrega === 'email') {
                Mail::to($documentRequest->user->email)->send(new DocumentoEnviado($documentRequest));
                 // Notificar o próprio usuário
                NotificationController::criar(
                    'upload_documento_solicitado', 
                    'Envio de documento solicitado',
                    '<strong>Recursos Humanos </strong> enviou um E-mail para si referente à sua solicitação.',
                    route('documentos-solicitados.index', ['id' => $documentRequest->id]), // Link para visualização
                    $user->id // Notificar o usuário que solicitou o documento
                );
            } else{
                 // Notificar o próprio usuário
                NotificationController::criar(
                    'upload_documento_solicitado', 
                    'Envio de documento solicitado',
                    '<strong>Recursos Humanos </strong> enviou para si um documento referente à sua solicitação.',
                    route('documentos-solicitados.index', ['id' => $documentRequest->id]), // Link para visualização
                    $user->id // Notificar o usuário que solicitou o documento
                );
            }
        }

        

    
        return back()->with('success', 'Ficheiro foi enviado.');
    }
    


    public function markAsComplete($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);

        $documentRequest->update(['status' => 'concluído']);

        return back()->with('success', 'Solicitação marcada como concluída.');
    }
}