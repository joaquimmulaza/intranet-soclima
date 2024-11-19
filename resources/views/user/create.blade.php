@extends('master.layout')
@section('title', 'Cadastrar usuário')
<!-- Incluir o CSS do Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Incluir jQuery -->



@section('content')
    <script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li> -->
                        <li class="breadcrumb-item active">{{ isset($user) ? 'Editar' : 'Cadastrar' }} trabalhador</li>
                    </ol>
                    
                </div>
            </div>
        </div>
        <hr>
    </div>

    <section class="content">
        <div class="container-fluid">
           

            <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
            @csrf
            @if (isset($user))
                @method('PUT') <!-- Método PUT para edição -->
            @endif
                
                <div class="row justify-content-between contentDatasUser">
                    {{--USUÁRIO --}}
                    <section class="col-sm-12 col-md-3 col-lg-3 col-xl-3 leftSideDataUser">
                        <div class="card testimonial-card cardDataUser">

                            {{--MOSTRA AVATAR --}}
                            <div id="upload" class="cardAvatar file-upload-wrapper">
                            <img id="output"
                                src="{{URL::to('/')}}/public/avatar_users/{{isset($user) ? $user->avatar : 'cardAvatar.svg'}}"
                                alt="imagem do usuario"
                                onclick="document.getElementById('avatar').click()"
                                style="cursor: pointer; width: 131px; object-fit: cover;">
                                <input type="file" id="avatar" name="avatar" style="display: none;" accept="image/*" onchange="loadFile(event)">
                            </div>

                            <div class="card-body box-profile">
                                {{-- NAME--}}
                                <div class="cardUserInputs">
                                    <label for="titulo">Nome*</label>
                                    <input id="titulo" name="name" type="text" class="form-control form-control-sm campotext @error('name') is-invalid @enderror"
                                           value="{{$user->name ?? old('name')}}" autofocus required/>
                                    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>

                                
                                <div class="doubleInput">
                                {{-- Data de Nascimento --}}
                                <div class="cardUserInputs paddingTop">
                                        <label for="nascimento">Data de Nascimento*</label>
                                        <input id="nascimento" name="nascimento" type="date"
                                            class="form-control form-control-sm @error('nascimento') is-invalid @enderror"
                                            value="{{ $user->nascimento ?? old('nascimento') }}" required/>
                                    </div>

                                    {{-- Nº do BI --}}
                                    <div class="cardUserInputs paddingTop">
                                        <label class="text-md-left" for="numero_bi">Nº do Bilhete de Identidade*</label>
                                        <input id="numero_bi" name="numero_bi" type="text"
                                            class="form-control form-control-sm @error('numero_bi') is-invalid @enderror"
                                            value="{{ $user->numero_bi ?? old('numero_bi') }}" required/>
                                    </div>
                                          
                                </div>

                                

                                

                                {{-- Data de Emissão e Validade do BI --}}
                                <div class="cardUserInputs paddingTop">
                                    <label for="data_emissao_bi">Data de Emissão do BI*</label>
                                    <input id="data_emissao_bi" name="data_emissao_bi" type="date"
                                        class="form-control form-control-sm @error('data_emissao_bi') is-invalid @enderror"
                                        value="{{ $user->data_emissao_bi ?? old('data_emissao_bi') }}" />
                                </div>

                                <div class="cardUserInputs paddingTop">
                                    <label for="data_validade_bi">Data de Validade do BI*</label>
                                    <input id="data_validade_bi" name="data_validade_bi" type="date"
                                        class="form-control form-control-sm @error('data_validade_bi') is-invalid @enderror"
                                        value="{{ $user->data_validade_bi ?? old('data_validade_bi') }}" required/>
                                </div>

                                

                                

                                {{-- UPLOAD AVATAR--}}
                                <!-- <div class="md-form form-sm">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="avatar" name="avatar" onchange="loadfile(event)">
                                        <label class="custom-file-label align-items-start" for="avatar">Sua foto</label>
                                    </div>
                                </div> -->

                                @can('app.dashboard')
                                    

                                    


                                    {{-- GÊNERO --}}
                                <div class="containerGender paddingTop">
                                    <label class="">Gênero*</label>

                                    <div class="containerRadios">
                                        <!-- Rádio Masculino -->
                                        <div class="radiosElement">
                                            <label style="margin: 0 !important; padding: 0 !important;" for="genero_masculino">Masculino</label>
                                            <input type="radio" id="genero_masculino" name="genero" value="masculino"
                                                @if(isset($user) && $user->genero == 'masculino') checked="checked" @endif>
                                        
                                        </div>
                                        <!-- Rádio Feminino -->
                                        <div class="radiosElement">
                                            <label style="margin: 0 !important; padding: 0 !important;" for="genero_feminino">Feminino</label>
                                            <input type="radio" id="genero_feminino" name="genero" value="feminino"
                                                @if(isset($user) && $user->genero == 'feminino') checked="checked" @endif>
                                        </div>
                                    </div>
                                    @error('genero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endcan

                                {{-- Nº de Beneficiário --}}
                                <div class="cardUserInputs">
                                <label for="numero_beneficiario">Nº de Beneficiário*</label>
                                    <input id="numero_beneficiario" name="numero_beneficiario" type="text"
                                        class="form-control form-control-sm @error('numero_beneficiario') is-invalid @enderror"
                                        value="{{ $user->numero_beneficiario ?? old('numero_beneficiario') }}" required/>
                                    
                                </div>

                                {{-- Nº de Contribuinte --}}
                                <div class="cardUserInputs paddingTop">
                                <label for="numero_contribuinte">Nº de Contribuinte* </label>
                                    <input id="numero_contribuinte" name="numero_contribuinte" type="text"
                                        class="form-control form-control-sm @error('numero_contribuinte') is-invalid @enderror"
                                        value="{{ $user->numero_contribuinte ?? old('numero_contribuinte') }}" required/>
                                    
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- CAMPOS ADICIONAIS --}}
                    <section class="col-sm-12 col-md-6 col-lg-6 col-xl-6 rightSideDataUser">
                        <div class="card-body box-profile">
                        {{-- EMAIL--}}
                            <div class="cardUserInputs">
                                <label for="inputValidationEx">Email</label>
                                <input id="inputValidationEx" name="email" type="email" class="form-control form-control-sm validate @error('email') is-invalid @enderror"
                                        value="{{$user->email ?? old('email')}}"/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- PASSWORD--}}
                            <!-- <div class="cardUserInputs paddingTop">
                                <label for="inputPassword5MD">{{isset($user) ? 'Redefinir sua senha aqui' : 'Senha'}}</label>
                                <input id="inputPassword5MD" min="8" max="20" name="password" type="password"
                                        class="form-control form-control-sm validate @error('password') is-invalid @enderror"/>
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div> -->
                      

                                {{-- Número Mecanográfico --}}
                                <div class="cardUserInputs paddingTop">
                                    <label for="numero_mecanografico">Número Mecanográfico</label>
                                    <input id="numero_mecanografico" name="numero_mecanografico" type="text"
                                        class="form-control form-control-sm @error('numero_mecanografico') is-invalid @enderror"
                                        value="{{ $user->numero_mecanografico ?? old('numero_mecanografico') }}" />
                                    
                                </div>

                                

                                {{-- Nº de Telefone --}}
                                <div class="cardUserInputs paddingTop">
                                    <label for="fone">Nº de Telefone*</label>
                                    <input id="fone" name="fone" type="text"
                                        class="form-control form-control-sm @error('fone') is-invalid @enderror"
                                        value="{{ $user->fone ?? old('fone') }}" required/>
                                    
                                </div>
                                {{-- Data de Admissão --}}
                                <div class="cardUserInputs paddingTop">
                                    <label for="data_admissao">Data de Admissão</label>
                                    <input id="data_admissao" name="data_admissao" type="date"
                                        class="form-control form-control-sm @error('data_admissao') is-invalid @enderror"
                                        value="{{ $user->data_admissao ?? old('data_admissao') }}" />
                                </div>
                                {{-- FUNÇÃO--}}
                                    <div class="cardUserInputs paddingTop">
                                        <label for="role">Permissões no sistema</label>
                                        <select id="role" class="js-basic-multiple teste form-control form-control-sm" style="width: 100%;" name="role" required>
                                            <option disabled selected>Selecionar Permissão</option>
                                            @foreach($funcoes as $funcao)
                                                <option value="{{$funcao->id}}"
                                                @if(isset($user) && $user->role && $user->role->id == $funcao->id) selected="selected" @endif>
                                                   {{$funcao->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    {{-- CARGO--}}
                                    <div class="cardUserInputs paddingTop">
                                        <label for="cargo">Cargo*</label>
                                        <select id="cargo_id" class="form-control form-control-sm" style="width: 100%;" name="cargo" placeholder="Escolha o cargo" required>
                                            <option disabled selected>Selecione o cargo*</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{$cargo->id}}"
                                                 @if(isset($user) && $user->cargo && $user->cargo->id == $cargo->id) selected="selected" @endif>
                                                   {{$cargo->titulo}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- UNIDADE (Departamento) --}}
                                    <div class="cardUserInputs paddingTop">
                                        <label for="unidade">Departamento</label>
                                        <select id="unidade" class="js-basic-multiple teste form-control form-control-sm" style="width: 100%;" name="unidade">
                                            <option></option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{$unidade->id}}"
                                                    @if(isset($user) && $user->unidade && $user->unidade->id == $unidade->id) selected="selected" @endif>
                                                    {{$unidade->titulo}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                {{-- SELEÇÃO DE RESPONSÁVEIS --}}
                                <div class="cardUserInputs paddingTop">
                                    <label for="responsavel_id">Responsável do departamento</label>
                                    <select id="responsavel_id" class="form-control js-multiple-select" name="responsavel_id">
                                        <option disabled selected>Selecione o responsável</option>
                                        @foreach($responsaveis as $responsavel)
                                            <option value="{{ $responsavel->id }}"
                                                @if(isset($user) && $user->responsavel_id == $responsavel->id) selected="selected" @endif>
                                                {{ $responsavel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- BOTÕES--}}
                                <div class="row paddingTop">
                                    <div class="ContainerBtnSaveUser col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <button type="submit" class="btn rounded">
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
                                            <button type="reset" class="btn rounded">
                                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                                    <i class="fas fa-eraser fa-w-20"></i>
                                                </span>
                                                Limpar
                                            </button>
                                        @endisset
                                    </div>
                                </div>
                        </div>
                    </section>
                </div>
                
                
            </form>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Incluir o JS do Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

    $(document).ready(function() {
            // Inicializando o Select2
            $('#unidade').select2({
                placeholder: "Digite para pesquisar o departamento",  // Placeholder de pesquisa
                allowClear: true,
                minimumInputLength: 1,
                tags: false,
                language: {
                noResults: function() {
                    return "Nenhum resultado encontrado"; // Mensagem personalizada
                    },
                inputTooShort: function() {
                    return ""; // Mensagem personalizada quando o usuário digita menos do que o necessário
                }
                }  // Permitir limpar a seleção
            })
            
    });

     // Função para carregar a imagem selecionada como prévia
     function loadFile(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // libera a memória
        }
    }
    </script>
@endsection
