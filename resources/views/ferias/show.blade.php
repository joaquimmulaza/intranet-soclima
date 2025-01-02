@extends('master.layout')
@section('title', 'Painel de Férias')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Consultar férias</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container">
    <div class="column justify-content-center">
        <div class="d-flex justify-content-end align-items-center" style="width: 95%; margin: 0 auto; position: relative; top: 29px;">
            <button class="btnFerias">Atualizar férias</button>
        </div>
        
        <div class="row justify-content-around MainContainerFerias">
        
            <!-- Coluna Esquerda: Informações do Funcionário -->
            <div class="card-user">
                <div class="card-user-info">
                    <div class="card-body text-center">
                        @if($funcionario && $funcionario->avatar)
                            <img style="width: 161px; border-radius: 8px;" src="{{ URL::to('/') }}/public/avatar_users/{{ $funcionario->avatar }}" alt="">
                        @else
                            <img style="width: 161px; border-radius: 8px;" src="{{ URL::to('/public/avatar_users/default-avatar.png') }}" alt="">
                        @endif

                        <div class="info-name-img">
                            <h4 class="card-title">{{ $funcionario->name }}</h4>
                        </div><br>
        
                        <div class="outros-dados">
                            <p><strong>Cargo:</strong> {{ $funcionario->cargo->titulo }}</p>
                            <p><strong>Área:</strong> {{ $funcionario->unidade->titulo }}</p>
                            <p><strong>Nº mecanográfico:</strong> {{ $funcionario->numero_mecanografico }}</p>
                        </div>
                        <button class="">Exibir todos os dados</button>
                    </div>
                </div>
            </div>
            <svg width="1" height="644" viewBox="0 0 1 644" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="0.5" y1="0" x2="0.5" y2="644" stroke="#CECECE"/>
            </svg>
            
            <!-- Coluna Direita: Informações de Férias -->
            <div class="right-column">
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
                    </div>

                    <!-- Gráficos -->
                    <div class="row justify-content-between graphics_ferias">
                        <div class="graphic_gozadas">
                            <div class="" style="display: flex; ">
                                <div style="position: relative;">
                                    <canvas id="feriasGozadasChart" width="150" height="150"></canvas>
                                </div>
                                <div class="desc_gozadas">
                                    <p>Férias gozadas</p>
                                    <span>{{ $feriasGozadas }} dias</span>
                                </div>
                            </div>
                            <div class="btn_ferias"><button class="">Histórico</button></div>
                        </div>
                        <div class="graphic_Paragozar">
                            <canvas id="feriasRestantesChart" width="150" height="150"></canvas>
                            <div class="desc_paragozar">
                                <p>Próximas férias</p>
                                <span>{{ $feriasRestantes }} dias</span>
                            </div>
                            <div class="btn_ferias"><button class="">Próximas férias</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicionando Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dados para o gráfico de férias gozadas
        const feriasGozadasData = {
            labels: ['Férias Gozadas'],
            datasets: [{
                data: [{{ 2 }}, {{ $feriasRestantes }}],
                backgroundColor: ['#CD0000', '#CDCC0040'],
                borderWidth: 1
            }]
        };

        // Configuração do gráfico de férias gozadas
        const feriasGozadasConfig = {
            type: 'doughnut',
            data: feriasGozadasData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        };

        // Instância do gráfico de férias gozadas
        new Chart(
            document.getElementById('feriasGozadasChart'),
            feriasGozadasConfig
        );

        // Dados para o gráfico de próximas férias
        const feriasRestantesData = {
            labels: ['Férias para Gozar',],
            datasets: [{
                data: [{{ $feriasRestantes }}, {{2}}],
                backgroundColor: ['#CDCC00', '#E2E2E2'],
               
                borderWidth: 1
            }]
        };

        // Configuração do gráfico de próximas férias
        const feriasRestantesConfig = {
            type: 'doughnut',
            data: feriasRestantesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        };

        // Instância do gráfico de próximas férias
        new Chart(
            document.getElementById('feriasRestantesChart'),
            feriasRestantesConfig
        );
    });
</script>
@endsection
