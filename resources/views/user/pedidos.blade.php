@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')


{{-- CABEÇALHO BREADCRUMB--}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                  
                    <li class="breadcrumb-item active">Gerenciar pedidos de férias</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

    <div class="container-fluid">
        <div >
            <div>
                <div>
                    <div>
                        @if($ferias->count() > 0)
                            @foreach($ferias as $feria)
                                <div class="containerPrincipal ContainerFerias">
                                    <div class="boxStatusFerias">
                                        <span class="status">Pendente</span>
                                        <div class="contentboxStatus">
                                            <span class="nameUser">
                                                @if ($feria->user)
                                                    {{ $feria->user->name }}
                                                @else
                                                    Usuário não encontrado
                                                @endif
                                            </span>
                                            <span class="descBoxStatus">Solicitou férias | Aguardando resposta do chefe directo</span>
                                        </div>

                                        @if($feria->status == 'Pendente')
                                            <div class="buttons">
                                                {{-- Aprovar ou Rejeitar Pedido --}}
                                                {{-- Remover o @can para testar --}}
                                                {{-- @can('app.roles.edit') --}}
                                                    <button class="button approve" ><a href="{{ route('ferias.aprovar', $feria->id) }}">Aprovar</a></button>
                                                    <button class="button reject">
                                                        <a  href="{{ route('ferias.rejeitar', $feria->id) }}">Rejeitar</a>
                                                    </button>
                                                {{-- @endcan --}}
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
                        @else
                            <div style="text-align: center; width: 1080px; margin: 0 auto;">
                                <div class="imgEmptyPage">
                                    <img src="logo/img/icon/holiday_icon.svg" alt="">
                                </div>
                                <div class="textEmptyPage">
                                    <h3>De momento não há solicitações de férias</h3>
                                    <p>As solicitações de férias do departamento que você lidera serão exibidas aqui assim que forem enviadas.</p>
                                </div>
                            </div>
                        @endif




<section class="containerPrincipal" style="display: none;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="main-card mb-3 card card-primary">
                    <div class="table-responsive">
                        @if($ferias->count() > 0)
                            <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Funcionário</th>
                                    <th class="text-center">Data de Início</th>
                                    <th class="text-center">Data de Fim</th>
                                    <th class="text-center">Dias Solicitados</th>
                                    <th class="text-center">Data Retorno Prevista</th>
                                    <th class="text-center">Situação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ferias as $feria)
                                    <tr>
                                        <th class="text-center">
                                            @if ($feria->user)
                                                {{ $feria->user->name }}
                                            @else
                                                Usuário não encontrado
                                            @endif
                                        </th>
                                        <th class="text-center">{{ $feria->data_inicio }}</th>
                                        <th class="text-center">{{ $feria->data_fim }}</th>
                                        <th class="text-center">{{ $feria->diasSolicitados() }}</th>
                                        <th class="text-center">{{ $feria->data_retorno_prevista }}</th>
                                        <th class="text-center">
                                            <span class="badge badge-warning">{{ $feria->status }}</span>
                                        </th>

                                        <th class="text-center spacing">
                                            {{-- Aprovar ou Rejeitar Pedido --}}
                                            @can('app.roles.edit')
                                                <button type="button" class="btn btn-md btn-success rounded text-white"
                                                        onClick="aprovarFeria({{ $feria->id }})">
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fas fa-check fa-w-20"></i>
                                                    </span>
                                                    Aprovar
                                                </button>
                                                <form id="aprovar-form-{{ $feria->id }}" action="{{ route('ferias.aprovar', $feria->id) }}" style="display: none;" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>

                                                <button type="button" class="btn btn-md btn-danger rounded text-white"
                                                        onClick="rejeitarFeria({{ $feria->id }})">
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fas fa-times fa-w-20"></i>
                                                    </span>
                                                    Rejeitar
                                                </button>
                                                <form id="rejeitar-form-{{ $feria->id }}" action="{{ route('ferias.rejeitar', $feria->id) }}" style="display: none;" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                            @endcan
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @else
                            <div class="mt-5 mb-5 text-center">
                                <h3 class="text-black-50 font-weight-bold">Não há pedidos de férias pendentes!</h3>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($ferias->count() > 0)
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.pedidos') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.pedidos') }}">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-excel fa-w-20"></i>
                            </span>
                            Baixar Excel
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>




@endsection
