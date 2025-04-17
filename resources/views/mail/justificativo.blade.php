<!DOCTYPE html>
<html>
<head>
    <title>Justificativo</title>
</head>
<body>

    @if($tipo === 'novo')
        <p>Um novo justificativo foi enviado por <strong>{{ $user->name }}</strong>.</p>
    @else
        <p>Atualização do justificativo de <strong>{{ $user->name }}</strong>.</p>
    @endif
    <h2>Detalhes do Justificativo</h2>
    <ul>
        <li><strong>Tipo de Falta:</strong> {{ $ausencia->tipo_falta }}</li>
        <li><strong>Motivo:</strong> {{ $ausencia->motivo }}</li>
        <li><strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($ausencia->data_inicio)->format('d/m/Y') }}</li>
        <li><strong>Horas:</strong> {{ $ausencia->horas ?? 'N/A' }}</li>
        <li><strong>Descontar nas Férias:</strong> {{ $ausencia->descontar_nas_ferias ?? 'Não' }}</li>
        <li><strong>Status:</strong> {{ $ausencia->status }}</li>
        @if($ausencia->observacao)
            <li><strong>Observação:</strong> {{ $ausencia->observacao }}</li>
        @endif
    </ul>

    @if($downloadUrl && $ausencia->tipo_falta === 'justificada')
        <p>Segue abaixo o link para download do justificativo:</p>
        <a href="{{ $downloadUrl }}" style="display: inline-block; padding: 10px 20px; margin: 20px 0; background-color: #009AC1; color: #fff; text-decoration: none; border-radius: 5px;">Baixar</a>
    @endif

</body>
</html>