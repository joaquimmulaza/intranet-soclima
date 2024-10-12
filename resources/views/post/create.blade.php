@extends('master.layout')
@include('post.partials_post._head')

@section('title', 'Cadastrar notícia')

@section('content')
    <script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('public/plugins/select2/css/estiloSelect2.css')}}">
    <link href="{{asset('summernote/summernote-lite.min.css')}}" type="text/css" rel="stylesheet">

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($post) ? 'Editar' : 'Criar nova' }} notícia</li>
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
                            <form action="{{isset($post) ? route('post.update', $post->id) : route('post.store')}}"
                                  id="roleFrom" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($post))
                                    @method('PUT')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        {{-- DADOS NOTICIA --}}
                                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <h3 class="text-black-50 font-weight-bold text-md-left">{{isset($post) ? 'Editar' : 'Criar nova'}} notícia</h3>
                                            <div class="row">
                                                {{-- TITULO--}}
                                                <div class="md-form form-sm col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                                    <input id="title"
                                                           name="title" type="text"
                                                           class="form-control form-control-sm @error('title') is-invalid @enderror"
                                                           value="{{$post->title ?? old('title')}}" autofocus maxlength="130" max="130"/>
                                                    <label class="text-black-50 font-weight-bold text-md-left" for="titulo">
                                                        Titulo
                                                    </label>
                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- DATA VALIDADE--}}
                                                <div class="md-form form-sm col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <label class="text-small">Validade da notícia</label>
                                                    <input type="date"
                                                           id="nascimento"
                                                           class="form-control form-control-sm datepicker"
                                                           name="validate"
                                                           value="{{isset($post) ? $post->validate_at : '' ?? old('nascimento')}}"
                                                           required="required">

                                                </div>


                                                {{--CARREGAR IMAGEM--}}
                                                <div class="col-sm-12 col-md-4 col-lg-6 col-xl-6">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="avatar" name="arquivo" onchange="loadfile(event)">
                                                        <label class="custom-file-label" for="avatar">Selecione uma imagem</label>
                                                    </div>
                                                </div>

                                                {{-- CATEGORIA--}}
                                                <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <select id="card_id" class="js-basic-multiple form-control form-control-sm"
                                                            style="width: 100%;" name="cat[]" multiple="multiple" placeholder="Escolha quais categorias">
                                                            @foreach($categorias as $categoria)
                                                                <option value="{{$categoria->id}}"
                                                                @if(isset($post))
                                                                    @foreach($post->categorias as $cat)
                                                                        @if($categoria->id == $cat->id)
                                                                             selected="selected"
                                                                        @endif
                                                                     @endforeach
                                                                @endif
                                                                        >{{$categoria->titulo}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- SUBTITULO -RESUMO--}}
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <div class="md-form md-outline">
                                                        <textarea class="md-textarea form-control" id="conteudo" name="subtitle" required="required">{{isset($post) ? $post->subtitle : ''}}</textarea>
                                                        <label class="text-black-50 font-weight-bold text-md-left" for="conteudo">Resumo de sua notícia</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--IMAGEM PREVIEW --}}
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                            <figure id="upload" class="figure file-upload-wrapper">
                                                <img class="figure-img img-fluid z-depth-1 rounded" id="output"
                                                     src="{{URL::to('/')}}/storage/{{isset($post) ? $post->capa : 'capa_posts/capa_default.jpg'}}"
                                                     alt="capa de noticias">
                                            </figure>
                                        </div>

                                        {{-- DESCRIÇÃO--}}
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="form-group">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="conteudo">Descrição inicial da notícia</label>
                                                <textarea class="form-control summer" id="conteudo" name="conteudo" required="required">{{isset($post) ? $post->content : ''}}
                                                </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="conteudo">Conclusão final</label>
                                                <textarea class="form-control summer" id="resumo" name="resumo">{{isset($post) ? $post->resumo : ''}}
                                                </textarea>
                                            </div>
                                        <div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <button type="submit" class="btn btn-success rounded">
                                                @isset($post)
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                         <i class="fas fa-edit fa-w-20"></i>
                                                    </span>
                                                    Atualizar notícia
                                                @else
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="far fa-save fa-w-20"></i>
                                                    </span>
                                                    Salvar nova notícia
                                                @endisset
                                            </button>

                                            @isset($post)
                                                <a type="button" class="btn btn-danger rounded" href="{{route('home')}}">
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
                                </div>
                                    </div>
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
    <script src="{{ url(mix('public/plugins/select2/select2.min.js'))}}"></script>
    <script src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('summernote/lang/summernote-pt-BR.min.js') }}"></script>
    <script src="{{ asset('summernote/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/scriptTextarea.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summer').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']]
                ],
                height: 150,
                placeholder:'Escreva sua noticia aqui...',
                lang: 'pt-BR'
            });
            $("#nascimento").inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy", "clearIncomplete": true});
        });
    </script>
    <script>
        var loadfile = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection