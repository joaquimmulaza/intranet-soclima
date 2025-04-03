<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Document;
use App\User;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('document-request.showSendDocs', compact('documents'));
    } 

    public function store(Request $request)
{

    // Validate the request
    $validated = $request->validate([
        'document_type' => 'required|string',
        'description' => 'nullable|string|max:200',
        'file' => 'required|file|max:2048',
    ]);

    // Check if user is authenticated
    if (!Auth::check()) {
        \Log::error('Usuário não autenticado');
        return response()->json(['message' => 'Usuário não autenticado'], 401);
    }

    $user = Auth::user();

    // Handle file upload
    if (!$request->hasFile('file')) {
        \Log::error('Nenhum arquivo enviado');
        return response()->json(['message' => 'Nenhum arquivo enviado'], 400);
    }

    try {
        $file = $request->file('file');
        $fileName = $user->name . '_documento_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $fileName, 'public');

        $document = Document::create([
            'user_id' => $user->id,
            'document_type' => $validated['document_type'],
            'recipient' => 'Recursos Humanos', // Hardcoded as in your form
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'file_name' => $fileName,
        ]);

         // Notificar o admin
         NotificationController::criar(
            'documento_enviado', 
            'Enviar documento',
            'Recebeste um documento de ' . '<strong>' . $user->name . '</strong>',
            route('documento-request.showSendDocs', ['id' => $document->id]), // Ajuste para a URL da justificativa
            User::where('role_id', '1')->first()->id // Notificar o admin
        );

        return response()->json([
            'message' => 'Documento enviado!',
            'document' => $document
        ], 201);

    } catch (\Exception $e) {
        \Log::error('Erro ao salvar documento: ' . $e->getMessage());
        return response()->json(['message' => 'Erro ao processar o documento'], 500);
    }
}
    
    

    public function showDocuments()
    {
        $documents = Document::with('user') // Certifique-se de que há um relacionamento com o modelo User.
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('document-request.showSendDocs', compact('documents'));
    }

    public function showDocuments2()
    {
        $user = auth()->user();
        $documents = Document::with('user') // Certifique-se de que há um relacionamento com o modelo User.
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('document-request.send', compact('documents', 'user'));
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

        return response()->json(['message' => 'Registro eliminado'], 200);
    }


}