@extends('master.layout')
@section('title', 'Exibir usuário')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Configurações</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    {{-- CARD DE PERFIL --}}
                    <div class="card testimonial-card">
                        <div class="card-up aqua-gradient lighten-1"></div>

                        <div class="avatar mx-auto white">
                            {{configura()}}
                        </div>


                    </div>
                </div>


            </div>

        </div>
    </section>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

@endsection

