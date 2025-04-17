<!DOCTYPE html>
<html>
<head>
    <title>Código de Confirmação</title>
</head>
<body>
    <p>Olá {{$user->name}}</p>
    <p>Para alterar a sua palavra-passe, por favor, digite o código de confirmação abaixo:</p>
    <h2>{{ $code }}</h2>
    <p>Se você não solicitou isso, ignore este e-mail.</p>
</body>
</html>