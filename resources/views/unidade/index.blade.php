@extends('master.layout')
@section('title', 'Listagem de unidades')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Lista de unidades</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Gestão de unidades</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                         <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nome</th>
                                        <th>Ramal</th>
                                        <th>Descrição</th>
                                        @can('app.dashboard')
                                            <th>Ações</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unidades as $unidade)
                                        <tr class="text-center">
                                            <th>
                                                <a href="{{route('unidade.show', ['unidade'=> $unidade])}}">
                                                    {{$unidade->titulo}}
                                                </a>
                                            </th>
                                            <th>
                                                  {{$unidade->ramal}}
                                            </th>
                                            <th>
                                                {{$unidade->descricao}}
                                            </th>
                                            @can('app.dashboard')
                                                <th>
                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white"
                                                       href="{{route('unidade.edit', ['unidade' => $unidade->id])}}">
                                                   <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fas fa-edit fa-w-20"></i>
                                                   </span>
                                                        Editar
                                                    </a>
                                                @endcan

                                                @can('app.roles.destroy')
                                                    <button type="button" class="btn btn-md btn-danger rounded" onClick="deleteData({{ $unidade->id }})">
                                                       <span class="btn-icon-wrapper pr-2 opacity-9">
                                                            <i class="fas fa-trash-alt fa-w-20"></i>
                                                       </span>
                                                        Deletar
                                                    </button>
                                                    <form id="delete-form-{{ $unidade->id  }}"
                                                          action="{{route('unidade.destroy', ['unidade'=>$unidade->id])}}" method="POST" style="display: none;">
                                                        @csrf()
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </th>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.unidades') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.unidades') }}">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-excel fa-w-20"></i>
                            </span>
                            Baixar Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @can('app.dashboard')
    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
    @endcan
@endsection