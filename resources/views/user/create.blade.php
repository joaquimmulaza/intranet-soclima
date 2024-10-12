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
                                    <label class="text-black-50 font-weight-bold text-md-left" for="inputValidationEx" data-error="incorreto">Email</label>
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
                                    <label class="text-black-50 font-weight-bold text-md-left" for="inputPassword5MD" data-error="incorreto">{{isset($user) ? 'Redefinir sua senha aqui' : 'Senha'}}</label>
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
                                        <select id="card_id" class="form-control form-control-sm" style="width: 100%;" name="cargo" placeholder="Escolha cargo">
                                            <option disabled selected>Selecione um  cargo</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{$cargo->id}}"
                                                 @if(isset($user))
                                                    @if(!$user->cargo == null)
                                                        @if($user->cargo->id == $cargo->id)
                                                            selected="selected"
                                                        @endif
                                                    @endif
                                                 @endif
                                                   >{{$cargo->titulo}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- UNIDAE--}}
                                    <div class="form-group">
                                        <select id="unidade" class="js-basic-multiple form-control form-control-sm" style="width: 100%;" name="unidade">
                                            <option disabled selected>Selecione uma unidade</option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{$unidade->id}}"
                                                @if(isset($user))
                                                    @if(!$user->unidade == null)
                                                        @if($user->unidade->id == $unidade->id)
                                                           selected="selected"
                                                        @endif
                                                    @endif
                                                @endif
                                                >{{$unidade->titulo}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- FUNÇÃO--}}
                                    <div class="form-group">
                                        <select id="role" class="js-basic-multiple form-control form-control-sm" style="width: 100%;" name="role">
                                            <option disabled selected>Selecione função</option>
                                            @foreach($funcoes as $funcao)
                                                <option value="{{$funcao->id}}"
                                                @if(isset($user))
                                                    @if(!$user->role == null)
                                                        @if($user->role->id == $funcao->id)
                                                           selected="selected"
                                                        @endif
                                                    @endif
                                                @endif
                                                >{{$funcao->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </section>

                    {{-- DADOS COMPLEMENTARES--}}
                    <section class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                        <div class="row card card-primary card-outline" style="width: 100%;">
                            <div class="row">
                                {{--ENDEREÇO --}}
                                <section class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card-body box-profile">
                                        <p class="text-black-50 font-weight-bold text-md-left">Endereço</p>
                                         <div class="form-row">

                                            {{-- STREET--}}
                                            <div class="md-form form-sm col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                                <input id="street" name="street" type="text" required="required"
                                                       class="form-control form-control-sm campotext @error('street') is-invalid @enderror"
                                                       value="{{$user->endereco->street ?? old('street')}}"/>
                                                <label class="text-black-50 font-weight-bold text-md-left" for="street">Rua</label>
                                            </div>

                                             {{-- NUMBER--}}
                                            <div class="md-form form-sm col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                <input id="number" name="number" type="number" required="required"
                                                       class="form-control form-control-sm @error('number') is-invalid @enderror"
                                                        value="{{$user->endereco->number ?? old('number')}}"/>
                                                <label class="text-black-50 font-weight-bold text-md-left" for="number">número</label>
                                            </div>

                                             {{-- CEP--}}
                                            <div class="md-form form-sm col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <input type="text" class="form-control form-control-sm @error('cep') is-invalid @enderror" name="cep" id="cep"
                                                       required="required" value="{{$user->endereco->cep ?? old('cep')}}">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="cep">Cep</label>
                                            </div>

                                             {{-- BAIRRO--}}
                                            <div class="md-form form-sm col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                <input type="text" class="form-control form-control-sm campotext @error('bairro') is-invalid @enderror"
                                                       name="bairro" id="bairro" required="required"  value="{{$user->endereco->bairro ?? old('bairro')}}">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="bairro">Bairro</label>
                                            </div>

                                             {{-- CITY--}}
                                            <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <input type="text" class="form-control form-control-sm campotext @error('city') is-invalid @enderror"
                                                       name="city" id="city" required="required" value="{{$user->endereco->city ?? old('city')}}">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="city">Cidade</label>
                                            </div>

                                             {{-- STATE--}}
                                            <div class="md-form form-sm col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <input type="text" class="form-control form-control-sm campotext @error('state') is-invalid @enderror"
                                                       name="state" id="state" required="required" value="{{$user->endereco->state ?? old('state')}}">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="state">Estado</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                {{--DADOS PESSOAIS --}}
                                <section class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card-body box-profile">
                                        <p class="text-black-50 font-weight-bold text-md-left">Dados complementares</p>
                                        <div class="form-row">

                                            {{-- DATA NASCIMENTO--}}
                                            <div class="md-form form-sm col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <label class="text-small">Data nascimento</label>
                                                <input type="date"
                                                       id="nascimento"
                                                       class="form-control form-control-sm datepicker"
                                                       name="nascimento"
                                                       value="{{isset($user) ? $user->nascimento : '' ?? old('nascimento')}}"
                                                       required="required">

                                            </div>

                                            {{-- FORMAÇÃO--}}
                                            <div class="md-form form-sm col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                <input type="text" class="form-control form-control-sm campotext
                                                @error('formacao') is-invalid @enderror"
                                                       name="formacao" id="formacao"
                                                       value="{{$user->formacao ?? old('formacao')}}">
                                                <label for="formacao">Formação academica</label>
                                            </div>

                                            {{-- ESTADO CIVIL--}}
                                            <div class="md-form form-sm col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                                <input type="text" class="form-control form-control-sm @error('stateCivil') is-invalid @enderror"
                                                       name="stateCivil" id="statecivil"
                                                       value="{{$user->state_civil ?? old('stateCivil')}}">
                                                <label for="stateCivil">Estado civil</label>
                                            </div>

                                            {{-- TELEFONE--}}
                                            <div class="md-form form-sm col-sm-6 col-md-5 col-lg-5 col-xl-5">
                                                <input type="text" class="form-control form-control-sm @error('fone') is-invalid @enderror"
                                                       name="fone" id="fone" value="{{$user->fone ?? old('fone')}}">
                                                <label for="fone">Telefone</label>
                                            </div>

                                            {{-- RAMAL--}}
                                            <div class="md-form form-sm col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                                <input type="text" class="form-control form-control-sm @error('fone') is-invalid @enderror"
                                                       name="ramal" id="ramal" value="{{$user->ramal ?? old('ramal')}}">
                                                <label for="ramal">Ramal</label>
                                            </div>

                                            {{-- DESCRIÇÃO--}}
                                            <div class="md-form form-sm md-outline purple-border col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <textarea class="md-textarea form-control form-control-sm" id="textarea-char-counter"
                                                          name="descricao" rows="5" cols="20">{{isset($user) ? $user->descricao ?? old('descricao') : ''}}</textarea>
                                                <label class="text-black-50 font-weight-bold text-md-left" for="textarea-char-counter">Descrição</label>
                                            </div>


                                        </div>
                                    </div>
                                </section>
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
        $(document).ready(function(){
            $("#cep").inputmask("99999-999",{ "placeholder": "*", "clearIncomplete": true });
            $("#number").inputmask("/[0-9]/g");
            $("#fone").inputmask("(99)-99999-9999",{ "placeholder": "*", "clearIncomplete": true });
            $("#ramal").inputmask("9999",{ "placeholder": "*", "clearIncomplete": true });
            $("#nascimento").inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy", "clearIncomplete": true});


            $('.campotext').on('keypress', function(e) {
                var regex = new RegExp("^[a-zA-Z ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]*$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    return true;
                }
                e.preventDefault();
                return false;
            });


        });

        var loadfile = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <script src="{{ asset('js/scriptTextarea.js') }}"></script>
@endsection

@section('partialspost_js')
    <script src="{{asset('frontend/utilities/clearforms.js')}}"></script>
@endsection