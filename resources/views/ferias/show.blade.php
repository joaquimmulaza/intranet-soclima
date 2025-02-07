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
        <div class="d-flex justify-content-end align-items-center hidden" style="width: 95%; margin: 0 auto; position: relative; top: 29px;">
            <button class="hidden" data-toggle="modal" data-target="#modalFerias-{{ $funcionario->id }}" class="btnFerias">Atualizar férias</button>
        </div>
       
        <div class="d-flex justify-content-end align-items-center" style="width: 95%; margin: 0 auto; position: relative; top: 29px;">
        
        <a class="btnFerias" href="{{ route('ferias.marcar') }}">Solicitar Férias</a>
        
        </div>
        <div class="row justify-content-around MainContainerFerias">
        
            <!-- Coluna Esquerda: Informações do Funcionário -->
            <div class="card-user">
                <div class="card-user-info">
                    <div class="card-body text-center">
                        @if($funcionario && $funcionario->avatar)
                            <img class="img_user_check_ferias" style="width: 161px; border-radius: 8px;" src="{{ URL::to('/') }}/public/avatar_users/{{ $funcionario->avatar }}" alt="">
                        @else
                            <img class="img_user_check_ferias" style="width: 161px; border-radius: 8px;" src="{{ URL::to('/public/avatar_users/default-avatar.png') }}" alt="">
                        @endif

                        <div class="info-name-img">
                            <h4 class="card-title">{{ $funcionario->name }}</h4>
                        </div><br>
        
                        <div class="outros-dados">
                            <p><strong>Cargo:</strong> {{ $funcionario->cargo->titulo }}</p>
                            <p><strong>Área:</strong> {{ $funcionario->unidade->titulo }}</p>
                            <p><strong>Nº mecanográfico:</strong> {{ $funcionario->numero_mecanografico }}</p>
                        </div>
                        <button data-toggle="modal" data-target="#cardUserViewNav-{{ $funcionario->id }}" class="">Exibir todos os dados</button>
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
                                <span class="totalDias">22 dias </span>
                                <span class="uteis">úteis</span>
                            </p>
                            <p>
                                <span>Férias acumuladas:</span> 
                                <span class="totalDias">
                                    @if($diasAcumulados == 1)
                                    {{ $diasAcumulados }} dia
                                    @else
                                    {{ $diasAcumulados }} dias
                                    @endif
                                </span>
                                <span class="uteis">
                                    úteis
                                </span>
                            </p>
                        </div>
                        <div class="dias-ferias ferias-restantes">
                            <p>
                                <span>Férias restantes:</span> 
                                <span>{{ $feriasAnuais }} dias</span>
                            </p>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="graphics_ferias">
                    <div class="graphic_gozadas">
                <div class="graphic_ferias">
                    <div class="square-chart">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="6" height="8" transform="matrix(-1 0 0 1 6 0)" fill="#CD0000"/>
                        </svg>
                        <span>Férias gozadas:</span>
                    </div>
                    <canvas id="feriasGozadasChart" width="50" height="50"></canvas>
                    <div class="chart-description">
                        <span id="feriasGozadasCount">{{ $feriasGozadas }} dias</span>
                    </div>
                </div>
            
                <div class="btn_ferias">
                    <button id="btn-historico">Histórico</button>
                </div>
            <div class="container-historico">
                <div id="historico" class="historico hidden">
                <div class="container_periodo">
                @if ($historicoFerias->isEmpty())
                    <p><strong>Sem histórico de férias</strong></p>
                @else
                    @foreach ($historicoFerias->reverse() as $feria)
                        <div class="historico_periodo">
                            <p>Período {{ $feria['periodo'] }}:</p>
                            <span>de {{ $feria['data_inicio'] }} a {{ $feria['data_fim'] }}</span>
                        </div>
                    @endforeach
                @endif
                </div>
                        <button id="btn-fechar-historico" class="btn-fechar">
                            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="33" width="33" height="33" rx="3" transform="rotate(-90 0 33)" fill="#ABABAB" fill-opacity="0.14"/>
                                <path d="M8.25 19.6557L10.1887 21.5945L16.5 15.297L22.8113 21.5945L24.75 19.6557L16.5 11.4057L8.25 19.6557Z" fill="#555555"/>
                            </svg>
                        </button>
                </div>
                <div id="proximas-ferias" class="proximas hidden">
                <div class="container_periodo">
                @if ($historicoFerias->isEmpty())
                    <p><strong>Sem férias marcadas</strong></p>
                @else
                    @foreach ($historicoFerias as $feria)
                        <div class="historico_periodo">
                            <p>Período {{ $feria['periodo'] }}:</p>
                        </div>
                        <div class="historico_periodo">
                        <p><strong>Início de férias:</strong></p>
                        <span>{{ $feria['data_inicio'] }}</span>
                        </div>
                        <div class="historico_periodo">
                            <p><strong>Fim de férias:</strong> </p>
                            <span>{{ $feria['data_fim'] }}</span>
                        </div>
                        <div class="historico_periodo">
                            <p><strong>Data de retorno prevista:</strong> </p>
                            <span>{{$feria['data_retorno']}}</span>
                        </div>
                    @endforeach
                @endif
                </div>
                    <button id="btn-fechar-proximas" class="btn-fechar">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="33" width="33" height="33" rx="3" transform="rotate(-90 0 33)" fill="#ABABAB" fill-opacity="0.14"/>
                            <path d="M8.25 19.6557L10.1887 21.5945L16.5 15.297L22.8113 21.5945L24.75 19.6557L16.5 11.4057L8.25 19.6557Z" fill="#555555"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

<div class="graphic_restantes">
    <div class="graphic_ferias">
        <div class="square-chart" style="width: 109px">
            <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="6" height="8" transform="matrix(-1 0 0 1 6 0)" fill="#CDCC00"/>
            </svg>
            <span>Férias para<br>gozar:</span>
        </div>
        <canvas id="feriasRestantesChart" width="50" height="50"></canvas>
        <div class="chart-description">
            <span>
                @if($totalDiasFerias == 1)
                {{ $totalDiasFerias }} dia
                @else
                {{ $totalDiasFerias }} dias
                @endif
            </span>
        </div>
    </div>
    <div class="btn_ferias">
        <button id="btn-proximas-ferias">Próximas férias</button>
    </div>
</div>

</div>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFerias-{{ $funcionario->id }}" class="modal escurecer modalFerias" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content " style="width: 300px; margin: 0 auto; background: white; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ferias.updateDias') }}" method="POST">
                @csrf
                <div class="inputDiasFerias">
                    <label for="diasFerias">Preencher férias anuais</label>
                    <div class="input-container">
                            
                    <input type="number" id="diasFerias" name="dias_disponiveis" max="22" 
                    oninput="validarLimite(this)" min="1">
                            <span class="prefix">dias</span>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{ $funcionario->id }}">
                <div class="d-flex justify-content-center">
                    <button id="btnAdicionarFerias" >Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade cardUserView escurecer" id="cardUserViewNav-{{ $funcionario->id }}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-dismiss="modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-header-center">
                                        <img src="{{URL::to('/')}}/public/avatar_users/{{$funcionario->avatar}}" alt="Foto do perfil">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true"><img src="{{asset('logo/img/icon/clear.svg')}}" alt=""></span>
                                    </button>
                                </div>
                               
                                <div class="modal-body">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <div class="user-info-left">
                                            
                                            <div>
                                                <h4 style="padding: 0 !important; margin: 0 !important;">{{$funcionario->name }}</h4>
                                                <p  style="padding: 0 !important; margin: 0 !important;">{{ $funcionario->cargo->titulo}}</p>
                                                
                                            </div>
                                        </div>
                                        <div class="divBtnEdit">
                                            <a href="{{ route('user.edit', ['user' => $funcionario->id]) }}">
                                                <img src="{{ asset('logo/img/icon/icon-edit.svg') }}" alt="">
                                            </a>
                                        </div>
                                       
                                    </div>
                                    <hr style="width: 537px; position: absolute; left: 0; right: 0; background-color: #cecece !important;">

                                    <div class="btnCardUser">
                                        <button>Dados deste perfil</button>
                                        <button>Publicações</button>
                                    </div>
                                    <div class="info-section">
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{ asset('logo/img/icon/cake.svg') }}" alt="">
                                                <span class="">Data de nascimento:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime($funcionario->nascimento))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/gender.svg')}}" alt="">
                                                <span>Gênero:</span>
                                            </div>
                                            <span>{{ $funcionario->genero }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/eventIcon.svg')}}" alt="">
                                                <span>Data de admissão:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime($funcionario->data_admissao))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/call.svg')}}" alt="">
                                                <span>Telemóvel da firma</span>
                                            </div>
                                            <span></span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/call.svg')}}" alt="">
                                                <span>Telemóvel pessoal:</span>
                                            </div>
                                            <span>{{ $funcionario->fone }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/mail.svg')}}" alt="">
                                                <span>E-mail</span>
                                            </div>
                                            <span>{{ $funcionario->email }}</span>
                                        </div>
                                        
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/numbers.svg')}}" alt="">
                                                <span class="">Nº mecanográfico:</span>
                                            </div>
                                            <span>{{ $funcionario->numero_mecanografico }}</span>
                                        </div>
                                        <div class="dadosPessoais" style="display: none;">
                                            <div>
                                                <button class="btn-link" data-toggle="modal" data-target="#outrosDadosModal-{{ $funcionario->id }}" data-dismiss="modal">Outros dados</button>
                                            </div>
                                            <span><img src="{{asset('logo/img/icon/chevron_right.svg')}}" alt=""></span>
                                        </div>
                                        <div class="modal fade" id="outrosDadosModal-{{ $funcionario->id }}" tabindex="-1" aria-labelledby="outrosDadosLabel" aria-hidden="true" data-parent-modal="cardUserView-{{ $funcionario->id }}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Outros Dados</h5>
                                                        <button type="button" class="close" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Conteúdo do Modal -->
                                                        <p>Informações adicionais do usuário aqui.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cardUserView-{{ $funcionario->id }}" data-dismiss="modal">
                                                            Voltar
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                            Fechar Todos
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    const feriasGozadasData = {
        datasets: [{
            data: [{{ $feriasGozadas  }}, {{ $totalDiasFerias - $feriasGozadas }}],    
            backgroundColor: ['#CD0000', 'rgba(205, 204, 0, 0.25)']
        }]
    };

    const feriasRestantesData = {
        datasets: [{
            data: [{{ $totalDiasFerias - $feriasGozadas }}, {{ $feriasGozadas }}],
            backgroundColor: ['#CDCC00', '#E2E2E2'],
        }]
    };

    const feriasGozadasConfig = {
    type: 'doughnut',
    data: feriasGozadasData,
    options: {
        cutout: 75,
        responsive: true,
        plugins: {
            tooltip: {
                enabled: false, // Desabilitar tooltip para facilitar o teste visual
            }
        },
        animation: {
            animateRotate: true, // Garantir animação de rotação
            animateScale: true, // Garantir animação de escala
        }
    }
};
const feriasRestantesConfig = {
    type: 'doughnut',
    data: feriasRestantesData,
    options: {
        cutout: 75,
        responsive: true,
        plugins: {
            tooltip: {
                enabled: false, // Desabilitar tooltip para facilitar o teste visual
            }
        },
        animation: {
            animateRotate: true, // Garantir animação de rotação
            animateScale: true, // Garantir animação de escala
        }
    }
};

    const feriasGozadasChart = new Chart(document.getElementById('feriasGozadasChart'), feriasGozadasConfig);
    const feriasRestantesChart = new Chart(document.getElementById('feriasRestantesChart'), feriasRestantesConfig);

    console.log(feriasGozadasData);
console.log(feriasRestantesData);

    document.addEventListener('DOMContentLoaded', () => {
    const btnHistorico = document.getElementById('btn-historico');
    const btnFecharHistorico = document.getElementById('btn-fechar-historico');
    const historico = document.getElementById('historico');
    var feriasGozadas = @json($feriasGozadas);
    const btnProximasFerias = document.getElementById('btn-proximas-ferias');
    const btnFecharProximas = document.getElementById('btn-fechar-proximas');
    const proximasFerias = document.getElementById('proximas-ferias');

    // Abrir/Fechar "Histórico"
    btnHistorico.addEventListener('click', function () {
        if (historico.classList.contains('show')) {
            historico.classList.remove('show');
            setTimeout(() => {
                historico.classList.add('hidden');
            }, 300); // Espera a animação terminar antes de esconder
        } else {
            historico.classList.remove('hidden');
            setTimeout(() => {
                historico.classList.add('show');
            }, 10); // Pequeno atraso para ativar a animação
        }
    });

    // Fechar "Histórico"
    btnFecharHistorico.addEventListener('click', function () {
        historico.classList.remove('show');
        setTimeout(() => {
            historico.classList.add('hidden');
        }, 300); // Espera a animação terminar antes de esconder
    });

    // Abrir/Fechar "Próximas Férias"
    btnProximasFerias.addEventListener('click', function () {
        if (proximasFerias.classList.contains('show')) {
            proximasFerias.classList.remove('show');
            setTimeout(() => {
                proximasFerias.classList.add('hidden');
            }, 300); // Espera a animação terminar antes de esconder
        } else {
            proximasFerias.classList.remove('hidden');
            setTimeout(() => {
                proximasFerias.classList.add('show');
            }, 10); // Pequeno atraso para ativar a animação
        }
    });

    // Fechar "Próximas Férias"
    btnFecharProximas.addEventListener('click', function () {
        proximasFerias.classList.remove('show');
        setTimeout(() => {
            proximasFerias.classList.add('hidden');
        }, 300); // Espera a animação terminar antes de esconder
    });
});

 // Função para animar a contagem
 function animateCounter(target, start, end, duration) {
        let startTime = null;

        function updateCounter(timestamp) {
            if (!startTime) startTime = timestamp;
            let progress = timestamp - startTime;
            let count = Math.min(start + (progress / duration) * (end - start), end);

            // Atualiza o contador
            document.getElementById(target).innerText = Math.round(count) + ' dias';

            // Atualiza o gráfico
            chart.data.datasets[0].data[0] = count;
            chart.update();

            if (count < end) {
                requestAnimationFrame(updateCounter);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    // Selecionar os elementos do DOM
    const inputDiasFerias = document.getElementById('diasFerias');
    const btnAdicionar = document.getElementById('btnAdicionarFerias');

    // Adicionar um ouvinte para detectar mudanças no input
    inputDiasFerias.addEventListener('input', function () {
        if (inputDiasFerias.value.trim() !== '') {
            // Se o campo estiver preenchido, alterar o estilo do botão
            btnAdicionar.style.backgroundColor = '#009AC1';
            btnAdicionar.style.color = '#fff';
        } else {
            // Se o campo estiver vazio, voltar ao estilo original
            btnAdicionar.style.backgroundColor = '';
            btnAdicionar.style.color = '';
        }
    });

    function validarLimite(input) {
        const min = 1;
        const max = 22;

        // Verifica se o valor está fora do intervalo permitido
        if (input.value !== "") {
            if (parseInt(input.value) > max) {
                input.value = max; // Define o valor como o limite superior
            } else if (parseInt(input.value) < min) {
                input.value = min; // Define o valor como o limite inferior
            }
        }
    }

    // Iniciar a animação de contagem
    // animateCounter('feriasGozadasCount', 0, , 3000);
</script>


@endsection
