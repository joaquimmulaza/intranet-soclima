@extends('master.layout')
@section('title', 'Painel de Férias')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Consultar férias</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container">
    <div class="column justify-content-center ">
        <div class="d-flex justify-content-end align-items-center" style="width: 95%; margin: 0 auto; position: relative; top: 29px;">
        <button class="btnFerias">Atualizar férias</button>
        </div>
        
        <div class="row justify-content-around MainContainerFerias ">
        
            <!-- Coluna Esquerda: Informações do Funcionário -->
            <div class="card-user">
                <div class="card-user-info">
                    <div class="card-body text-center">
                        <img style="width: 161px; border-radius: 8px;" src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt=""><br>
                        <div class="info-name-img">
        
                            <h4 class="card-title">{{ $funcionario->name }}</h4>
                        </div><br>
        
                        <div class="outros-dados">
                            <p><strong>Cargo:</strong> {{ $funcionario->cargo->titulo}}</p>
                            <p><strong>Área:</strong> {{ $funcionario->unidade->titulo }}</p>
                            <p><strong>Nº mecanográfico:</strong> {{ $funcionario->numero_mecanografico }}</p>
                        </div>
                        <button class="">Exibir todos os dados</button>
                    </div>
                </div>
            </div>
            <svg width="1" height="644" viewBox="0 0 1 644" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="0.5" y1="-2.18557e-08" x2="0.500028" y2="644" stroke="#CECECE"/>
            </svg>
            <!-- Coluna Direita: Informações de Férias -->
            <div class="right-column">
                <div class="">
                    <div class="card-body">
        
                        <div class="column">
                            <!-- Informações principais -->
                            <div class="dias-ferias">
                                <p>
                                    <span>Férias anuais:</span> 
                                    <span class="totalDias">{{ $feriasAnuais }} dias </span>
                                    <span class="uteis">úteis</span>
                                </p>
                                <p>
                                    <span>Férias acumuladas:</span> 
                                    <span class="totalDias">0 dias </span>
                                    <span class="uteis">úteis</span>
                                </p>
                            </div>
                            <div class="dias-ferias ferias-restantes">
                                <p>
                                    <span>Férias restantes:</span> 
                                    <span>{{ $feriasRestantes }} dias</span>
                                </p>
                            </div>
                            <div class="">
                                <p>
                                    <span>Férias gozadas:</span> {{ $feriasGozadas }} dias
                                </p>
                                <p>
                                    <span>Férias para gozar:</span> {{ $feriasRestantes }} dias
                                </p>
                            </div>
                        </div>
                        <!-- Gráficos -->
                        <div class="row mt-3">
                            <div class="col-md-6 text-center">
                                <div class="progress-circle" style="background: conic-gradient(red 0% 10%, lightgray 10% 100%); border-radius: 50%; width: 100px; height: 100px; margin: 0 auto;"></div>
                                <p>Férias gozadas</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="progress-circle" style="background: conic-gradient(yellow 0% 40%, lightgray 40% 100%); border-radius: 50%; width: 100px; height: 100px; margin: 0 auto;"></div>
                                <p>Próximas férias</p>
                            </div>
                        </div>
                        <!-- Botões -->
                        <div class="text-center mt-4">
                            <button class="btn btn-secondary">Histórico</button>
                            <button class="btn btn-secondary">Próximas férias</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
