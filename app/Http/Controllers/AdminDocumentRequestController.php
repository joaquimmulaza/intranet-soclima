<?php

namespace App\Http\Controllers;

use App\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\DocumentoEnviado;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use FPDF; // Biblioteca para criar PDFs
use Carbon\Carbon;

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
            'observacoes_admin' => 'nullable|string|max:255',
        ]);

        $documentRequest = DocumentRequest::findOrFail($id);
        $user = $documentRequest->user;

        // Gerar o PDF com os dados do usuário
        $pdf = new FPDF('P', 'pt', 'A4'); // P = retrato, pt = pontos, A4 = 595x842 pontos
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);

        // Cabeçalho
        $pdf->Cell(0, 20, 'DECLARAÇÃO', 0, 1, 'C');
        $pdf->Ln(10);

        // Informações da empresa
        $pdf->SetFont('Times', '', 12);
        $empresaTexto = "SOCLIMA - Representações e Comercialização de Equipamentos de Ar Condicionados e Ventilação Lda., com sede na Avenida Samora Machel, S/N, Talatona em Luanda, NIF 5410002636:";
        $pdf->MultiCell(0, 15, utf8_decode($empresaTexto), 0, 'J');
        $pdf->Ln(10);

        // Corpo do documento com dados do usuário
        $corpoTexto = "Declara que para efeito de solicitação de visto, o Sr. " . utf8_decode($user->name) . ", natural de Portugal Setúbal, estado civil do Cartão de Residente nº 000000T00, emitido aos 00 de Abril de 1900, é funcionário desta Empresa em efectivo serviço, admitido a " . date('d \d\e F \d\e Y', strtotime($user->data_admissao)) . ", com a categoria profissional de Eeeeeeeee e exercendo a função de " . utf8_decode($user->cargo->titulo) . ", auferindo o salário base de 000.000,00 AKZ (Cxxxx e Seeee e Seeee Mile Qaaaaaa e Oeeeee Kwanzas).";
        $pdf->MultiCell(0, 15, utf8_decode($corpoTexto), 0, 'J');
        $pdf->Ln(10);

        $corpoTexto2 = "Por ser verdade e nos ter sido solicitado, para o efeito de concessão de visto de entrada em Portugal para a sua cunhada Jahbsbdjd, de nacionalidade Angolana, portadora do Bilhete de Identidade Nº 00000000LA000 e passaporte Nº 000000000, passou-se a presente declaração que vai devidamente assinada e autenticada com o carimbo a uso na nossa Empresa.";
        $pdf->MultiCell(0, 15, utf8_decode($corpoTexto2), 0, 'J');
        $pdf->Ln(20);

        // Rodapé
        setlocale(LC_TIME, 'pt_BR.UTF-8');
        $dataTexto = "Luanda, " . Carbon::parse($documentRequest->created_at)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY');
        $pdf->Cell(0, 15, utf8_decode($dataTexto), 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->Cell(0, 15, utf8_decode('Direcção dos Recursos Humanos'), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 15, utf8_decode('_________________________'), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 15, utf8_decode('Nerika Costa'), 0, 1, 'C');

        // Salvar o PDF gerado temporariamente
        $tempPath = storage_path('app/public/documents/declaracao_' . $id . '.pdf');
        $pdf->Output($tempPath, 'F');
        Log::info('PDF gerado', ['tempPath' => $tempPath]);

        // Caminho do PDF assinado
        $signedPath = 'documents/signed_declaracao_' . $id . '.pdf';
        $fullSignedPath = storage_path('app/public/' . $signedPath);
        Log::info('Caminho do PDF assinado', ['fullSignedPath' => $fullSignedPath]);

        // Caminho da assinatura
        $assinaturaPath = storage_path('app/public/documents/assinatura.png');
        Log::info('Caminho da assinatura', ['assinaturaPath' => $assinaturaPath]);

        if (!file_exists($assinaturaPath)) {
            Log::error('Imagem da assinatura não encontrada', ['assinaturaPath' => $assinaturaPath]);
            return back()->with('error', 'Erro: Imagem da assinatura não encontrada.');
        }

        // Adicionar a assinatura ao PDF gerado
        try {
            $this->adicionarAssinaturaAoPDF($tempPath, $fullSignedPath, $assinaturaPath);
            Log::info('Assinatura adicionada com sucesso ao PDF', ['fullSignedPath' => $fullSignedPath]);
        } catch (\Exception $e) {
            Log::error('Erro ao adicionar assinatura', ['message' => $e->getMessage()]);
            return back()->with('error', 'Erro ao adicionar a assinatura: ' . $e->getMessage());
        }

        // Verificar se o PDF assinado foi criado
        if (!file_exists($fullSignedPath)) {
            Log::error('PDF assinado não foi criado', ['fullSignedPath' => $fullSignedPath]);
            return back()->with('error', 'Erro: O PDF assinado não foi criado.');
        }

        // Atualizar o banco de dados com o caminho do PDF assinado
        $documentRequest->update([
            'documento_path' => $signedPath,
            'observacoes_admin' => $validatedData['observacoes_admin'] ?? null,
            'status' => 'concluído',
            'admin_id' => auth()->id(),
        ]);
        Log::info('Registro atualizado', ['documento_path' => $signedPath]);

        // Envio de e-mail + notificação
        if ($documentRequest->forma_entrega === 'email') {
            try {
                Mail::to($user->email)->send(new DocumentoEnviado($documentRequest));
                Log::info('E-mail enviado', ['email' => $user->email]);
            } catch (\Exception $e) {
                Log::error('Erro ao enviar e-mail', ['message' => $e->getMessage()]);
            }

            NotificationController::criar(
                'upload_documento_solicitado',
                'Envio de documento solicitado',
                '<strong>Recursos Humanos </strong> enviou um E-mail para si referente à sua solicitação.',
                route('documentos-solicitados.index', ['id' => $documentRequest->id]),
                $user->id
            );
        } else {
            NotificationController::criar(
                'upload_documento_solicitado',
                'Envio de documento solicitado',
                '<strong>Recursos Humanos </strong> enviou para si um documento referente à sua solicitação.',
                route('documentos-solicitados.index', ['id' => $documentRequest->id]),
                $user->id
            );
        }

        return back()->with('success', 'Documento gerado e assinado com sucesso.');
    }

    /**
     * Assina um PDF adicionando uma imagem de assinatura na última página
     */
    private function adicionarAssinaturaAoPDF($inputPath, $outputPath, $assinaturaPath)
    {
        Log::info('Iniciando adicionarAssinaturaAoPDF', [
            'inputPath' => $inputPath,
            'outputPath' => $outputPath,
            'assinaturaPath' => $assinaturaPath,
        ]);

        $inputPath = str_replace('\\', '/', $inputPath);

        if (!file_exists($inputPath)) {
            Log::error('Arquivo de entrada não existe', ['inputPath' => $inputPath]);
            throw new \Exception('O ficheiro de entrada não existe: ' . $inputPath);
        }

        if (!is_readable($inputPath)) {
            Log::error('Arquivo de entrada não é legível', ['inputPath' => $inputPath]);
            throw new \Exception('O ficheiro de entrada não é legível: ' . $inputPath);
        }

        if (!file_exists($assinaturaPath)) {
            Log::error('Imagem da assinatura não existe', ['assinaturaPath' => $assinaturaPath]);
            throw new \Exception('Imagem da assinatura não existe: ' . $assinaturaPath);
        }

        if (!is_readable($assinaturaPath)) {
            Log::error('Imagem da assinatura não é legível', ['assinaturaPath' => $assinaturaPath]);
            throw new \Exception('Imagem da assinatura não é legível: ' . $assinaturaPath);
        }

        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile(StreamReader::createByFile($inputPath));
            Log::info('Número de páginas no PDF', ['pageCount' => $pageCount]);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $template = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($template);
                Log::info('Processando página', [
                    'pageNo' => $pageNo,
                    'orientation' => $size['orientation'],
                    'width' => $size['width'],
                    'height' => $size['height'],
                ]);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($template);

                if ($pageNo === $pageCount || $pageCount === 1) {
                    $signatureWidth = 60; // ~21 mm
                    $signatureHeight = 30; // ~10 mm
                    $x = ($size['width'] - $signatureWidth) / 2; // Centraliza horizontalmente
                    $y = $size['height'] - 206; // ~48 mm da borda inferior
                    Log::info('Adicionando assinatura', [
                        'pageNo' => $pageNo,
                        'x' => $x,
                        'y' => $y,
                        'width' => $signatureWidth,
                        'height' => $signatureHeight,
                    ]);
                    $pdf->Image($assinaturaPath, $x, $y, $signatureWidth, $signatureHeight);
                }
            }

            $pdf->Output($outputPath, 'F');
            Log::info('PDF assinado salvo', ['outputPath' => $outputPath]);
        } catch (\Exception $e) {
            Log::error('Erro ao processar PDF', ['message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function markAsComplete($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        $documentRequest->update(['status' => 'concluído']);

        return back()->with('success', 'Solicitação marcada como concluída.');
    }
}