<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipoDocumento }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Saudações, {{ $nomeUsuario }}!</h2>
    <p>Segue abaixo o link para download do documento solicitado.</p>

    <a href="{{ $linkDownload }}" style="display: inline-block; padding: 10px 20px; margin: 20px 0; background-color: #009AC1; color: #fff; text-decoration: none; border-radius: 5px;">
        Baixar
    </a>
</body>
</html>
