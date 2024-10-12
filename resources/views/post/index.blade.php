@extends('master.layout')
@section('title', 'Geral de noticias')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Gestão de notícias</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left animated bounce infinite">Gestão de notícias</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <table id="datatable" class="table-responsive-sm table table-fixed table-striped table-hover  dataTables_scrollBody">
                            <thead>
                            <tr class="table-light table-responsive-sm text-center dataTables_scrollBody">
                                <th class="th-sm">Titulo</th>
                                <th class="th-sm">validade</th>
                                <th class="th-sm"><i class="far fa-eye text-sm-center"></i></th>
                                <th class="th-sm">Descrição</th>
                                @can('app.dashboard')
                                <th class="th-sm">Ações</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr class="table-responsive-sm text-center dark-grey-text text-capitalize">
                                    <th class="col text-left">
                                        @can('app.dashboard')
                                        <a class="mb-3 dark-grey-text mt-0" href="{{route('post.show', ['post'=> $post])}}">
                                            {{Str::limit($post->title, 30)}}
                                        </a>
                                        @elsecan('app.users.index')
                                        {{Str::limit($post->title, 30)}}
                                        @endcan
                                    </th>
                                    <th class="col">
                                        <span class="badge bg-primary p-2 rounded"><i class="fas fa-caret-down mr-1"></i> {{date('d/m/Y', strtotime($post->validate_at))}}</span>
                                    </th>
                                    <th class="col">
                                        {{ $post->view }}
                                    </th>
                                    <th class="col">
                                        {{Str::limit($post->subtitle, 50)}}
                                    </th>
                                    @can('app.dashboard')
                                    <th class="col text-center flex-row">
                                        @can('app.roles.edit')
                                        <a type="button" class="btn btn-sm btn-success rounded text-white"
                                           href="{{route('post.edit', ['post' => $post->id])}}">
                                               <span class="btn-icon-wrapper opacity-9">
                                                    <i class="fas fa-edit fa-w-20"></i>
                                               </span>
                                            Editar
                                        </a>
                                        @endcan

                                        @can('app.roles.destroy')
                                        <button type="button" class="btn btn-sm btn-danger rounded text-white" onClick="deleteData({{ $post->id }})">
                                                           <span class="btn-icon-wrapper opacity-9">
                                                                <i class="fas fa-trash-alt fa-w-20"></i>
                                                           </span>
                                            Deletar
                                        </button>
                                        <form id="delete-form-{{ $post->id  }}"
                                              action="{{route('post.destroy', ['post'=>$post->id])}}" method="POST" style="display: none;">
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
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.noticias') }}" target="_blank">
                        <span class="btn-icon-wrapper pr-2 opacity-3">
                            <i class="far fa-file-pdf fa-w-20"></i>
                        </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.noticias') }}">
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