@extends('master.layout')
@section('title', 'Configurações e privacidade')

@section('content')

<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Configurações e privacidade</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

<div class="container-fluid">
    <div class="row justify-content-center containerConfig">
        <div class="col-md-6">
            <!-- Seção Informação do Perfil -->
            <div class="card">
                <div class="card-header">
                    <h5>Informação do perfil</h5>
                </div>
                <div class="card-body">
                    <a href="#" class="d-flex justify-content-between align-items-center">
                        <span>Nome</span>
                      <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.1094 8.125H2.5V6.875H10.1094L6.60938 3.375L7.5 2.5L12.5 7.5L7.5 12.5L6.60938 11.625L10.1094 8.125Z" fill="#555555"/>
                        </svg>

                    </a>
                </div>
            </div>

            <!-- Seção Privacidade dos Dados -->
            <div class="card mt-3 hidden">
                <div class="card-header">
                    <h5>Privacidade dos dados</h5>
                </div>
                <div class="card-body">
                    <a href="#" class="d-flex justify-content-between align-items-center">
                        <span>Escolha quem pode comentar nos conteúdos</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- Seção Segurança -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Segurança</h5>
                </div>
                <div class="card-body">
                    <!-- Botão para abrir o primeiro modal -->
                    <a href="#" class="d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#changePasswordModal">
                        <span>Alterar palavra-passe</span>
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.1094 8.125H2.5V6.875H10.1094L6.60938 3.375L7.5 2.5L12.5 7.5L7.5 12.5L6.60938 11.625L10.1094 8.125Z" fill="#555555"/>
                        </svg>

                    </a>
                    <hr>
                    <a href="#" class="d-flex justify-content-between align-items-center mt-3">
                        <span>E-mail ou número de telemóvel</span>
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.1094 8.125H2.5V6.875H10.1094L6.60938 3.375L7.5 2.5L12.5 7.5L7.5 12.5L6.60938 11.625L10.1094 8.125Z" fill="#555555"/>
                        </svg>
                    </a>
                    <small>Define onde queres receber notificações e acesso ao métodos de recuperação</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Formulário de Alteração de Senha -->
<div class="modal fade escurecer" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Alterar palavra-passe</h5>
            </div>
            <form id="changePasswordForm" method="POST" action="{{ route('password.request.code') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Palavra-passe atual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Nova palavra-passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar palavra-passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <small><a href="{{ route('password.request') }}">Esqueceu a sua palavra-passe?</a></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Confirmação do Código -->
<div class="modal fade escurecer" id="confirmCodeModal" tabindex="-1" role="dialog" aria-labelledby="confirmCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCodeModalLabel">Confirmação necessária</h5>
            </div>
            <form id="confirmCodeForm" method="POST" action="{{ route('passwordChange.confirm.code') }}">
                @csrf
                <div class="modal-body">
                    <p>Enviamos um código de confirmação para <span id="userEmail">{{ auth()->user()->email }}</span>. Por favor, digite o código para prosseguir.</p>
                    <div class="form-group">
                        <label for="confirmation_code">Código de confirmação</label>
                        <input type="text" class="form-control" id="confirmation_code" name="confirmation_code" required>
                    </div>
                    <small><a href="{{ route('password.resend.code') }}" id="resendCodeLink">Não recebi nenhum código!</a></small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluindo SweetAlert e jQuery -->
    <script>
        $(document).ready(function() {
            // Após o envio bem-sucedido do primeiro formulário, abrir o modal de confirmação
            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#changePasswordModal').modal('hide');
                        $('#confirmCodeModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Erro ao enviar o formulário. Verifique os campos.');
                    }
                });
            });

            // Após o envio bem-sucedido do código de confirmação, mostrar SweetAlert
            $('#confirmCodeForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#confirmCodeModal').modal('hide');
                        Swal.fire({
                            title: 'Sua palavra-passe foi alterada!',
                            imageUrl: "{{asset('logo/img/icon/Completed.svg')}}",
                            confirmButtonText: 'Ok',
                            customClass:{
                                popup: 'popupChangePassword',
                            }
                        });
                    },
                    error: function(xhr) {
                        alert('Código inválido ou erro ao confirmar.');
                    }
                });
            });

            // Reenviar código
            $('#resendCodeLink').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire({
                            position: 'top',
                            title: 'O código de confirmação foi enviado para {{ auth()->user()->email }}. Recebera em 10 segundos',
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
    </script>

@endsection