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
                                        {{-- DADOS COMUNICADO --}}
                                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <h3 class="text-black-50 font-weight-bold text-md-left">{{isset($post) ? 'Editar' : 'Criar novo'}} comunicado</h3>
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

                                                
                                            </div>
                                        </div>
                                       

                                        {{-- DESCRIÇÃO--}}
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="form-group">
                                                <label class="text-black-50 font-weight-bold text-md-left" for="content">Descrição do comunicado</label>
                                                <textarea class="form-control summer" id="content" name="content" required="required">{{isset($post) ? $post->content : ''}}
                                                </textarea>
                                            </div>

                                        <div>

                                        {{--CARREGAR IMAGEM--}}
                                        <div class="col-sm-12 col-md-4 col-lg-6 col-xl-6">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="arquivo_imagem" name="arquivo_imagem" accept=".jpg, .jpeg, .png" onchange="loadfile(event)">
                                                <label class="custom-file-label" for="avatar">Anexar foto</label>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf" onchange="loadfile(event)">
                                                <label class="custom-file-label" for="avatar">Anexar PDF</label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEventModal">
                                            Criar Evento
                                        </button>


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
                                                    Publicar
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
                                                <!-- <button type="reset" class="btn btn-danger rounded">
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fas fa-eraser fa-w-20"></i>
                                                    </span>
                                                    Limpar
                                                </button> -->
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
        <!-- Modal Criar Evento -->
        <!-- Modal para Criar Evento -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createEventModalLabel">Criar Novo Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <!-- Título do Evento -->
          <div class="form-group">
            <label for="eventTitle">Título do Evento</label>
            <input type="text" class="form-control" id="eventTitle" name="title" required>
          </div>

          <!-- Descrição do Evento -->
          <div class="form-group">
            <label for="eventDescription">Descrição</label>
            <textarea class="form-control" id="eventDescription" name="description" rows="3" required></textarea>
          </div>

          <!-- Data de Início -->
          <div class="form-group">
            <label for="eventStartDate">Data de Início</label>
            <input type="date" class="form-control" id="eventStartDate" name="start_date" required>
          </div>

          <!-- Data de Fim -->
          <div class="form-group">
            <label for="eventEndDate">Data de Fim</label>
            <input type="date" class="form-control" id="eventEndDate" name="end_date" required>
          </div>

          <!-- Hora de Início -->
          <div class="form-group">
            <label for="eventStartTime">Hora de Início</label>
            <input type="time" class="form-control" id="eventStartTime" name="start_time" required>
          </div>

          <!-- Hora de Fim -->
          <div class="form-group">
            <label for="eventEndTime">Hora de Fim</label>
            <input type="time" class="form-control" id="eventEndTime" name="end_time" required>
          </div>

          <!-- Imagem de Capa -->
          <div class="form-group">
            <label for="eventCoverImage">Imagem de Capa</label>
            <input type="file" class="form-control-file" id="eventCoverImage" name="cover_image">
          </div>

          <!-- Botão para Submeter o Formulário -->
          <button type="submit" class="btn btn-primary">Criar Evento</button>
        </form>
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
                placeholder:'Escreva seu comunicado aqui...',
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection