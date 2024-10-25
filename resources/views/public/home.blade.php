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
                <li>
                    <img src="logo/img/icon/assignment_ind.svg" alt="">
                    <a class="linksNav {{Route::current()->getName() === 'user.index' ? 'menu-open' : ''}}" href="{{route('user.index')}}">Gerir Usuários</a>
                </li>
                <li>
                    <img src="logo/img/icon/article.svg" alt="">
                    <a href="#">Recibos</a>
                </li>
                <li>
                    <img src="logo/img/icon/assignment_turned_in.svg" alt="">
                    <a href="#">Justificativos</a>
                </li>
                <li>
                    <img src="logo/img/icon/gmail_groups.svg" alt="">
                    <a class="{{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}" href="{{route('telefones.index')}}">Lista Telefônica</a>
                </li>
                <li>
                    <img src="logo/img/icon/Vector.svg" alt="">
                    <a href="#">Férias</a>
                </li>
            </ul>
        </div>
    

        <!-- Post 1 -->
        <div class="postContainer">
            <div class="mainPostContainer">
                <div class="inputPost">
                    <img src="logo/img/icon/avatar-input.svg" alt="">
                    <form action="{{isset($post) ? route('post.update', $post->id) : route('post.store')}}" id="roleFrom" role="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($post))
                            @method('PUT')
                        @endif
                        <input type="button" value="Comunique algo..." data-toggle="modal" data-target="#createEventModal" placeholder="Comunique algo...">
                    </form>
                </div>
            </div>

            <div class="AllpostsContainer">
            @foreach($posts as $post)
                <div class="post-header">
                    <div class="postContentHeader">
                    
                        <img src="logo/img/icon/avatar-input.svg" alt="">
                        <h3 style="padding: 0; margin: 0;">{{$post->user->name}}</h3>
                        <img src="logo/img/icon/Ellipse3.svg" alt="">
                        <p style="padding: 0; margin: 0;">{{date('d/m/Y', strtotime($post->created_at))}}</</p>
                    </div>
                    <div>
                        <img src="logo/img/icon/frame26.svg" alt="">
                    </div>
                </div>
                <div class="post-body">
                    <h3>{{Str::limit($post->title, 80)}}</h3>
                    <p>{{Str::limit($post->content, 80)}}</p>
                </div>
                <hr style="width: 460px; margin: 0 auto;">
                <div class="post-footer">

                    <div class="items-footer">
                        <span>
                            <img src="logo/img/icon/Thumbs-up.svg" alt="">
                            {{ likes_post($post->id) }}
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
                            <button>Ver Evento</button>
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
                            <button>Ver Evento</button>
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
                            <button>Ver Evento</button>
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
                            <button>Ver Evento</button>
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
                    @foreach(aniversariantes_mes() as $user)
                        <h2 style="margin: 0 !important; padding: 0 !important;">{{$user->name }}</h2>
                        <p style="margin: 0 !important; padding: 0 !important;" >Completou idade hoje {{date('d/m', strtotime($user->nascimento))}}</p>
                    @endforeach
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


    <script src="{{ asset('frontend/home/script.js') }}"></script>
    <script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>

     <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
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

  const dropArea = document.getElementById('drop-area');
    const fileElem = document.getElementById('fileElem');

    // Permitir clicar na área para selecionar arquivo
    dropArea.addEventListener('click', () => fileElem.click());

    // Evitar comportamento padrão
    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Destacar o drop area
    ;['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#e0e0e0', false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#f9f9f9', false);
    });

    // Lidar com arquivos arrastados
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
        }

        reader.readAsDataURL(file);
    }
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection