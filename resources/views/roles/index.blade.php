@extends('master.layout')
@section('title', 'Roles')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Lista de roles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Gestão de permissão de acesso</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card card-primary card-outline">
                        <div class="table-responsive">
                            <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">Permissão</th>
                                        <th class="text-center">Data de criação</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key=>$role)
                                        <tr>
                                            <td class="text-center">
                                                {{ $role->name }}
                                            </td>

                                            <td class="text-center">
                                                @if ($role->permissions->count() > 0)
                                                    <span class="badge badge-info">{{ $role->permissions->count() }} permissões</span>
                                                @else
                                                    <span class="badge badge-danger">No permission found :(</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                {{ $role->created_at->diffForHumans() }}
                                            </td>

                                            <td class="text-center">
                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white" href="{{ route('role.edit', $role->id) }}">
                                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-edit fa-w-20"></i>
                                                       </span>
                                                        Editar
                                                    </a>
                                                @endcan

                                                @can('app.roles.destroy')
                                                    @if ($role->deletable == true)
                                                        <button type="button" class="btn btn-md btn-danger rounded" onClick="deleteData({{ $role->id }})">
                                                           <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                <i class="fas fa-trash-alt fa-w-20"></i>
                                                           </span>
                                                            Deletar
                                                        </button>
                                                        <form id="delete-form-{{ $role->id }}"
                                                              action="{{route('role.destroy', $role->id)}}" method="POST" style="display: none;">
                                                            @csrf()
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>

@endsection



