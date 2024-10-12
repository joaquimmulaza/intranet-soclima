@extends('master.layout')
@section('title', 'Listagem de questionarios')

@section('content')
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Lista de questionários</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left animated bounce infinite">Gestão de questionarios</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <table id="datatable" class="table-responsive-sm table table-fixed table-striped table-hover  dataTables_scrollBody">
                                <thead>
                                    <tr class="table-light table-responsive-sm text-center dataTables_scrollBody">
                                        <th class="th-sm" style="width: 220px;">Nome</th>
                                        <th class="th-sm">Descrição</th>
                                        <th class="th-sm" style="width: 90px;">Questões</th>
                                        <th class="th-sm" style="width: 100px;;">Término</th>
                                        <th class="th-sm" style="width: 90px;;">Status</th>
                                        <th class="th-sm">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($questionarios as $questionario)
                                    <tr class="table-responsive-sm text-center dark-grey-text text-capitalize">
                                        <th class="dataTables_scrollBody col">
                                            <a class="font-weight-bold text-black-50" href="{{route('questionario.show', ['questionario'=> $questionario->id])}}">
                                                {{Str::limit($questionario->title, 35)}}
                                            </a>
                                        </th>
                                        <th class="col">
                                            {{Str::limit($questionario->content, 80)}}
                                        </th>
                                        <th class="col">
                                            {{$questionario->questions()->count()}}
                                        </th>
                                        <th class="col">
                                            @if(date('d/m/Y', strtotime($questionario->validate_at)) < \Illuminate\Support\Facades\Date::now()->format('d/m/Y'))
                                                <span class="badge bg-danger p-2 rounded"><i class="fas fa-caret-down mr-1"></i> {{date('d/m/Y', strtotime($questionario->validate_at))}}</span>
                                            @else
                                                <span class="badge bg-success p-2 rounded"><i class="fas fa-check mr-1"></i>{{date('d/m/Y', strtotime($questionario->validate_at))}}</span>
                                            @endif
                                        </th>
                                        <th class="col">
                                            @if($questionario->status == 'Finalizado')
                                                <span class="badge bg-success p-2 rounded">{{$questionario->status}}</span>
                                            @else
                                                <span class="badge bg-danger p-2 rounded">{{$questionario->status}}</span>
                                            @endif
                                        </th>

                                        <th class="col text-center flex-row">
                                            @can('app.roles.edit')
                                            <a type="button" class="btn btn-sm btn-success rounded text-white"
                                               href="{{route('questionario.edit', ['questionario' => $questionario->id])}}">
                                                   <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fas fa-edit fa-w-20"></i>
                                                   </span>
                                                Editar
                                            </a>
                                            @endcan

                                            @can('app.roles.destroy')
                                            <button type="button" class="btn btn-sm btn-danger rounded" onClick="deleteData({{ $questionario->id }})">
                                                       <span class="btn-icon-wrapper pr-2 opacity-9">
                                                            <i class="fas fa-trash-alt fa-w-20"></i>
                                                       </span>
                                                Deletar
                                            </button>
                                            <form id="delete-form-{{ $questionario->id  }}"
                                                  action="{{route('questionario.destroy', ['questionario' => $questionario->id])}}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                            @endcan
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.questionarios') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.questionarios') }}">
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
    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>


@endsection