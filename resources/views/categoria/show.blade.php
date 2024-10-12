@extends('master.layout')
@section('title', 'Exibir categoria')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Categoria</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <div class="card-header p-2">
                            <h2 class="ml-2 text-black-50 font-weight-bold animated bounce infinite">Categoria</h2>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <h3 class="text-black-50 font-weight-bold animated bounce infinite">{{$categoria->titulo}}</h3>

                                <p>{{$categoria->descricao}}</p>
                                <span class="description"><i class="far fa-clock"></i> Criada em - {{ date('d/m/yy H:II', strtotime($categoria->created_at)) }}</span>
                                <hr/>
                                <div class="footer">
                                    @can('app.dashboard')
                                        <a type="button" class="btn btn-md btn-success rounded text-white"
                                           href="{{route('categoria.edit', ['categoria' => $categoria->id])}}">
                                               <span class="btn-icon-wrapper pr-2 opacity-7">
                                                    <i class="fas fa-edit fa-w-20"></i>
                                               </span>
                                            Editar
                                        </a>
                                    @endcan


                                    <a type="button" class="btn btn-md btn-danger rounded" href="{{route('categoria.index')}}">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-angle-double-left fa-w-20"></i>
                                            </span>
                                        Voltar
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
