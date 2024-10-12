<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de solicitações</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 1em;
        }
        body {
            margin: 3cm 2cm 2cm;
        }
        .p-3{
            padding: 10px;
            border-radius: 5px;
            background: rgba(118, 170, 200, 0.50);
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        .margem{
            margin: 20px;
        }
    </style>
</head>
<body>

<header>
    <h5 class="margem">Lista de solicitações</h5>
</header>
    <div class="container p-3">
        <span>Data: {{date('d-m-yy')}}</span>
            <table class="table" id="formCad">
                <tr class="titleList">
                    <td>Nome</td>
                    <td>Acesso</td>
                    <td>E-mail</td>
                    <td>Status</td>
                </tr>

             @foreach($users as $user)
                <tr>
                    <td scope="row">
                        <div class="widget-content-left flex2">
                             <div class="widget-heading">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="widget-subheading opacity-7">
                            @if ($user->role)
                                <span class="badge badge-info">{{ $user->role->name }}</span>
                            @else
                                <span class="badge badge-danger">No role found :(</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="widget-content-left flex2">
                            <div class="widget-heading">{{$user->email}}</div>
                        </div>
                    </td>
                    <td>
                        <div class="widget-heading">{{ $user->status }}</div>
                    </td>
                    </tr>
             @endforeach
            </table>
    </div>

<footer>
    <h5 class="margem">Copyright &copy; {{date('yy')}} <a href="#" target="_blank"> corporatix.com.br </a></h5>
</footer>
</body>
</html>