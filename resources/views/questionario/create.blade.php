@extends('master.layout')
@section('title', 'Cadastrar questionario')

@section('content')


    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($questionario) ? 'Editar' : 'Criar novo' }} questionario</li>
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
                            <form action="{{isset($questionario) ? route('questionario.update', $questionario->id) : route('questionario.store')}}"
                                  id="roleFrom" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($questionario))
                                    @method('PUT')
                                @endif
                                <div class="card-body">
                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{ isset($questionario) ? 'Editar' : 'Criar novo' }} questionario</h3>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <div class="row">
                                                <div class="md-form form-sm col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                                    <input id="titulo" name="titulo" type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror"
                                                           value="{{$questionario->title ?? old('titulo')}}" autofocus/>
                                                    <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Nome do questionario</label>
                                                    @error('titulo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                {{-- DATA VALIDADE--}}
                                                <div class="md-form form-sm col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <label class="text-black-50 font-weight-bold text-md-left">Termino do questionário</label>
                                                    <input type="date"
                                                           id="validate"
                                                           class="form-control form-control-sm datepicker"
                                                           name="validate"
                                                           value="{{isset($questionario) ? $questionario->validate_at : '' ?? old('validate')}}"
                                                           required="required">
                                                </div>


                                                <div class="md-form md-outline col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <textarea class="md-textarea form-control" id="conteudo" name="conteudo" required="required" rows="3" cols="20">{{isset($questionario) ? $questionario->content ?? old('descricao') : ''}}</textarea>
                                                    <label class="text-black-50 text-md-left" for="title">Descrição sobre o questionario</label>
                                                </div>

                                                <div class="custom-file col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <input type="file" class="custom-file-input" id="avatar" name="arquivo" onchange="loadfile(event)">
                                                    <label class="custom-file-label" for="avatar">Selecione uma imagem</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                            {{--IMAGEM PREVIEW --}}
                                            <figure id="upload" class="figure file-upload-wrapper">
                                                <img class="figure-img img-fluid z-depth-1 rounded" id="output"
                                                     src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}"
                                                     alt="capa de questionario">
                                            </figure>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-success rounded">
                                        @isset($questionario)
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

                                    @isset($questionario)
                                    <a type="button" class="btn btn-danger rounded" href="{{route('questionario.index')}}">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var loadfile = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection

