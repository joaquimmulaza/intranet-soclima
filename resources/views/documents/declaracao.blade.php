<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Declaração</title>
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
    <br><br><br><br><br>
    <div class="container">
        <!-- Cabeçalho -->
        <div class="title">DECLARAÇÃO</div>

        <!-- Informações da empresa -->
        <div class="empresa">
            <strong>SOCLIMA - Representações e Comercialização de Equipamentos de Ar Condicionados e Ventilação Lda.,</strong> com sede na Avenida Samora Machel, S/N, Talatona em Luanda, NIF <strong>5410002636:</strong>
        </div>

        <!-- Corpo do documento -->
        <div class="corpo">
            Declara que para efeito de solicitação de visto, o Sr. <strong>{{ $user->name }}</strong>, natural de Portugal Setúbal, estado civil solteiro portador do Cartão de Residente nº <strong>000000T00</strong>, emitido aos 00 de Abril de 1900, é funcionário desta Empresa em efectivo serviço, admitido a {{ $dataAdmissao }}, com a categoria profissional de Eeeeeeeee e exercendo a função de {{ $user->cargo->titulo }}, auferindo o salário base de 000.000,00 AKZ (Cxxxx e Seeee e Seeee Mile Qaaaaaa e Oeeeee Kwanzas).
        </div>

        <div class="corpo">
            Por ser verdade e nos ter sido solicitado, para o efeito de concessão de visto de entrada em Portugal para a sua cunhada <strong>Jahbsbdjd</strong>, de nacionalidade Angolana, portadora do Bilhete de Identidade Nº 00000000LA000 e passaporte Nº 000000000, passou-se a presente declaração que vai devidamente assinada e autenticada com o carimbo a uso na nossa Empresa.
        </div>

        <!-- Rodapé -->
        <div class="rodape">
            <div class="data">{{ $dataCriacao }}</div>
            <div class="direccao">Direcção dos Recursos Humanos</div>
        </div>
    </div>
</body>
</html>