
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a sua palavra-passe - Soclima</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E7ECEB;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .soclima-branding {
            width: 289px;
            margin-right: 50px;
        }

        .soclima-branding  p{
            font-size: 36px;
            line-height: 42px;
            font-weight: 400 !important;
            color: #555;
        }
        .soclima-branding img {
            width: 100%;
            margin-bottom: 27px;
        }
 
        .modal-content, .card {
            border-radius: 5px !important;
            width: 488px !important;
            height: 451px !important;
            padding: 34px 26px !important
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .form-step h5{
            color: #555;
            font-size: 20px;
            font-weight: bold;
        }

        .form-step p{
            color: #555;
            font-size: 14px;
        }

        .form-step label{
            color: #7b7b7b;
            font-size: 14px;
        }

        .form-step form{
            margin-top: 52px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .btnSenha {
            background-color: #ddd;
            width: 156px;
            color: #555;
            height: 45px;
            border: none;
            border-radius: 5px;
            outline: none !important;
        }

        .btn-secondary {
            background-color: #ddd;
            width: 156px;
        }

        .containerCards {
            display: flex;
            justify-content: center;
        }

        nav{
            width: 100%;
            height: 53px;
            background-color: #fff;
            display: flex;
            align-items: center;
        }

        nav img{
            width: 123px;
            margin-left: 180px;
        }

        .containerHeaderForm button{
            background: none;
            border: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .containerHeaderForm h5{
            margin: 0 !important;
        }

        .containerHeaderForm{
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        #resendCodeLink{
            font-size: 13px;
            font-weight: medium !important;
            color: #009ac1;
            text-decoration: none !important;
        }

        .containerBtns{
            display: flex;
            justify-content: end;
            gap: 20px;
        }

        .popupChangePassword img{
        width: 104px;
        }

        .popupChangePassword h2{
            font-size: 20px;;
        }

        .popupChangePassword button{
            border-radius: 5px !important;
            background-color: #009AC1;
            width: 109px !important;
            text-align: center !important;
            padding: 9px 44px;
        }

        .popupResendCode h2{
            font-size: 14px !important;
            text-align: left !important;
        }

        .btnSenha.active {
            background-color: #009AC1 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <nav>
    <img src="{{asset('logo/img/icon/soclima_horizontal.svg')}}" alt="Soclima Logo">
    </nav>
    <div class="container">
        <div class="containerCards">
            <div class="soclima-branding">
                <img src="{{asset('logo/img/icon/soclima_horizontal.svg')}}" alt="Soclima Logo">
                <p><strong>Soclima</strong> - Há 33 anos a construir e contribuir por uma Angola cada vez melhor!</p>
            </div>
            <div class="card p-4">
                <!-- Passo 1: Verificar Usuário -->
                <div class="form-step active" id="step-1">
                    <h5>Confirme a sua identidade para continuar</h5>
                    <p>Insere o seu ID de entrada e o e-mail registrado.</p>
                    <form id="verifyUserForm" method="POST" action="{{ route('password.verify.user') }}">
                        @csrf
                        <div class="containerInputs">
                            <div class="form-group">
                                <label for="numero_mecanografico">ID do trabalhador</label>
                                <input type="text" class="form-control" id="numero_mecanografico" name="numero_mecanografico" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btnSenha">Continuar</button>
                        </div>
                    </form>
                </div>
                <!-- Passo 2: Inserir Código de Confirmação -->
                <div class="form-step" id="step-2">
                    <div class="containerHeaderForm">
                        <button type="button" onclick="goBackToStep1()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.825 13L13.425 18.6L12 20L4 12L12 4L13.425 5.4L7.825 11H20V13H7.825Z" fill="#555555"/>
                            </svg>
                        </button>
                        <div>
                            <h5>Confirme a sua identidade para continuar</h5>
                            <p>Enviamos um código de verificação para o e-mail ********@***. Por favor, insira o código para prosseguir.</p>
                        </div>
                    </div>
                    
                    <form id="confirmCodeForm" method="POST" action="{{ route('password.confirm.code') }}">
                        @csrf
                        <div class="form-group">
                            <label for="confirmation_code">Código de confirmação</label>
                            <input type="text" class="form-control" id="confirmation_code" name="confirmation_code" required>
                        </div>
                       
                        <div class="d-flex justify-content-between align-items-center">
                        <small><a href="#" id="resendCodeLink">Não recebi nenhum código!</a></small>
                            <button type="submit" class="btnSenha">Continuar</button>
                        </div>
                    </form>
                </div>
                <!-- Passo 3: Redefinir Senha -->
                <div class="form-step " id="step-3">
                    <h5>Crie uma nova palavra-passe</h5>
                    <form id="resetPasswordForm" method="POST" action="{{ route('password.reset') }}">
                        @csrf
                        <div class="containerInputs">
                            <div class="form-group">
                                <label for="password">Nova palavra-passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirme a nova palavra-passe</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="containerBtns" >
                            <button type="button" onclick="goBackToStep2()" style="
                                    background-color: #ddd;
                                    width: 156px;
                                    color: #555;
                                    height: 45px;
                                    border: none;
                                    border-radius: 5px;
                                    outline: none !important;
                            ">Cancelar</button>
                            <button type="submit" class="btnSenha">Validar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Passo 1: Verificar Usuário

            function updateButtonState(stepId, inputs, button) {
            // Converter os inputs jQuery em um array e verificar se todos estão preenchidos
            let allFilled = true;
            inputs.each(function() {
                if ($(this).val().trim() === '') {
                    allFilled = false;
                    return false; // Sai do loop se encontrar um campo vazio
                }
            });

            if (allFilled) {
                $(button).addClass('active');
            } else {
                $(button).removeClass('active');
            }
        }

        // Passo 1: Verificar Usuário
        const step1Inputs = $('#step-1 input');
        const step1Button = $('#step-1 .btnSenha');
        step1Inputs.on('input', function() {
            updateButtonState('#step-1', step1Inputs, step1Button);
        });
            $('#verifyUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#step-1').removeClass('active');
                        $('#step-2').addClass('active');
                        $('#step-2 .btnSenha').removeClass('active');
                    },
                    error: function(xhr) {
                        let errorMessage = 'Erro ao verificar usuário.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Erro',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });

            // Passo 2: Confirmar Código
            const step2Inputs = $('#step-2 input');
            const step2Button = $('#step-2 .btnSenha');
            step2Inputs.on('input', function() {
                updateButtonState('#step-2', step2Inputs, step2Button);
            });

            $('#confirmCodeForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#step-2').removeClass('active');
                        $('#step-3').addClass('active');
                        // Resetar o botão do passo 3 ao mudar de passo
                        $('#step-3 .btnSenha').removeClass('active');
                    },
                    error: function(xhr) {
                        let errorMessage = 'Código inválido ou erro ao confirmar.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Erro',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });

            // Passo 3: Redefinir Senha
            const step3Inputs = $('#step-3 input');
            const step3Button = $('#step-3 .btnSenha');
            step3Inputs.on('input', function() {
                updateButtonState('#step-3', step3Inputs, step3Button);
            });

            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Sua palavra-passe foi alterada!',
                            imageUrl: "{{asset('logo/img/icon/Completed.svg')}}",
                            confirmButtonText: 'Ok',
                            customClass:{
                                popup: 'popupChangePassword',
                            }
                        }).then(() => {
                            // Redirecionar para a página de login
                            window.location.href = response.redirect;
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Erro ao redefinir a senha.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Erro',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });

            // Reenviar Código
            $('#resendCodeLink').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('password.verify.user') }}', // Reutilizamos a mesma rota para reenviar
                    method: 'POST',
                    data: $('#verifyUserForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            position: 'top',
                            title: 'O código de confirmação foi enviado. Recebera em 10 segundos',
                            showConfirmButton: false,
                            timer: 5000,
                            toast: false,
                            customClass:{
                                popup: 'popupResendCode',
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            position: 'top',
                            title: 'Erro ao reenviar o código.',
                            showConfirmButton: false,
                            timer: 5000,
                            toast: false,
                            customClass:{
                                popup: 'popupResendCode',
                            }
                        });
                    }
                });
            });
        });

        // Funções para voltar aos passos anteriores
        function goBackToStep1() {
            $('#step-2').removeClass('active');
            $('#step-1').addClass('active');
            $('#step-1 .btnSenha').removeClass('active');
        updateButtonState('#step-1', $('#step-1 input'), $('#step-1 .btnSenha'));
        }

        function goBackToStep2() {
            $('#step-3').removeClass('active');
            $('#step-2').addClass('active');
            $('#step-2 .btnSenha').removeClass('active');
        updateButtonState('#step-2', $('#step-2 input'), $('#step-2 .btnSenha'));
        }
    </script>
</body>
