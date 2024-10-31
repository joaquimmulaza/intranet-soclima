@extends('master.layout')
@section('title', 'Listagem de usuários')



@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li> -->
                        <li class="breadcrumb-item active">Gestão de usuários</li>
                    </ol>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <section class="content" style="display: none;">
        <div class="container-fluid">
            

            <div class="row containerPrincipal">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 containerPrincipal">
                    <div class="main-card mb-3 card card-primary">
                        <div class="table-responsive">
                             <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Dias de Férias</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if(Cache::has('is_online' . $user->id))
                                                    <img class="online" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                                                @else
                                                    <img class="offline" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                                                @endif
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{$user->email}}</div>

                                                    @if(Cache::has('is_online' . $user->id))
                                                        <span class="badge badge-success">Online</span>
                                                    @else
                                                        <span class="badge badge-warning">Offline</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                {{ $user->diasFerias->dias_disponiveis ?? 0 }} dias
                                            </td>

                                            <td class="text-center">
                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white"
                                                       href="{{route('users.ferias', ['userId' => $user->id])}}">
                                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-edit fa-w-20"></i>
                                                       </span>
                                                        Atualizar Férias
                                                    </a>
                                                @endcan

                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white"
                                                       href="{{route('user.edit', ['user' => $user->id])}}">
                                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-edit fa-w-20"></i>
                                                       </span>
                                                        Editar
                                                    </a>
                                                @endcan

                                                @can('app.roles.destroy')
                                                    <button type="button" class="btn btn-md btn-danger rounded" onClick="deleteDataUser({{ $user->id }})">
                                                           <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                <i class="fas fa-trash-alt fa-w-20"></i>
                                                           </span>
                                                        Deletar
                                                    </button>
                                                    <form id="delete-user-form-{{ $user->id  }}"
                                                          action="{{route('user.destroy', ['user'=>$user->id])}}" method="POST" style="display: none;">
                                                        @csrf()
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                               </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.users') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.users') }}">
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


    <section class="content">
        <div class="user-management">
            <div class="search-bar">
                <input class="nav-link backgroundInput" placeholder="Pesquisar" type="text">
                <button><img src="logo/img/icon/filter.svg" alt=""></button>
            </div>
            <div class="user-grid">
                @foreach($users as $user)
                    <div class="user-card ">
                    @if(Cache::has('is_online' . $user->id))
                        <img class="online " src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                    @else
                        <img class="offline" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                    @endif
                        <div class="user-info">
                            <h3>{{ $user->name }}</h3>
                            <p style="padding: 0 !important; margin: 0 !important;">{{ $user->cargo->titulo}}</p>
                        </div>
                        <a class="edit-btn" href="{{route('user.edit', ['user' => $user->id])}}">Editar</a>
                        <!-- <button class="more-btn" data-toggle="modal" data-target="#modalOpt}">⋮</button> -->
                        <!-- <button class="more-btn"  data-toggle="modal" data-target="#modalOpt-{{ $user->id }}" style="margin: 0 !important; padding: 0 !important;">⋮</button> -->
                        <div class="containerOpt" style="">
                            <button class="btnOpt"  data-toggle="modal" data-target="#modalOpt-{{ $user->id }}" style="margin: 0 !important; padding: 0 !important;">⋮</button>
                            <div class="modal fade modalOpt" id="modalOpt-{{ $user->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt ">
                                        @can('app.dashboard')
                                            <button type="button" class="btnPosts" onClick="deleteData({{ $user->id }})">
                                                Eliminar
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#modalEdit" style="border-bottom: none;" class="btnPosts"  data-id="{{$user->id}}" data-title="{{$user->title}}" data-content="{{$user->content}}">
                                                Suspender
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#modalEdit" style="border-bottom: none;" class="btnPosts"  data-id="{{$user->id}}" data-title="{{$user->title}}" data-content="{{$user->content}}">
                                                Consultar férias
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#modalEdit" style="border-bottom: none;" class="btnPosts"  data-id="{{$user->id}}" data-title="{{$user->title}}" data-content="{{$user->content}}">
                                            <a href="{{route('user.show', ['user' => $user->id])}}">Ver dados</a>
                                            </button>
                                            <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                @endforeach
            </div>
        </div>
        
        
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('.modalOpt').on('show.bs.modal', function () {
        $('body').addClass('modal-open-no-backdrop');
        });

        $('.modalOpt').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open-no-backdrop');
        });

        $(document).on('click', function (event) {
            const $modal = $('.modalOpt');
            if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
                $modal.modal('hide');
            }
        });
    </script>

    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>

@endsection
