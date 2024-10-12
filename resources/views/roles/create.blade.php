@extends('master.layout')
@section('title', 'Criar regra de acesso')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($role) ? 'Editar' : 'Criar nova' }} Função</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            {{--FORMULÁRIO DE UPDATE OU CREATE:: --}}
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form action="{{isset($role) ? route('role.update', $role->id) : route('role.store')}}"
                                  id="roleFrom" role="form" method="POST">
                            @csrf
                            @if (isset($role))
                                @method('PUT')
                            @endif
                                <div class="card-body">
                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{ isset($role) ? 'Editar' : 'Criar nova' }} funções de acesso</h3>

                                    <div class="md-form form-sm">
                                        <input id="name" name="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror"
                                               value="{{$role->name ?? old('name')}}" autofocus/>
                                        <label class="text-black-50 font-weight-bold text-md-left" for="name">Nome da função de acesso</label>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <strong>Administração de regras de acesso</strong>
                                        @error('permissions')
                                            <p class="p-2">
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select-all">
                                            <label class="custom-control-label" for="select-all">Selecionar todas</label>
                                        </div>
                                    </div>

                                    @forelse($modules->chunk(2) as $key => $chunks)
                                        <div class="form-row">
                                            @foreach($chunks as $key=>$module)
                                                <div class="col">
                                                    <h5>Modulo: {{ $module->name }}</h5>
                                                    @foreach($module->permissions as $key=>$permission)
                                                        <div class="mb-6 ml-4">
                                                            <div class="custom-control custom-checkbox mb-2">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="permission-{{ $permission->id }}"
                                                                       value="{{ $permission->id }}"
                                                                       name="permissions[]"
                                                                        @if(isset($role))
                                                                            @foreach($role->permissions as $rPermission)
                                                                                {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                                            @endforeach
                                                                        @endif
                                                                >
                                                                <label class="custom-control-label"
                                                                       for="permission-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @empty
                                        <div class="row">
                                            <div class="col text-center">
                                                <strong>Modulo não encontrado!</strong>
                                            </div>
                                        </div>
                                    @endforelse

                                    <button type="submit" class="btn btn-success rounded">
                                        @isset($role)
                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-edit fa-w-20"></i>
                                            </span>
                                        Atualizar
                                        @else
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="far fa-save fa-w-20"></i>
                                            </span>
                                            Salvar
                                            @endisset
                                    </button>

                                    @isset($role)
                                        <a type="button" class="btn btn-danger rounded" href="{{route('role.index')}}">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-eraser fa-w-20"></i>
                                            </span>
                                            Cancelar
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-danger rounded" onClick="limpaForm()">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-eraser fa-w-20"></i>
                                            </span>
                                            limpar
                                        </button>
                                    @endisset
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('partialspost_js')
    <script src="{{asset('frontend/roles/scriptRoles.js')}}"></script>
@endsection


