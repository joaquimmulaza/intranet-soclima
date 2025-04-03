<?php

namespace App\Http\Controllers;
use App\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

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
        $user = Auth::user();

        $document =  DocumentRequest::create([
            'user_id' => auth()->id(),
            'tipo_documento' => $validatedData['tipo_documento'],
            'finalidade' => $validatedData['finalidade'],
            'forma_entrega' => $validatedData['forma_entrega'],
            'prazo_entrega' => $validatedData['prazo_entrega'],
            'observacoes' => $validatedData['observacoes'],
            'status' => 'pendente',
        ]);

          // Notificar o admin
        NotificationController::criar(
            'documento_solicitado', 
            'Solicitação de Documento',
            '<strong>' . $user->name . '</strong>' . ' solicitou ' . $validatedData['tipo_documento'],
            route('documento-solicitado.show', ['id' => $document->id]), // Ajuste para a URL da justificativa
            User::where('role_id', '1')->first()->id // Notificar o admin
        );

        return back()->with('success', 'Pedido de documento enviado com sucesso.');
    }

    public function show($id)
    {
        // Encontra o documento solicitado e verifica se pertence ao usuário atual
        $documentRequest = DocumentRequest::findOrFail($id);

        // Verifica se o usuário atual é o proprietário do pedido
        // if ($documentRequest->user_id !== Auth::id()) {
        //     return back()->with('error', 'Você não tem permissão para visualizar este pedido.');
        // }

        // Retorna a view de detalhes do pedido de documento
        return view('document-request.showRequestDoc', [
            'documentRequest' => $documentRequest
        ]);
    }

    public function destroy($id)
    {
        // Encontra o documento solicitado
        $documentRequest = DocumentRequest::findOrFail($id);

        // Exclui o pedido de documento
        $documentRequest->delete();

        // Redireciona de volta com mensagem de sucesso
        return response()->json(['message' => 'Registro eliminado'], 200);
    }

    public function index()
    {
        $requests = DocumentRequest::where('user_id', Auth::id())
                                 ->latest()
                                 ->get();
                                 
        return view('document-request.employee', compact('requests'));
    }

    public function download($id)
    {
        $documentRequest = DocumentRequest::where('user_id', Auth::id())
                                        ->where('status', 'concluído')
                                        ->findOrFail($id);

        if (!$documentRequest->documento_path || !Storage::exists($documentRequest->documento_path)) {
            return back()->with('error', 'O documento solicitado não está disponível para download.');
        }

        $filename = basename($documentRequest->documento_path);
        $displayName = $documentRequest->tipo_documento . '_' . date('Y-m-d') . '.' . pathinfo($filename, PATHINFO_EXTENSION);

        return Storage::download($documentRequest->documento_path, $displayName);
    }
    
    /**
     * Anular (cancelar) pedido de documento
     */
    public function anular($id)
    {
        $documentRequest = DocumentRequest::where('user_id', Auth::id())
                                       ->findOrFail($id);

        // Verificação opcional para impedir cancelamento de documentos já concluídos
        if ($documentRequest->status === 'concluído') {
            return back()->with('error', 'Não é possível anular um pedido já concluído.');
        }

        $documentRequest->delete();

        return redirect()->route('documentos-solicitados.index')
                       ->with('success', 'Pedido anulado.');
    }
}
