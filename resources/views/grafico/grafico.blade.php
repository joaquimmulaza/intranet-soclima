@extends('master.layout')
@section('title', 'graficos')

@section('content')
    <link rel="stylesheet" href="{{ url(mix('/public/plugins/chart.js/Chart.min.css'))}}">
    <link rel="stylesheet" href="{{asset('grafico/estilo.css')}}">
    <!-- Header breadcrumb -->
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Graficos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content teste">
        <div class="container-fluid">
            {{-- TELA DO CANVAS - GRAFICS--}}
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">Grafico geral</div>
                        <div class="card-body">

                            <canvas id="myCharts" height="72"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{ url(mix('public/plugins/jquery/jquery.min.js'))}}"></script>
    <script src="{{ url(mix('/public/plugins/chart.js/Chart.min.js'))}}"></script>

    <script type="text/javascript">
        var urlDados = '{{ route('grafico.dados') }}';
    </script>

@endsection