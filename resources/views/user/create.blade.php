@extends('master.layout')
@section('title', 'Cadastrar usuário')

@section('content')
    <script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($user) ? 'Editar' : 'Criar novo' }} usuário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{isset($user) ? route('user.update', $user->id) : route('user.store')}}"
                  id="roleFrom" role="form" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif
                <div class="row">
                    {{--USUÁRIO --}}
                    <section class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="card testimonial-card">
                            <div class="card-up aqua-gradient lighten-1"></div>

                            {{--MOSTRA AVATAR --}}
                            <div id="upload" class="text-center avatar mx-auto white file-upload-wrapper">
                                <img class="profile-user-img img-fluid img-circle" id="output"
                                     src="{{URL::to('/')}}/public/avatar_users/{{isset($user) ? $user->avatar : 'default.jpg'}}"
                                     alt="imagem do usuario">
                            </div>

                            <div class="card-body box-profile">
                                {{-- NAME--}}
                                <div class="md-form form-sm mt-0">
                                    <input id="titulo" name="name" type="text" class="form-control form-control-sm campotext @error('name') is-invalid @enderror"
                                           value="{{$user->name ?? old('name')}}" autofocus/>
                                    <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Nome</label>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>

                                {{-- EMAIL--}}
                                <div class="md-form form-sm">
                                    <input id="inputValidationEx" name="email" type="email" class="form-control form-control-sm validate @error('email') is-invalid @enderror"
                                           value="{{$user->email ?? old('email')}}"/>
                                    <label class="text-black-50 font-weight-bold text-md-left" for="inputValidationEx">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- PASSWORD--}}
                                <div class="md-form form-sm">
                                    <input id="inputPassword5MD" min="8" max="20" name="password" type="password"
                                           class="form-control form-control-sm validate @error('password') is-invalid @enderror"/>
                                    <label class="text-black-50 font-weight-bold text-md-left" for="inputPassword5MD">{{isset($user) ? 'Redefinir sua senha aqui' : 'Senha'}}</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- UPLOAD AVATAR--}}
                                <div class="md-form form-sm">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="avatar" name="avatar" onchange="loadfile(event)">
                                        <label class="custom-file-label align-items-start" for="avatar">Sua foto</label>
                                    </div>
                                </div>

                                @can('app.dashboard')
                                    {{-- CARGO--}}
                                    <div class="form-group">
                                        <select id="cargo_id" class="form-control form-control-sm" style="width: 100%;" name="cargo" placeholder="Escolha o cargo">
                                            <option disabled selected>Selecione o cargo</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{$cargo->id}}"
                                                 @if(isset($user) && $user->cargo && $user->cargo->id == $cargo->id) selected="selected" @endif>
                                                   {{$cargo->titulo}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- UNIDADE (Departamento)--}}
                                    <div class="form-group">
                                        <select id="unidade" class="js-basic-multiple form-control form-control-sm" style="width: 100%;" name="unidade">
                                            <option disabled selected>Selecione o departamento</option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{$unidade->id}}"
                                                @if(isset($user) && $user->unidade && $user->unidade->id == $unidade->id) selected="selected" @endif>
                                                   {{$unidade->titulo}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- FUNÇÃO--}}
                                    <div class="form-group">
                                        <select id="role" class="js-basic-multiple form-control form-control-sm" style="width: 100%;" name="role">
                                            <option disabled selected>Permissões no sistema</option>
                                            @foreach($funcoes as $funcao)
                                                <option value="{{$funcao->id}}"
                                                @if(isset($user) && $user->role && $user->role->id == $funcao->id) selected="selected" @endif>
                                                   {{$funcao->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </section>

                    {{-- CAMPOS ADICIONAIS --}}
                    <section class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card-body box-profile">
                            <p class="text-black-50 font-weight-bold text-md-left">Dados de Identificação</p>
                            <div class="form-row">

                                {{-- Número Mecanográfico --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <input id="numero_mecanografico" name="numero_mecanografico" type="text"
                                        class="form-control form-control-sm @error('numero_mecanografico') is-invalid @enderror"
                                        value="{{ $user->numero_mecanografico ?? old('numero_mecanografico') }}" />
                                    <label for="numero_mecanografico">Número Mecanográfico</label>
                                </div>

                                {{-- Nº do BI --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <input id="numero_bi" name="numero_bi" type="text" 
                                        class="form-control form-control-sm @error('numero_bi') is-invalid @enderror"
                                        value="{{ $user->numero_bi ?? old('numero_bi') }}" />
                                    <label for="numero_bi">Nº do BI</label>
                                </div>

                                {{-- Nº de Beneficiário --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <input id="numero_beneficiario" name="numero_beneficiario" type="text"
                                        class="form-control form-control-sm @error('numero_beneficiario') is-invalid @enderror"
                                        value="{{ $user->numero_beneficiario ?? old('numero_beneficiario') }}" />
                                    <label for="numero_beneficiario">Nº de Beneficiário</label>
                                </div>

                                {{-- Nº de Contribuinte --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <input id="numero_contribuinte" name="numero_contribuinte" type="text"
                                        class="form-control form-control-sm @error('numero_contribuinte') is-invalid @enderror"
                                        value="{{ $user->numero_contribuinte ?? old('numero_contribuinte') }}" />
                                    <label for="numero_contribuinte">Nº de Contribuinte</label>
                                </div>

                                {{-- Data de Admissão --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label for="data_admissao">Data de Admissão</label>
                                    <input id="data_admissao" name="data_admissao" type="date"
                                        class="form-control form-control-sm @error('data_admissao') is-invalid @enderror"
                                        value="{{ $user->data_admissao ?? old('data_admissao') }}" />
                                </div>

                                {{-- Data de Emissão e Validade do BI --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label for="data_emissao_bi">Data de Emissão do BI</label>
                                    <input id="data_emissao_bi" name="data_emissao_bi" type="date"
                                        class="form-control form-control-sm @error('data_emissao_bi') is-invalid @enderror"
                                        value="{{ $user->data_emissao_bi ?? old('data_emissao_bi') }}" />
                                </div>

                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label for="data_validade_bi">Data de Validade do BI</label>
                                    <input id="data_validade_bi" name="data_validade_bi" type="date"
                                        class="form-control form-control-sm @error('data_validade_bi') is-invalid @enderror"
                                        value="{{ $user->data_validade_bi ?? old('data_validade_bi') }}" />
                                </div>

                                {{-- Data de Nascimento --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label for="nascimento">Data de Nascimento</label>
                                    <input id="nascimento" name="nascimento" type="date"
                                        class="form-control form-control-sm @error('nascimento') is-invalid @enderror"
                                        value="{{ $user->nascimento ?? old('nascimento') }}" />
                                </div>

                                {{-- Nº de Telefone --}}
                                <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <input id="fone" name="fone" type="text"
                                        class="form-control form-control-sm @error('fone') is-invalid @enderror"
                                        value="{{ $user->fone ?? old('fone') }}" />
                                    <label for="numero_contribuinte">Nº de Telefone</label>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
                
                {{-- BOTÕES--}}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="submit" class="btn btn-success rounded">
                            @isset($user)
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                     <i class="fas fa-edit fa-w-20"></i>
                                </span>
                                Atualizar usuário
                            @else
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="far fa-save fa-w-20"></i>
                                </span>
                                Salvar novo usuário
                            @endisset
                        </button>

                        @isset($user)
                            <a type="button" class="btn btn-danger rounded" href="{{route('user.index')}}">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fas fa-eraser fa-w-20"></i>
                                </span>
                                Cancelar
                            </a>
                        @else
                            <button type="reset" class="btn btn-danger rounded">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fas fa-eraser fa-w-20"></i>
                                </span>
                                Limpar
                            </button>
                         @endisset
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        var loadfile = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        }

        document.getElementById('roleFrom').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio do formulário para verificar os dados
    const formData = new FormData(this); // Cria um objeto FormData
    for (let [name, value] of formData.entries()) {
        console.log(name, value); // Exibe o nome do campo e o valor
    }
    
    // Opcionalmente, remova o preventDefault() para deixar o formulário enviar os dados após a inspeção
    this.submit(); // Envia o formulário após o debug (pode remover se não quiser que envie imediatamente)
});

    </script>
@endsection
