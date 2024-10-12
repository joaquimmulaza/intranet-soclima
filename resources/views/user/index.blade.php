@extends('master.layout')
@section('title', 'Listagem de usuários')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Gestão de usuários</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Gestão de usuários</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <div class="table-responsive">
                             <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">Email</th>
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
    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>


@endsection