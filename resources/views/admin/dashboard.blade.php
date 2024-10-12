@extends('master.layout')
@section('title', 'Administração')

@section('content')
    {{-- JQUERY AQUI--}}
    <link rel="stylesheet" href="{{ url(mix('/public/plugins/chart.js/Chart.min.css'))}}">
    <link rel="stylesheet" href="{{asset('grafico/estilo.css')}}">

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">
                          @role('admininstrador')
                            Painel de administrador
                          @else
                            Dashboard
                          @endrole
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            {{--PAINEL GRAFICOS/USUÁRIOS--}}
            <div class="row">

                {{--NOTICIAS --}}
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="far fa-newspaper"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{total_posts() <= 1 ? 'Notícia' : 'Notícias'}}</span>
                            <span class="info-box-number">{{total_posts()}}</span>
                        </div>
                    </div>
                </div>

                {{-- USÁRIOS --}}
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">

                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1 zoom"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{user_all() <= 1 ? 'Usuário' : 'Usuários'}}</span>
                            <span class="info-box-number">{{user_all()}}</span>
                        </div>
                    </div>
                </div>

                {{-- QUESTIONÁRIOS--}}
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{total_survey() <= 1 ? 'Questionário' : 'Questionários'}}</span>
                            <span class="info-box-number">{{total_survey()}}</span>
                        </div>
                    </div>
                </div>

                {{-- USUARIOS ONLINE DEMONSTRATIVO--}}
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">

                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1 zoom"><i class="fas fa-user-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{user_on() <= 1 ? 'Visitante online' : 'Visitantes online'}}</span>
                            <span class="info-box-number">{{user_on()}}</span>
                        </div>
                    </div>
                </div>

                {{-- GRAFICOS --}}

                {{--PAINEL PRINCIPAL E GRAFICO NOTICIAS X CURTIDAS --}}
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="small-box badge btn-mdb-color p-3 text-left" style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <strong class="text-white">Indicadores de notícias e likes</strong>
                        </div>

                        {{-- CORPO GRAFICO/DADOS --}}
                        <div class="card-body">
                            <div class="row">

                                {{-- GRAFICOS --}}
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <canvas id="myChartsLikesDate"></canvas>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        {{-- DADOS RODAPÉ--}}
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="row">
                                        {{-- DADOS 1 --}}
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="description-block border-right">
                                                <i class="far fa-comments text-sm-center"></i>
                                                <h5 class="description-header"><strong class="text-indigo text-bold">{{comentarios()}}</strong></h5>
                                                <span class="description-text">COMENTÁRIOS</span>
                                            </div>
                                        </div>

                                        {{-- DADOS 2 --}}
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="description-block border-right">
                                                <i class="fas fa-archive text-sm-center"></i>
                                                <h5 class="description-header"><strong class="text-indigo text-bold">{{categorias()}}</strong></h5>
                                                <span class="description-text">CATEGORIAS</span>
                                            </div>
                                        </div>

                                        {{-- DADOS 3 --}}
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="description-block border-right">
                                                <i class="far fa-eye text-sm-center"></i>
                                                <h5 class="description-header"><strong class="text-indigo text-bold">{{views()}}</strong></h5>
                                                <span class="description-text">VISUALIZAÇÕES</span>
                                            </div>
                                        </div>

                                        {{-- DADOS 4 --}}
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="description-block">
                                            <span class="description-percentage text-danger">
                                                <i class="fa fa-thumbs-down"></i> 
                                                {{ totalLikes() > 0 ? round(deslikes()*100/totalLikes()) : 0 }}%
                                            </span>

                                                <h5 class="description-header"><strong class="text-indigo text-bold">{{deslikes()}}</strong></h5>
                                                <span class="description-text">Deslikes</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <p class="text-center">
                                        <strong>Outros indicadores</strong>
                                    </p>

                                    {{-- DADOS LIKES--}}
                                    <div class="progress-group">
                                        Likes
                                        <span class="float-right"><b>{{ likes() }}</b>/{{ totalLikes() }}</span>
                                        <div class="progress progress-sm">
                                            @if(totalLikes() > 0)
                                                @if(likes() > deslikes())
                                                    <div class="progress-bar bg-success" style="width: {{ round(likes()*100/totalLikes()) }}%"></div>
                                                @else
                                                    <div class="progress-bar bg-danger" style="width: {{ round(likes()*100/totalLikes()) }}%"></div>
                                                @endif
                                            @else
                                                <div class="progress-bar bg-warning" style="width: 0%">No data</div>
                                            @endif
                                        </div>
                                    </div>


                                    {{-- DADOS DESLIKES--}}
                                    <div class="progress-group">
                                        Deslikes
                                        <span class="float-right"><b>{{ deslikes() }}</b>/{{ totalLikes() }}</span>
                                        <div class="progress progress-sm">
                                            @if(totalLikes() > 0)
                                                <div class="progress-bar bg-danger" style="width: {{ round(deslikes() * 100 / totalLikes()) }}%"></div>
                                            @else
                                                <div class="progress-bar bg-warning" style="width: 0%">No data</div>
                                            @endif
                                        </div>

                                    </div>


                                    {{-- DADOS NOTICIAS VALIDAS--}}
                                    <div class="progress-group">
                                        <span class="progress-text">Notícias disponíveis</span>
                                        <span class="float-right"><b>{{total_posts() - invalid_posts()}}</b>/{{total_posts()}}</span>
                                        <div class="progress progress-sm">
                                            @if(total_posts() > 0)
                                                @if(round((total_posts() - invalid_posts()) * 100 / total_posts()) >= 50)
                                                    <div class="progress-bar bg-success" style="width: {{ round((total_posts() - invalid_posts()) * 100 / total_posts()) }}%"></div>
                                                @else
                                                    <div class="progress-bar bg-danger" style="width: {{ round((total_posts() - invalid_posts()) * 100 / total_posts()) }}%"></div>
                                                @endif
                                            @else
                                                <div class="progress-bar bg-warning" style="width: 0%">No data</div>
                                            @endif
                                        </div>

                                    </div>

                                    {{-- DADOS NOTICIAS INVALIDAS--}}
                                    <div class="progress-group">
                                        <span class="progress-text">Notícias indisponíveis</span>
                                        <span class="float-right"><b>{{invalid_posts()}}</b>/{{total_posts()}}</span>
                                        <div class="progress progress-sm">
                                            @if(total_posts() > 0)
                                                @if(round(invalid_posts() * 100 / total_posts()) >= 50)
                                                    <div class="progress-bar bg-danger" style="width: {{ round(invalid_posts() * 100 / total_posts()) }}%"></div>
                                                @elseif(round(invalid_posts() * 100 / total_posts()) <= 30)
                                                    <div class="progress-bar bg-warning" style="width: {{ round(invalid_posts() * 100 / total_posts()) }}%"></div>
                                                @endif
                                            @else
                                                <div class="progress-bar bg-warning" style="width: 0%">No data</div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GRAFICOS Total de noticías criadas por usuário--}}
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="small-box badge btn-mdb-color p-3 text-left" style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <strong class="text-white">Total de noticías criadas por usuário</strong>
                        </div>

                        {{-- CORPO GRAFICO/DADOS --}}
                        <div class="card-body">
                            <div class="row">

                                {{-- GRAFICOS --}}
                                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                    <div class="chart">
                                        <canvas id="myCharts" height="180" style="height: 350px;"></canvas>
                                    </div>
                                </div>

                                {{-- DADOS DIREITA--}}
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <p class="text-center">
                                        <strong>Outros indicadores</strong>
                                    </p>

                                    {{-- DADOS USUARIOS ATIVOS--}}
                                    <div class="progress-group">
                                        <span class="progress-text">Usuários ativos</span>
                                        <span class="float-right"><b>{{$tot_user_ativo = user_ativos()}}</b>/{{user_all()}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: {{round($tot_user_ativo*100/user_all())}}%"></div>
                                        </div>
                                    </div>

                                    {{-- DADOS INATIVOS--}}
                                    <div class="progress-group">
                                        <span class="progress-text">Usuários inativos</span>
                                        <span class="float-right"><b>{{user_inativos()}}</b>/{{user_all()}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: {{round(user_inativos()*100/user_all())}}%"></div>
                                        </div>
                                    </div>

                                    {{-- DADOS --}}
                                    <div class="progress-group">
                                        <span class="progress-text">Perfil administrador</span>
                                        <span class="float-right"><b>{{user_admin()}}</b>/{{$tot_user_ativo}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: {{round(user_admin() * 100 / $tot_user_ativo)}}%"></div>
                                        </div>
                                    </div>

                                    {{-- DADOS --}}
                                    <div class="progress-group">
                                        <span class="progress-text">Perfil usuário</span>
                                        <span class="float-right"><b>{{user_user()}}</b>/{{$tot_user_ativo}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: {{round(user_user() * 100 / $tot_user_ativo)}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GRAFICOS Número de usuários por cargo--}}
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="small-box badge btn-mdb-color p-3 text-left" style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <strong class="text-white">Número de usuários por cargo</strong>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myChartsCargos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GRAFICOS Número de usuários por unidade--}}
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="small-box badge btn-mdb-color p-3 text-left" style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <strong class="text-white">Número de usuários por unidade</strong>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myChartsUnidades" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--PAINEL QUESTIONÁRIO --}}
            <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="small-box badge btn-mdb-color p-3 text-left" style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                            <strong class="text-white">Indicadores dos questionários</strong>
                        </div>

                        {{-- CORPO QUESTIONÁRIO --}}
                        <div class="card-body">
                            <div class="row">
                                {{-- DADOS SLIDERS QUESTIONÁRIO--}}
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <p class="text-center">
                                        <strong>Total de questionários respondidos pelos usuários</strong>
                                    </p>

                                    {{-- DADOS --}}
                                    <div class="progress-group">
                                        @foreach($questionarios as $questionario)
                                            {{$questionario->title}}
                                        <span class="float-right"><b>{{$questionario->respondidas}}</b>/{{$tot_user_ativo}}</span>
                                        <div class="progress progress-sm">
                                            @if(round($questionario->respondidas*100/$tot_user_ativo) > 50)
                                                <div class="progress-bar bg-success" style="width: {{round($questionario->respondidas*100/$tot_user_ativo)}}%"></div>
                                            @else
                                                <div class="progress-bar bg-danger" style="width: {{round($questionario->respondidas*100/$tot_user_ativo)}}%"></div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DADOS RODAPÉ--}}
                        <div class="card-footer">
                            <div class="row">

                                {{-- DADOS 1 --}}
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <i class="fas fa-flag-checkered text-sm-center"></i>
                                        <h5 class="description-header"><strong class="text-indigo text-bold">{{$questionarios->count()}}</strong></h5>
                                        <span class="description-text">LIBERADOS</span>
                                    </div>
                                </div>

                                {{-- DADOS 2 --}}
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <i class="fas fa-wrench text-sm-center"></i>
                                        <h5 class="description-header"><strong class="text-indigo text-bold">{{tot_questions_aberto()}}</strong></h5>
                                        <span class="description-text">EM CONSTRUÇÃO</span>
                                    </div>
                                </div>

                                {{-- DADOS 3 --}}
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <i class="far fa-eye text-sm-center"></i>
                                        <h5 class="description-header"><strong class="text-indigo text-bold">{{$views = tot_questions_views()}}</strong></h5>
                                        <span class="description-text">VISUALIZAÇÕES</span>
                                    </div>
                                </div>

                                {{-- DADOS 4 --}}
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        @if($tot_user_ativo > 0 && $questionarios->count() > 0)
                                            @if(round(tot_questio_finalizados() * 100 / ($tot_user_ativo * $questionarios->count())) > 50)
                                                <span class="description-percentage text-success">
                                                    <i class="fa fa-thumbs-up"></i> 
                                                    {{ round(tot_questio_finalizados() * 100 / ($tot_user_ativo * $questionarios->count())) }}%
                                                </span>
                                            @else
                                                <span class="description-percentage text-danger">
                                                    <i class="fa fa-thumbs-down"></i> 
                                                    {{ round(tot_questio_finalizados() * 100 / ($tot_user_ativo * $questionarios->count())) }}%
                                                </span>
                                            @endif
                                            <h5 class="description-header">
                                                <strong class="text-indigo text-bold">
                                                    {{ tot_questio_finalizados() }}/{{ $tot_user_ativo * $questionarios->count() }}
                                                </strong>
                                            </h5>
                                        @else
                                            <span class="description-percentage text-warning">
                                                Sem dados
                                            </span>
                                            <h5 class="description-header">
                                                <strong class="text-indigo text-bold">0/0</strong>
                                            </h5>
                                        @endif
                                        <span class="description-text">TOTAL FINALIZADOS</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>



    <script type="text/javascript">
        var urlGrafic = '{{ route('grafico.create') }}';
    </script>

    <script src="{{ url(mix('/public/plugins/chart.js/Chart.min.js'))}}"></script>
    <script src="{{ asset('grafico/script.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
@endsection