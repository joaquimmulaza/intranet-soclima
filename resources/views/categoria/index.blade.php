@extends('master.layout')
@section('title', 'Listagem de categorias')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Gestão de categorias</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold animated bounce infinite">Gestão de categorias</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th class="th-sm">Nome</th>
                                        <th class="th-sm">Descrição</th>
                                        @can('app.dashboard')
                                            <th class="th-sm">Ações</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorias as $categoria)
                                        <tr class="text-center">
                                            <th >
                                                <a href="{{route('categoria.show', ['categoria'=> $categoria])}}">
                                                    {{$categoria->titulo}}
                                                </a>
                                            </th>
                                            <th>
                                                {{Str::limit($categoria->descricao, 90)}}
                                            </th>
                                            <th class="text-center flex-row">
                                                @can('app.dashboard')
                                                    @can('app.roles.edit')
                                                        <a type="button" class="btn btn-sm btn-success rounded text-white"
                                                           href="{{route('categoria.edit', ['categoria' => $categoria->id])}}">
                                                           <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                <i class="fas fa-edit fa-w-20"></i>
                                                           </span>
                                                            Editar
                                                        </a>
                                                    @endcan

                                                    @can('app.roles.destroy')
                                                        <button type="button" class="btn btn-sm btn-danger rounded" onClick="deleteData({{ $categoria->id }})">
                                                               <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                    <i class="fas fa-trash-alt fa-w-20"></i>
                                                               </span>
                                                            Deletar
                                                        </button>
                                                        <form id="delete-form-{{ $categoria->id  }}"
                                                              action="{{route('categoria.destroy', ['categoria'=>$categoria->id])}}" method="POST" style="display: none;">
                                                            @csrf()
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                @endcan
                                            </th>
                                        </tr>
                                    @endforeach
                               </tbody>
                            </table>
                    </div>
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.categorias') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.categorias') }}">
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