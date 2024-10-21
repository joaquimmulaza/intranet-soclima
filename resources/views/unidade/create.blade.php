@extends('master.layout')
@section('title', 'Cadastrar unidade')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($unidade) ? 'Editar' : 'Criar nova' }} deoartamento</li>
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
                            <form action="{{isset($unidade) ? route('unidade.update', $unidade->id) : route('unidade.store')}}"
                                  id="roleFrom" role="form" method="POST">
                                @csrf
                                @if (isset($unidade))
                                    @method('PUT')
                                @endif
                                <div class="card-body">

                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{ isset($unidade) ? 'Editar' : 'Criar nova' }} departamento</h3>

                                    <div class="row">
                                        <div class="md-form form-sm col-sm-12 col-md-10 col-lg-10 col-xl-10">
                                            <input id="titulo" name="titulo" type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror"
                                                   value="{{$unidade->titulo ?? old('titulo')}}" autofocus/>
                                            <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Nome do departamento</label>
                                            @error('titulo')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <!-- <div class="md-form form-sm col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                            <input type="text" class="form-control form-control-sm @error('ramal') is-invalid @enderror"
                                                   name="ramal" id="ramal" value="{{$unidade->ramal ?? old('ramal')}}">
                                            <label for="ramal">Ramal</label>
                                        </div> -->

                                        <div class="md-form md-outline purple-border col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <textarea class="md-textarea form-control" id="descricao" name="descricao" required="required" rows="5" cols="20">{{isset($unidade) ? $unidade->descricao ?? old('descricao') : ''}}</textarea>
                                            <label class="text-black-50 font-weight-bold text-md-left" for="title">Descrição sobre o departamento</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="responsaveis">Responsáveis pelo departamento</label>
                                        <select name="responsaveis[]" id="responsaveis" class="form-control js-multiple-select" multiple>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ isset($unidade) && in_array($user->id, $unidade->responsaveis->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    

                                    <button type="submit" class="btn btn-success rounded">
                                        @isset($unidade)
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

                                    @isset($unidade)
                                    <a type="button" class="btn btn-danger rounded" href="{{route('unidade.index')}}">
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
                                            Limpar
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir o JS do Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#ramal").inputmask("9999",{ "placeholder": "*", "clearIncomplete": true });
        });

        $(document).ready(function() {
            // Inicializando o Select2
            $('#responsaveis').select2({
                placeholder: "Digite para pesquisar o responsavel",  // Placeholder de pesquisa
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
    </script>
@endsection

@section('partialspost_js')
    <script src="{{asset('frontend/utilities/clearforms.js')}}"></script>
@endsection