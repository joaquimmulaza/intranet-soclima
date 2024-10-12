@extends('master.layout')
@section('title', 'Cadastrar unidade')

@section('content')
    <script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($unidade) ? 'Editar' : 'Criar nova' }} unidade</li>
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

                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{ isset($unidade) ? 'Editar' : 'Criar nova' }} unidade</h3>

                                    <div class="row">
                                        <div class="md-form form-sm col-sm-12 col-md-10 col-lg-10 col-xl-10">
                                            <input id="titulo" name="titulo" type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror"
                                                   value="{{$unidade->titulo ?? old('titulo')}}" autofocus/>
                                            <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Nome da unidade</label>
                                            @error('titulo')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="md-form form-sm col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                            <input type="text" class="form-control form-control-sm @error('ramal') is-invalid @enderror"
                                                   name="ramal" id="ramal" value="{{$unidade->ramal ?? old('ramal')}}">
                                            <label for="ramal">Ramal</label>
                                        </div>

                                        <div class="md-form md-outline purple-border col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <textarea class="md-textarea form-control" id="descricao" name="descricao" required="required" rows="5" cols="20">{{isset($unidade) ? $unidade->descricao ?? old('descricao') : ''}}</textarea>
                                            <label class="text-black-50 font-weight-bold text-md-left" for="title">Descrição sobre a unidade</label>
                                        </div>
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

    <script>
        $(document).ready(function(){
            $("#ramal").inputmask("9999",{ "placeholder": "*", "clearIncomplete": true });
        });
    </script>
@endsection

@section('partialspost_js')
    <script src="{{asset('frontend/utilities/clearforms.js')}}"></script>
@endsection