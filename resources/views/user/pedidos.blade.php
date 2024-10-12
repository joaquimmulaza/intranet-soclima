@extends('master.layout')
@section('title', 'Listagem de solicitações')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Solicitações de usuários pendentes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Gestão de pedido de utilização</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <div class="table-responsive">
                            @if($users->count() > 0)
                                <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">E-mail</th>
                                        <th class="text-center">Situação</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <th>
                                                <img class="offline" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                                            </th>
                                            <th>
                                                <div class="widget-content-left flex2">
                                                    <a class="btnList" href="{{ route('user.show', ['user' => $user->id]) }}">
                                                        <div class="widget-heading">{{ $user->name }}</div>
                                                    </a>
                                                    <div class="widget-subheading opacity-7">
                                                        @if ($user->role)
                                                            <span class="badge badge-info">{{ $user->role->name }}</span>
                                                        @else
                                                            <span class="badge badge-danger">No role found :(</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{$user->email}}</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="widget-content-left flex2">
                                                    @if ($user->status != 'inativo')
                                                        <span class="badge badge-danger">{{$user->status}}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{$user->status}}</span>
                                                    @endif
                                                </div>
                                            </th>

                                            <th class="text-center spacing">
                                                {{-- LIBERAR USUÁRIO --}}
                                                @can('app.roles.edit')
                                                    <button type="button" class="btn btn-md btn-success rounded text-white"
                                                            onClick="liberaData({{ $user->id }})">
                                                               <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                    <i class="fas fa-edit fa-w-20"></i>
                                                               </span>
                                                        Liberar pedido
                                                    </button>
                                                    <form id="delete-form-{{ $user->id  }}"
                                                          action="{{ route('user.liberar', ['user' => $user->id]) }}" style="display: none;">
                                                        @csrf()
                                                    </form>
                                                @endcan

                                                @can('app.roles.destroy')
                                                    @if($user->status == 'inativo')
                                                        <button type="button" class="btn btn-md btn-danger rounded"
                                                                onClick="bloqueaData({{ $user->id }})">
                                                                       <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                            <i class="fas fa-trash-alt fa-w-20"></i>
                                                                       </span>
                                                            Bloquear pedido
                                                        </button>
                                                        <form id="bloq-form-{{ $user->id  }}"
                                                              action="{{route('user.negar', ['user' => $user->id])}}" style="display: none;">
                                                            @csrf()
                                                        </form>
                                                    @endif
                                                @endcan
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="mt-5 mb-5 text-center">
                                    <h3 class="text-black-50 font-weight-bold">Não existe solicitações neste periodo!</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if( $users->count() > 0)
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
                    </div>
                @endif
            </div>
        </div>
    </section>
    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
@endsection