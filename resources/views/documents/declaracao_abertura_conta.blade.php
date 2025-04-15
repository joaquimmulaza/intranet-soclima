<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Declaração para Abertura de Conta</title>
    @php
        $path = public_path('logo/img/icon/papel.jpg'); // Caminho da imagem no disco
        $type = pathinfo($path, PATHINFO_EXTENSION); // Tipo da imagem (png, jpg, etc.)
        $data = file_get_contents($path); // Lê o conteúdo da imagem
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); // Gera a string Base64
    @endphp
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            background-image: url('{{ $base64 }}'); /* Aplica a imagem de fundo */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .container {
            width: 100%;
            max-width: 595pt; /* Largura A4 em pontos (210mm) */
            margin: 0 auto;
            padding: 40pt; /* Margens de ~14mm */
            box-sizing: border-box;
            min-height: 842pt; /* Altura A4 em pontos (297mm) */
        }
        .destinatario {
            text-align: left;
            margin-bottom: 30pt;
        }
        .title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30pt;
            text-decoration: underline;
        }
        .empresa, .corpo {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 15pt;
        }
        .rodape {
            margin-top: 30pt;
        }
        .data {
            text-align: left;
            margin-bottom: 30pt;
        }
        .direccao {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20pt;
        }
        .nerika {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Destinatário -->
        <div class="destinatario" style="font-weight: bold;">
            AO<br><br>
            <span style="text-transform: uppercase;">{{ $documentRequest->finalidade }}</span><br><br>
            <span style="text-decoration: underline;">LUANDA</span>
        </div>

        <!-- Cabeçalho -->
        <div class="title">DECLARAÇÃO</div>

        <!-- Informações da empresa -->
        <div class="empresa">
        <strong>SOCLIMA - Representações e Comercialização de Equipamentos de Ar Condicionados e Ventilação Lda</strong>., com sede na Avenida Samora Machel, S/N, Talatona em Luanda, NIF 5410002636:
        </div>

        <!-- Corpo do documento -->
        <div class="corpo">
                Para efeitos de 
                @if ($documentRequest->tipo_documento === 'Declaração para abertura de conta bancária')
                    abertura de conta bancária
                @elseif ($documentRequest->tipo_documento === 'Declaração para actualização de conta bancária')
                    actualização de conta bancária
                @else
                    abertura de conta bancária <!-- Fallback caso o tipo não seja esperado -->
                @endif, declara-se que o Sr. <strong>{{ $user->name }}</strong>, portador do Bilhete de Identidade nº {{ $user->numero_bi }}, é trabalhador desta Empresa, exercendo a função de {{ $user->cargo->titulo }} e auferindo um salário base de <strong>{{ $salarioBase }} AKZ</strong> <span style="text-transform: uppercase;">({{ $salarioBaseExtenso }})</span>.
            </div>

        <div class="corpo">
            Por ser verdade e nos ter sido solicitado, passou-se a presente declaração que vai devidamente assinada e autenticada com o carimbo a uso na nossa Empresa.
        </div>

        <!-- Rodapé -->
        <div class="rodape">
            <div class="data">{{ $dataCriacao }}</div>
            <div class="direccao">Direcção dos Recursos Humanos</div>
        </div>
    </div>
</body>
</html>