<?php

namespace App\Http\Controllers;

use App\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\DocumentoEnviado;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use Dompdf\Dompdf;
use Dompdf\Options;
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
            'salario_base' => 'required|string|regex:/^\d+(\.\d{1,2})?(,\d{1,2})?$/',
        ]);

        $documentRequest = DocumentRequest::findOrFail($id);
        $user = $documentRequest->user;

        // Formatar as datas em português
        $dataAdmissao = $this->formatarDataPortugues($user->data_admissao);
        $dataCriacao = "Luanda, " . $this->formatarDataPortugues($documentRequest->created_at);

        // Selecionar a view com base no tipo de documento
        $viewName = 'documents.declaracao'; // Valor padrão (fallback)
        switch ($documentRequest->tipo_documento) {
            case 'Declaração para obtenção de visto':
                $viewName = 'documents.declaracao';
                break;
            case 'Declaração para abertura de conta bancária':
                $viewName = 'documents.declaracao_abertura_conta';
                break;
            case 'Declaração para actualização de conta bancária':
                $viewName = 'documents.declaracao_abertura_conta';
                break;
            case 'Declaração de trabalho':
                $viewName = 'documents.declaracao';
                break;
            case 'Declaração para obtenção de crédito bancário':
                $viewName = 'documents.declaracao';
                break;
            case 'Outros':
                $viewName = 'documents.declaracao';
                break;
            default:
                $viewName = 'documents.declaracao';
                break;
        }

        // Formatar o salário base
        $salarioBaseNumerico = (float)str_replace(',', '.', $validatedData['salario_base']);
        $salarioBase = number_format($salarioBaseNumerico, 2, ',', '.'); // Ex.: "500.000,00"
        $salarioBaseExtenso = $this->numeroPorExtenso($salarioBaseNumerico, true); // Ex.: "Quinhentos Mil Kwanzas"

        // Renderizar o HTML da view, passando o salário base (numérico e extenso)
        $html = view($viewName, compact('user', 'dataAdmissao', 'dataCriacao', 'documentRequest', 'salarioBase', 'salarioBaseExtenso'))->render();

        // Configurar o Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Salvar o PDF gerado temporariamente
        $tempPath = storage_path('app/public/documents/declaracao_' . $id . '.pdf');
        file_put_contents($tempPath, $dompdf->output());
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
            $this->adicionarAssinaturaAoPDF($tempPath, $fullSignedPath, $assinaturaPath, $documentRequest);
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
     * Formata a data em português (ex.: "01 de Agosto de 2021")
     */
    private function formatarDataPortugues($data)
    {
        $meses = [
            'January' => 'Janeiro', 'February' => 'Fevereiro', 'March' => 'Março',
            'April' => 'Abril', 'May' => 'Maio', 'June' => 'Junho',
            'July' => 'Julho', 'August' => 'Agosto', 'September' => 'Setembro',
            'October' => 'Outubro', 'November' => 'Novembro', 'December' => 'Dezembro'
        ];
        $dataFormatada = date('d \d\e F \d\e Y', strtotime($data));
        foreach ($meses as $en => $pt) {
            $dataFormatada = str_replace($en, $pt, $dataFormatada);
        }
        return $dataFormatada;
    }

    /**
     * Converte um número para o formato por extenso em português (ex.: 500000,00 -> "Quinhentos Mil Kwanzas").
     *
     * @param float $valor
     * @param bool $moeda
     * @return string
     */
    private function numeroPorExtenso($valor, $moeda = true)
    {
        $singular = ['Kwanza', 'Mil Kwanzas', 'Milhão de Kwanzas', 'Bilhão de Kwanzas'];
        $plural = ['Kwanzas', 'Mil Kwanzas', 'Milhões de Kwanzas', 'Bilhões de Kwanzas'];

        $c = ['','Cem','Duzentos','Trezentos','Quatrocentos','Quinhentos','Seiscentos','Setecentos','Oitocentos','Novecentos'];
        $d = ['','Dez','Vinte','Trinta','Quarenta','Cinquenta','Sessenta','Setenta','Oitenta','Noventa'];
        $d10 = ['Dez','Onze','Doze','Treze','Quatorze','Quinze','Dezesseis','Dezessete','Dezoito','Dezenove'];
        $u = ['','Um','Dois','Três','Quatro','Cinco','Seis','Sete','Oito','Nove'];

        $z = 0;
        $valor = number_format($valor, 2, '.', '');
        $inteiro = explode('.', $valor);
        $cont = count($inteiro);
        $rt = '';

        for ($i = 0; $i < $cont; $i++) {
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < $cont; $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "Cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000") $z++;
            elseif ($z > 0) $z--;

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if ($moeda) {
            $rt .= ' ';
            $decimal = $inteiro[$cont - 1];
            if ($decimal > 0) {
                $rt .= " e " . $this->numeroPorExtenso($decimal, false) . ($decimal > 1 ? " Centavos" : " Centavo");
            }
        }

        return trim(ucfirst(strtolower($rt)));
    }

    /**
     * Assina um PDF adicionando uma imagem de assinatura na última página
     */
    private function adicionarAssinaturaAoPDF($inputPath, $outputPath, $assinaturaPath, $documentRequest)
    {
        Log::info('Iniciando adicionarAssinaturaAoPDF', [
            'inputPath' => $inputPath,
            'outputPath' => $outputPath,
            'assinaturaPath' => $assinaturaPath,
            'tipo_documento' => $documentRequest->tipo_documento,
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

                    // Ajustar a posição vertical ($y) com base no tipo de documento
                    $y = $size['height'] - 106; // Valor padrão (~48 mm da borda inferior)
                    switch ($documentRequest->tipo_documento) {
                        case 'Declaração para obtenção de visto':
                            $y = $size['height'] - 106; // ~48 mm da borda inferior
                            break;
                        case 'Declaração para abertura de conta bancária':
                            $y = $size['height'] - 120; // ~40 mm da borda inferior
                            break;
                        case 'Declaração para actualização de conta bancária':
                            $y = $size['height'] - 120; // ~40 mm da borda inferior
                            break;
                        case 'Declaração de trabalho':
                            $y = $size['height'] - 106; // ~48 mm da borda inferior
                            break;
                        case 'Declaração para obtenção de crédito bancário':
                            $y = $size['height'] - 106; // ~48 mm da borda inferior
                            break;
                        case 'Outros':
                            $y = $size['height'] - 106; // ~48 mm da borda inferior
                            break;
                        default:
                            $y = $size['height'] - 106; // ~48 mm da borda inferior
                            break;
                    }

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

    public function downloadDocument($id)
{
    $documentRequest = DocumentRequest::findOrFail($id);

    if (!$documentRequest->documento_path || $documentRequest->status !== 'concluído') {
        return back()->with('error', 'Documento não disponível para download.');
    }

    $filePath = storage_path('app/public/' . $documentRequest->documento_path);

    if (!file_exists($filePath)) {
        return back()->with('error', 'Arquivo não encontrado.');
    }

    return response()->download($filePath, 'declaracao_' . $id . '.pdf');
}

    public function markAsComplete($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        $documentRequest->update(['status' => 'concluído']);

        return back()->with('success', 'Solicitação marcada como concluída.');
    }
}