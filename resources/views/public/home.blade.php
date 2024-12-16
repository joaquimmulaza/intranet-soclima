@extends('master.layout')
@section('title', 'Home')

@section('content')
<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>

    {{-- ESTILO SVG--}}
    <style>
        .curved{
            display: block;
            margin: 0px;
        }

        .curved svg{
            display: block;
            margin-bottom: -20px;
            margin-left: -10px;
            margin-right: -10px;
        }

        /* Reset básico */


/* Conteúdo Principal */


.search-bar {
    margin-bottom: 20px;
}

.search-bar input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

    </style>

    <link href="{{asset('frontend/home/estilo.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('baguettebox/baguetteBox.min.css')}}" type="text/css" rel="stylesheet">

    {{-- CABEÇALHO BREADCRUMB--}}
    <!-- <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> -->

    

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="sidebar-left">
            <ul>
                @can('app.dashboard')
                <li>
                    <img src="logo/img/icon/assignment_ind.svg" alt="">
                    <a class="linksNav {{Route::current()->getName() === 'user.index' ? 'menu-open' : ''}}" href="{{route('user.index')}}">Gerir Usuários</a>
                </li>
                @endcan
                <li>
                    <img src="logo/img/icon/article.svg" alt="">
                    <a href="#">Recibos</a>
                </li>
                <li>
                    <img src="logo/img/icon/assignment_turned_in.svg" alt="">
                    <a href="#">Envio de documento</a>
                </li>
                <li>
                    <img src="logo/img/icon/feed.svg" alt="">
                    <a href="#">Pedido de documento</a>
                </li>
                <li>
                    <img src="logo/img/icon/gmail_groups.svg" alt="">
                    <a class="{{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}" href="{{route('telefones.index')}}">Lista Telefônica</a>
                </li>
                <li>
                    <img src="logo/img/icon/Vector.svg" alt="">
                    <a href="{{route('public.calendar')}}">Férias</a>
                </li>
            </ul>
        </div>
    

        <!-- Post 1 -->
        <div class="postContainer">
            <div class="mainPostContainer">
                <div class="inputPost">
                    <img src="logo/img/icon/avatar-input.svg" alt="">
                    
                        <input type="button" value="Comunique algo..." data-toggle="modal" data-target="#createPostModal" placeholder="Comunique algo...">
                   
                </div>
            </div>

            <div class="modal escurecer fade popUpContainer" id="createPostModal" tabindex="-1" aria-labelledby="createPostModal" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                    <div class="modal-dialog  modal-dialog-centered popUpContainer">
                        <div class="modal-content pop-up">
                            <div class="modal-header">
                                
                                <div class="elementsHeader">
                                    <img src="logo/img/icon/avatar-post.svg" alt="">
                                    <div class="contentHeaderPost">
                                        <h3 class="modal-title" id="createEventModalLabel">
                                            {{ isset($post) && $post->user ? $post->user->name : 'Usuário desconhecido' }}
                                        </h3>
                                        <h4>A {{isset($post) ? 'criar' : 'Criar novo'}} comunicado</h4>
                                    </div>
                                </div>
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <div class="modal-body pop-up">
                                <form action="{{ route('post.store') }}" id="roleForm" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Título do Evento -->
                                
                                <div class="containerInputPost">
                                
                                    <input id="title" name="title" type="text" class="@error('title') is-invalid @enderror" placeholder="Adiciona um titulo" required autofocus maxlength="130" max="130">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                
                                    <textarea id="content" name="content" required="required" placeholder="Comece a escrever aqui"> </textarea>
                                </div>

                                <!-- Data de Início
                                <div class="form-group">
                                    <label for="eventStartDate">Data de Início</label>
                                    <input type="date" class="form-control" id="eventStartDate" name="start_date" required>
                                </div> -->

                                <!-- Data de Fim
                                <div class="form-group">
                                    <label for="eventEndDate">Data de Fim</label>
                                    <input type="date" class="form-control" id="eventEndDate" name="end_date" required>
                                </div> -->

                                <!-- Hora de Início
                                <div class="form-group">
                                    <label for="eventStartTime">Hora de Início</label>
                                    <input type="time" class="form-control" id="eventStartTime" name="start_time" required>
                                </div> -->

                                <!-- Hora de Fim
                                <div class="form-group">
                                    <label for="eventEndTime">Hora de Fim</label>
                                    <input type="time" class="form-control" id="eventEndTime" name="end_time" required>
                                </div> -->

                                <!-- Imagem de Capa -->
                                <div class="btnContainerPost">
                                
                                        <input type="file" class="custom-file-input" id="arquivo_imagem" name="arquivo_imagem" accept=".jpg, .jpeg, .png" style="display: none;">
                                        <label for="arquivo_imagem" class="custom-file-button">
                                            <img src="logo/img/icon/photo.svg" alt="Ícone PDF" class="icon"> <!-- Ícone midia -->
                                            Anexar Mídia
                                        </label>
                                    
                                        <input type="file" class="custom-file-input" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf" style="display: none;">
                                        <label for="arquivo_pdf" class="custom-file-button">
                                            <img src="logo/img/icon/icon-pdf.svg" alt="Ícone PDF" class="icon"> <!-- Ícone PDF -->
                                            Anexar PDF
                                        </label>

                                        <input type="file" class="custom-file-input" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf" style="display: none;">
                                        <label for="arquivo_pdf" class="custom-file-button">
                                            <img src="logo/img/icon/event-icon.svg" alt="Ícone PDF" class="icon"> <!-- Ícone PDF -->
                                            Criar Evento
                                        </label>
                                        
                                
                                </div>

                                <!-- Botão para Submeter o Formulário -->
                                <button type="submit" class="btnPublicar">Publicar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal escurecer fade popUpContainer" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                    <div class="modal-dialog  modal-dialog-centered popUpContainer">
                        <div class="modal-content pop-up">
                            <div class="modal-header">
                                
                                <div class="elementsHeader">
                                    <img src="logo/img/icon/avatar-post.svg" alt="">
                                    <div class="contentHeaderPost">
                                        <h3 class="modal-title" id="createEventModalLabel">
                                            {{ isset($post) && $post->user ? $post->user->name : 'Usuário desconhecido' }}
                                        </h3>
                                        <h4>A {{isset($post) ? 'editar' : 'Criar novo'}} comunicado</h4>
                                    </div>
                                </div>
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <div class="modal-body pop-up">
                            <form id="editForm" action="{{ route('post.update', '') }}" method="POST" enctype="multipart/form-data">    
                                @csrf
                                @method('PUT')
                                <!-- Título do Evento -->
                                
                                <div class="containerInputPost">
                                
                                    <input id="title" name="title" type="text" placeholder="Adiciona um titulo" required autofocus maxlength="130" max="130" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                
                                    <textarea id="content" name="content" required="required" placeholder="Comece a escrever aqui"> </textarea>
                                </div>

                                <!-- Data de Início
                                <div class="form-group">
                                    <label for="eventStartDate">Data de Início</label>
                                    <input type="date" class="form-control" id="eventStartDate" name="start_date" required>
                                </div> -->

                                <!-- Data de Fim
                                <div class="form-group">
                                    <label for="eventEndDate">Data de Fim</label>
                                    <input type="date" class="form-control" id="eventEndDate" name="end_date" required>
                                </div> -->

                                <!-- Hora de Início
                                <div class="form-group">
                                    <label for="eventStartTime">Hora de Início</label>
                                    <input type="time" class="form-control" id="eventStartTime" name="start_time" required>
                                </div> -->

                                <!-- Hora de Fim
                                <div class="form-group">
                                    <label for="eventEndTime">Hora de Fim</label>
                                    <input type="time" class="form-control" id="eventEndTime" name="end_time" required>
                                </div> -->

                                <!-- Imagem de Capa -->
                                <div class="btnContainerPost">
                                
                                        <input type="file" class="custom-file-input" id="arquivo_imagem" name="arquivo_imagem" accept=".jpg, .jpeg, .png" style="display: none;">
                                        <label for="arquivo_imagem" class="custom-file-button">
                                            <img src="logo/img/icon/photo.svg" alt="Ícone PDF" class="icon"> <!-- Ícone midia -->
                                            Anexar Mídia
                                        </label>
                                    
                                        <input type="file" class="custom-file-input" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf" style="display: none;">
                                        <label for="arquivo_pdf" class="custom-file-button">
                                            <img src="logo/img/icon/icon-pdf.svg" alt="Ícone PDF" class="icon"> <!-- Ícone PDF -->
                                            Anexar PDF
                                        </label>
                                        
                                
                                </div>

                                <!-- Botão para Submeter o Formulário -->
                                <button type="submit" class="btnPublicar">Publicar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

            <div class="AllpostsContainer">
            @foreach($posts as $post)
             
                <div class="postOnly">
                    <div class="post-header">
                        <div class="postContentHeader">
                            <img src="logo/img/icon/avatar-input.svg" alt="">
                            <h3 style="padding: 0; margin: 0;">{{$post->user->name}}</h3>
                            <img src="logo/img/icon/Ellipse3.svg" alt="">
                            <p style="padding: 0; margin: 0;">{{date('d/m/Y', strtotime($post->created_at))}}</p>
                        </div>
                        <div class="containerOpt">
                            <button class="btnOpt"  data-toggle="modal" data-target="#modalOpt-{{ $post->id }}" style="margin: 0 !important; padding: 0 !important;"><img src="logo/img/icon/frame26.svg" alt="" ></button>
                            <div class="modal fade modalOpt" id="modalOpt-{{ $post->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt">
                                        @can('app.dashboard')
                    
                                            <button type="button" data-toggle="modal" data-target="#modalEdit" style="border-bottom: none; border-top-left-radius: 5px; border-top-right-radius: 5px;" class="btnPosts"  data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->content}}">
                                                Editar
                                            </button>
                                            <button style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" type="button" class="btnPosts" onClick="deleteData({{ $post->id }})">
                                                Eliminar
                                            </button>
                                            <form id="delete-form-{{ $post->id }}"
                                                    action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="post-body">
                        <h3>{{Str::limit($post->title, 80)}}</h3>
                        <p>{{Str::limit($post->content, 80)}}</p>
                    </div>
                    <hr style="width: 460px; margin: 0 auto;">
                    <div class="post-footer">
                        <div class="items-footer" data-postid="{{ $post->id }}">
                            
                            <span class="like-button" style="cursor: pointer;">
                                <img src="logo/img/icon/{{ Auth::user()->likes()->where('post_id', $post->id)->exists() && Auth::user()->likes()->where('post_id', $post->id)->first()->like ? 'Thumbs-up.svg' : 'ThumbsUp-unpressed.svg' }}" class="like-icon" alt="">
                                <span class="like-count">{{ likes_post($post->id) }}</span>
                            </span>
                            </span>
                    
                            <span>
                                <img src="logo/img/icon/Group2.svg" alt="">
                                {{ $post->views_count }}0
                            </span>
                            <span>
                                <img src="logo/img/icon/mode_comment.svg" alt="">
                                {{ $post->comments()->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        <!-- Barra Lateral Direita -->
    <div class="sidebar-right">
        <!-- Eventos Recentes -->
        <h3>Eventos Recentes</h3>
        <div class="eventos-recentes">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="evento">
                        <img src="logo/img/imgSlideTeste.svg" alt="">
                        <div class="eventBody">
                            <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                            <h3>33 anos Soclima</h3>
                            <p class="textDescription">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Praesentium, expedita blanditiis veritatis.
                            </p>
                            <button style="padding: 0 !important; margin: 0 !important;">Ver Evento</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                <div class="evento">
                        <img src="logo/img/imgSlideTeste.svg" alt="">
                        <div class="eventBody">
                            <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                            <h3>33 anos Soclima</h3>
                            <p class="textDescription">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Praesentium, expedita blanditiis veritatis.
                            </p>
                            <button style="padding: 0 !important; margin: 0 !important;">Ver Evento</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                <div class="evento">
                        <img src="logo/img/imgSlideTeste.svg" alt="">
                        <div class="eventBody">
                            <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                            <h3>33 anos Soclima</h3>
                            <p class="textDescription">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Praesentium, expedita blanditiis veritatis.
                            </p>
                            <button style="padding: 0 !important; margin: 0 !important;">Ver Evento</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                <div class="evento">
                        <img src="logo/img/imgSlideTeste.svg" alt="">
                        <div class="eventBody">
                            <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                            <h3>33 anos Soclima</h3>
                            <p class="textDescription">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Praesentium, expedita blanditiis veritatis.
                            </p>
                            <button style="padding: 0 !important; margin: 0 !important;">Ver Evento</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            
        </div>
        <hr style="width: 326px; margin-bottom:  11px;">
        <!-- Aniversários -->
        <h3>Aniversários</h3>

        <div class="aniversariosContainer">
        
            <div class="aniversarios">
                <div class="eventsContainer">
                    <img src="logo/img/icon/Group14.svg" alt="">
                    <div class="aniversariosBody">
                        @php
                            $aniversariantes = aniversariantes_hoje();
                        @endphp

                        @if($aniversariantes->isEmpty())
                            <p style="margin: 0 !important; padding: 0 !important;">Nenhum aniversário hoje, mas estamos prontos para comemorar quando houver!</p>
                        @else
                            @php
                                $count = $aniversariantes->count();
                            @endphp
                            
                            @if($count == 1)
                                <h2 style="margin: 0 !important; padding: 0 !important;">{{$aniversariantes->first()->name }} faz anos hoje!</h2>
                            @else
                                <h2 style="margin: 0 !important; padding: 0 !important;">
                                    @foreach($aniversariantes as $index => $user)
                                        @if($index == 0)
                                            {{$user->name }}
                                        @elseif($index == $count - 1)
                                            e mais {{$count - 1}} pessoa
                                        @endif
                                    @endforeach
                                </h2>
                                <p style="padding: 0 !important; margin: 0 !important;">Fazem anos hoje!</p>
                            @endif
                        @endif
                    </div>

                </div>
            </div>

        </div>

        <!-- Veja quem está de férias -->
        <h3>Veja quem está de férias</h3>
        <div class="ferias">
            <div class="eventsContainer">
                <img src="logo/img/icon/GroupF.svg" alt="">
                <div class="aniversariosBody">
                
                    <h2 style="margin: 0 !important; padding: 0 !important;">Alfredo Mário e mais 6 pessoas</h2>
                    <p style="margin: 0 !important; padding: 0 !important;">Estão desfrutando de merecidas férias.</p>
                
                </div>
            </div>
        </div>
        <div class="ferias" style="background: transparent; box-shadow: none;">
            <p>AV. Samora Machel. S/N. Luanda. Talatona</p>
            <p>Copyright &copy; {{date('Y')}} <a href="https://soclima.com/" target="_blank">Soclima</a></p>
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
          <div id="drop-area">
                <img src="logo/img/icon/Page-1.svg" alt="Carregar uma imagem de capa">
                <p>Carregar uma imagem de capa</p>
                <input type="file" id="fileElem" class="hidden" accept="image/*" onchange="handleFiles(this.files)">
            </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('frontend/home/script.js') }}"></script>
<script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>

     <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
 $(document).ready(function () {
    // Configuração do Swiper
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // Lidar com a área de drop para upload de arquivos
    const dropArea = document.getElementById('drop-area');
    const fileElem = document.getElementById('fileElem');

    dropArea.addEventListener('click', () => fileElem.click());
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#e0e0e0', false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#f9f9f9', false);
    });

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        const file = files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            dropArea.innerHTML = ''; // Limpar área
            dropArea.appendChild(img); // Exibir imagem carregada
        };
        reader.readAsDataURL(file);
    }

    // Modal Behavior
    

    $('.modalOpt').on('show.bs.modal', function () {
            $('body').addClass('modal-open-no-backdrop');
        });

        $('.modalOpt').on('hidden.bs.modal', function () {
            // Não remove a classe modal-open-no-backdrop, portanto, o fundo semitransparente não será restaurado
        });

        $(document).on('click', function (event) {
            const $modal = $('.modalOpt');
            if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
                $modal.modal('hide');
            }
        });

    $('#modalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var title = button.data('title');
        var content = button.data('content');

        var modal = $(this);
        modal.find('#title').val(title);
        modal.find('#content').val(content);
        modal.find('form').attr('action', '/noticias/' + id);
    });

    // Envio do formulário via AJAX
    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                $('#modalEdit').modal('hide');
                alert('Postagem atualizada com sucesso!');
            },
            error: function (response) {
                alert('Ocorreu um erro. Por favor, tente novamente.');
            }
        });
    });

    // Lógica do botão de curtida
    let likeInProgress = false; // Flag para controle do envio

    $(document).on('click', '.like-button', function(event) {
        event.preventDefault();

        if (likeInProgress) return; // Impede novas requisições enquanto uma está em andamento
        likeInProgress = true; // Marca como em progresso

        const footer = $(this).closest('.items-footer');
        const postId = footer.data('postid');
        const icon = $(this).find('.like-icon');
        const countElement = $(this).find('.like-count');
        const isLiked = icon.hasClass('liked');

        console.log('Like button clicked');

        $.ajax({
            url: '/like',
            method: 'POST',
            data: {
                postId: postId,
                isLike: !isLiked,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    countElement.text(response.likes_count);
                    if (isLiked) {
                        icon.attr('src', 'logo/img/icon/ThumbsUp-unpressed.svg');
                        icon.removeClass('liked');
                    } else {
                        icon.attr('src', 'logo/img/icon/Thumbs-up.svg');
                        icon.addClass('liked');
                    }
                } else {
                    alert(response.message || 'Erro ao registrar a curtida.');
                }
            },
            error: function() {
                alert('Ocorreu um erro. Tente novamente.');
            },
            complete: function() {
                likeInProgress = false; // Libera a flag no final da requisição
            }
        });
    });
});

</script>

    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    <script src="{{ asset('public/plugins/sparklines/sparkline.js') }}"></script>
    
    <script src="{{ asset('public/dist/js/pages/dashboard.js') }}"></script>
    </script>
@endsection