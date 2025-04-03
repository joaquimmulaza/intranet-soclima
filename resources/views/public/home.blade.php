@extends('master.layout')
@section('title', 'Home')

@section('content')
<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
<script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{route('documento-request.send')}}">Envio de documento</a>
                </li>

                @if($user->cargo->titulo == 'Gerente')
                <li>
                    <img src="logo/img/icon/feed.svg" alt="">
                    <a href="{{route('admin_docs.index')}}">Documentos Solicitados</a>
                </li>
                @else
                <li>
                    <img src="logo/img/icon/feed.svg" alt="">
                    <a href="{{route('documento-request.create')}}">Pedido de documento</a>
                </li>
                @endif
                <li>
                    <img src="logo/img/icon/gmail_groups.svg" alt="">
                    <a class="{{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}" href="{{route('telefones.index')}}">Lista Telefônica</a>
                </li>
                <li>
                    <img src="logo/img/icon/Vector.svg" alt="">
                    <a href="{{route('documents.show')}}">Ausências</a>
                </li>
            </ul>
        </div>
    

        <!-- Post 1 -->
        <div class="postContainer">
            <div class="mainPostContainer">
                <div class="inputPost">
                    <img class="img_user_post" src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                    <input type="button" value="Comunique algo..." data-toggle="modal" data-target="#createPostModal" placeholder="Comunique algo...">
                </div>
            </div>

            <div class="modal escurecer fade popUpContainer" id="createPostModal" tabindex="-1" aria-labelledby="createPostModal" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                    <div class="modal-dialog  modal-dialog-centered popUpContainer">
                        <div class="modal-content pop-up">
                            
                            <div class="modal-header">
                                <div class="containerTitleWithClose">
                                    <h2>Comunicações Gerais</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    
                                </div>
                                
                                <div class="elementsHeader">
                                    <img src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                                    <div class="contentHeaderPost">
                                        <h3 class="modal-title" id="createEventModalLabel">
                                            {{ Auth::user()->name }}
                                        </h3>
                                    
                                    </div>
                                </div>
                                
                            </div>
                        <div class="modal-body pop-up">
                                <form action="{{ route('post.store') }}" id="roleForm" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Título do Evento -->
                                <!-- Adicionar o campo de upload dentro do form -->
                                <input type="file" id="arquivo_imagem" name="arquivo_imagem" class="hidden" multiple>

                                <div class="containerInputPost">
                                
                                    <input id="title" name="title" type="text" class="@error('title') is-invalid @enderror titleClear" placeholder="Adiciona um titulo" required autofocus maxlength="130" max="130">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                
                                    <textarea id="content" name="content" class="contentClear" required="required" placeholder="Comece a escrever aqui"></textarea>
                                </div>

                                <!-- Imagem de Capa -->
                                <div class="btnContainerPost">
                                
                                        <!--<label for="arquivo_pdf" class="custom-file-button">
                                        <input type="file" id="pdfInpDut" accept="application/pdf" class="hidden">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 2H8C6.9 2 6 2.9 6 4V16C6 17.1 6.9 18 8 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H8V4H20V16ZM4 6H2V20C2 21.1 2.9 22 4 22H18V20H4V6ZM16 12V9C16 8.45 15.55 8 15 8H13V13H15C15.55 13 16 12.55 16 12ZM14 9H15V12H14V9ZM18 11H19V10H18V9H19V8H17V13H18V11ZM10 11H11C11.55 11 12 10.55 12 10V9C12 8.45 11.55 8 11 8H9V13H10V11ZM10 9H11V10H10V9Z" fill="#E75845"/>
                                            </svg>
                                        </label> -->
                                        <label class="custom-file-button">
                                            <input type="file" id="pdfInput" name="arquivo_pdf[]" accept="application/pdf" class="hidden" multiple>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 2H8C6.9 2 6 2.9 6 4V16C6 17.1 6.9 18 8 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H8V4H20V16ZM4 6H2V20C2 21.1 2.9 22 4 22H18V20H4V6ZM16 12V9C16 8.45 15.55 8 15 8H13V13H15C15.55 13 16 12.55 16 12ZM14 9H15V12H14V9ZM18 11H19V10H18V9H19V8H17V13H18V11ZM10 11H11C11.55 11 12 10.55 12 10V9C12 8.45 11.55 8 11 8H9V13H10V11ZM10 9H11V10H10V9Z" fill="#E75845"/>
                                            </svg>
                                        </label>

                                        <label for="arquivo_imagem" class="openModalPreview" data-toggle="modal" data-target="#modalPreviewImagem">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.5 20.5H3.5V6.5H12.5V4.5H3.5C2.4 4.5 1.5 5.4 1.5 6.5V20.5C1.5 21.6 2.4 22.5 3.5 22.5H17.5C18.6 22.5 19.5 21.6 19.5 20.5V11.5H17.5V20.5ZM9.71 17.33L7.75 14.97L5 18.5H16L12.46 13.79L9.71 17.33ZM19.5 4.5V1.5H17.5V4.5H14.5C14.51 4.51 14.5 6.5 14.5 6.5H17.5V9.49C17.51 9.5 19.5 9.49 19.5 9.49V6.5H22.5V4.5H19.5Z" fill="#CDCC00"/>
                                            </svg>

                                        </label>
                                </div>

                                <div class="outroContainer" style="display: none;">
                                    <div class="mainContainerPDF">
                                        <div class="flex gap-4">
                                            
                                        </div>
                                        <div class="innerContainer">
                                            <div id="fileContainer" class="scroll-container flex">
                                                <!-- Os arquivos aparecerão aqui -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botão para Submeter o Formulário -->
                                <button type="submit" class="btnPublicar">Publicar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal escurecer fade popUpContainer " id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                <div class="modal-dialog  modal-dialog-centered popUpContainer">
                        <div class="modal-content pop-up">
                            
                            <div class="modal-header">
                                <div class="containerTitleWithClose">
                                    <h2>Comunicações Gerais</h2>
                                    <span class="close closeModalPreview" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </span>
                                    
                                </div>
                                
                                <div class="elementsHeader">
                                    <img src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                                    <div class="contentHeaderPost">
                                        <h3 class="modal-title" id="createEventModalLabel">
                                            {{ Auth::user()->name }}
                                        </h3>
                                    
                                    </div>
                                </div>
                                
                            </div>
                        <div class="modal-body pop-up">
                            
                        @if (isset($post))
                            <form id="editForm" action="{{ route('post.update',  $post->id) }}" method="POST" enctype="multipart/form-data">
                        @else
                            <p>Post não encontrado!</p>
                        @endif 
                                @csrf
                                @method('PUT')
                                <!-- Título do Evento -->
                                
                                <div class="containerInputPost">
                                
                                    <input id="title" name="title" type="text" class="titleClear" placeholder="Adiciona um titulo" required autofocus maxlength="130" max="130" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                
                                    <textarea id="content" name="content" class="contentClear" required="required" placeholder="Comece a escrever aqui"></textarea>
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
                                
                                      
                                        <label class="custom-file-button">
                                        <input type="file" id="pdfInputEdit" name="arquivo_pdf[]" accept="application/pdf" class="hidden" multiple>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 2H8C6.9 2 6 2.9 6 4V16C6 17.1 6.9 18 8 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H8V4H20V16ZM4 6H2V20C2 21.1 2.9 22 4 22H18V20H4V6ZM16 12V9C16 8.45 15.55 8 15 8H13V13H15C15.55 13 16 12.55 16 12ZM14 9H15V12H14V9ZM18 11H19V10H18V9H19V8H17V13H18V11ZM10 11H11C11.55 11 12 10.55 12 10V9C12 8.45 11.55 8 11 8H9V13H10V11ZM10 9H11V10H10V9Z" fill="#E75845"/>
                                            </svg>
                                        </label>

                                        <label for="arquivo_imagem" class="custom-file-button" data-toggle="modal" data-target="#modalPreviewImagem">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.5 20.5H3.5V6.5H12.5V4.5H3.5C2.4 4.5 1.5 5.4 1.5 6.5V20.5C1.5 21.6 2.4 22.5 3.5 22.5H17.5C18.6 22.5 19.5 21.6 19.5 20.5V11.5H17.5V20.5ZM9.71 17.33L7.75 14.97L5 18.5H16L12.46 13.79L9.71 17.33ZM19.5 4.5V1.5H17.5V4.5H14.5C14.51 4.51 14.5 6.5 14.5 6.5H17.5V9.49C17.51 9.5 19.5 9.49 19.5 9.49V6.5H22.5V4.5H19.5Z" fill="#CDCC00"/>
                                            </svg>

                                        </label>
                            
                                </div>
                                <div class="outroContainer" style="display: none;">
                                    <div class="mainContainerPDF mainContainerPDFEdit">
                                        <div class="innerContainer">
                                            <div id="fileContainerEdit" class="scroll-container flex"></div>
                                        </div>
                                    </div>
                                </div>
                               

                                <!-- Botão para Submeter o Formulário -->
                                <button type="submit" class="btnPublicar">Publicar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

            <div class="AllpostsContainer">
            @php
                // Ordena os posts pelo campo 'created_at' em ordem decrescente
                $posts = $posts->sortByDesc('created_at');
            @endphp
            @foreach($posts as $post)
             
                <div class="postOnly post-item">
                    <div class="post-header">
                        <div class="postContentHeader">
                            <img class="img_user_post" src="{{ url('public/avatar_users/' . $post->user->avatar) }}" alt="">
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
                    
                                            <button type="button" data-toggle="modal" data-target="#modalEdit" style="border-bottom: none; border-top-left-radius: 5px; border-top-right-radius: 5px;" class="btnPosts editPostButton"  data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->content}}">
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
                        @if($post->arquivo_imagem)
                            <div class="size_img_post">
                                <img src="{{ asset($post->arquivo_imagem) }}" alt="Imagem de Capa" style="cursor: pointer;" onclick="openPostPreview('{{ addslashes($post->title) }}', '{{ addslashes($post->content) }}', '{{ asset($post->arquivo_imagem) }}', '{{ $post->user->name }}', '{{ URL::to('/') }}/public/avatar_users/{{ $post->user->avatar }}', '{{date('d/m/Y', strtotime($post->created_at))}}', '{{$post->id}}', '{{$post->user->cargo->titulo}}')">
                            </div>
                        @endif
                        
                        @if ($post->arquivo_pdf && !empty($post->arquivo_pdf))
                            @php
                                // Decodificar o campo arquivo_pdf (caso seja um JSON contendo múltiplos PDFs)
                                $pdfs = json_decode($post->arquivo_pdf, true); // Convertendo para array associativo
                                if (!is_array($pdfs)) {
                                    // Se o JSON não for um array válido, tratamos como um único PDF
                                    $pdfs = [$post->arquivo_pdf];
                                }
                            @endphp
                            @foreach ($pdfs as $pdf)
                            <div class="container_pdf_file">
                            <a href="{{ asset($pdf) }}" target="_blank" class="pdf-item">
                                <div class="container_icon_pdf_file">
                                    <svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24.6944 6.71812L24.2661 6.29275L18.6578 0.72309L18.2294 0.297711C18.0356 0.105159 17.7667 -0.0057373 17.4917 -0.0057373H1.36833C0.709445 -0.0057373 0 0.499642 0 1.60861V21.5115V30.6354V30.8908C0 31.3526 0.467778 31.8028 1.02111 31.9446C1.04889 31.9518 1.07556 31.9623 1.10444 31.9678C1.19111 31.9849 1.27944 31.9943 1.36833 31.9943H23.6317C23.7206 31.9943 23.8089 31.9849 23.8956 31.9678C23.9244 31.9623 23.9511 31.9518 23.9789 31.9446C24.5322 31.8028 25 31.3526 25 30.8908V30.6354V21.5115V7.70626C25 7.28309 24.9489 6.97081 24.6944 6.71812ZM23.0194 6.61495H18.3333V1.96116L23.0194 6.61495ZM1.36833 30.8908C1.32889 30.8908 1.29333 30.8765 1.25833 30.8638C1.17167 30.823 1.11111 30.7369 1.11111 30.6354V22.615H23.8889V30.6354C23.8889 30.7369 23.8283 30.8224 23.7417 30.8638C23.7067 30.8765 23.6711 30.8908 23.6317 30.8908H1.36833ZM1.11111 21.5115V1.60861C1.11111 1.48888 1.12944 1.09771 1.36833 1.09771H17.2544C17.2361 1.16723 17.2222 1.23895 17.2222 1.31344V7.7184H23.6717C23.7467 7.7184 23.8183 7.70461 23.8883 7.6864C23.8883 7.69468 23.8889 7.69799 23.8889 7.70626V21.5115H1.11111Z" fill="#555555"/>
                                    <path d="M8.63443 24.6806C8.44943 24.5299 8.24054 24.4163 8.00776 24.3413C7.77498 24.2657 7.53943 24.2281 7.30165 24.2281H5.69165V29.7873H6.60332V27.7807H7.27943C7.57276 27.7807 7.84165 27.7382 8.08443 27.6527C8.32721 27.5672 8.53498 27.4464 8.70721 27.2908C8.87943 27.1352 9.01332 26.9426 9.10998 26.7137C9.20609 26.4847 9.25443 26.2298 9.25443 25.9479C9.25443 25.6814 9.19721 25.4414 9.08332 25.2273C8.96943 25.0133 8.81943 24.8317 8.63443 24.6806ZM8.28887 26.5173C8.23276 26.6706 8.15998 26.7898 8.06887 26.8753C7.97776 26.9608 7.87776 27.0226 7.76887 27.0601C7.65998 27.0977 7.54943 27.117 7.43832 27.117H6.60276V24.9145H7.28609C7.51887 24.9145 7.70609 24.9509 7.84832 25.0237C7.98998 25.0966 8.09998 25.187 8.17887 25.2952C8.25721 25.4033 8.30887 25.5164 8.33443 25.6345C8.35943 25.7526 8.37221 25.8568 8.37221 25.9473C8.37221 26.1741 8.34443 26.3639 8.28887 26.5173Z" fill="#555555"/>
                                    <path d="M14.1411 25.0425C13.9055 24.7964 13.6094 24.5984 13.2522 24.4505C12.895 24.3026 12.4811 24.2281 12.0105 24.2281H10.3244V29.7873H12.4433C12.5139 29.7873 12.6228 29.7785 12.77 29.7608C12.9167 29.7432 13.0789 29.7035 13.2561 29.64C13.4333 29.5771 13.6167 29.4828 13.8067 29.357C13.9967 29.2312 14.1672 29.059 14.3194 28.84C14.4717 28.621 14.5967 28.3495 14.6955 28.0251C14.7944 27.7007 14.8439 27.3095 14.8439 26.8521C14.8439 26.52 14.7855 26.1967 14.6694 25.8828C14.5522 25.5694 14.3767 25.2891 14.1411 25.0425ZM13.4767 28.5349C13.2033 28.9272 12.7578 29.123 12.14 29.123H11.2361V24.9139H11.7678C12.2033 24.9139 12.5578 24.9708 12.8311 25.0839C13.1044 25.197 13.3211 25.3454 13.4805 25.5291C13.64 25.7128 13.7472 25.9175 13.8033 26.1437C13.8589 26.3699 13.8867 26.5989 13.8867 26.8301C13.8867 27.5744 13.75 28.1432 13.4767 28.5349Z" fill="#555555"/>
                                    <path d="M16.1656 29.7873H17.0922V27.283H19.4317V26.6646H17.0922V24.9145H19.6667V24.2281H16.1656V29.7873Z" fill="#555555"/>
                                    <path d="M17.7378 12.6625C17.2272 12.6625 16.6006 12.7287 15.8722 12.86C14.8556 11.7886 13.7945 10.2239 13.0456 8.68791C13.7883 5.58225 13.4167 5.14253 13.2528 4.93508C13.0783 4.71439 12.8322 4.35632 12.5522 4.35632C12.435 4.35632 12.115 4.40929 11.9878 4.45122C11.6678 4.55715 11.4956 4.80212 11.3578 5.12156C10.965 6.03356 11.5039 7.58832 12.0583 8.78667C11.5845 10.6587 10.7895 12.8992 9.9539 14.7177C7.84834 15.6755 6.73001 16.6162 6.6289 17.5138C6.59223 17.8405 6.67001 18.3199 7.24834 18.7508C7.40667 18.8683 7.59223 18.9307 7.78556 18.9307C8.27167 18.9307 8.76279 18.561 9.33112 17.7682C9.74556 17.19 10.1906 16.4016 10.655 15.4228C12.1428 14.7767 13.9833 14.193 15.5595 13.8658C16.4372 14.7028 17.2233 15.1265 17.8989 15.1265C18.3967 15.1265 18.8233 14.8992 19.1322 14.4694C19.4539 14.022 19.5272 13.6214 19.3489 13.2777C19.135 12.8645 18.6078 12.6625 17.7378 12.6625ZM7.79779 17.9994C7.53779 17.8013 7.55279 17.6678 7.55834 17.6176C7.59279 17.3108 8.07667 16.7663 9.2639 16.1036C8.3639 17.7544 7.88056 17.9734 7.79779 17.9994ZM12.3533 5.35274C12.3772 5.34501 12.9339 5.96019 12.4067 7.12708C11.6145 6.32212 12.2989 5.37094 12.3533 5.35274ZM11.205 14.1947C11.7689 12.86 12.2933 11.3864 12.6906 10.0214C13.3145 11.1348 14.0639 12.2151 14.8139 13.0802C13.6283 13.3566 12.3661 13.7467 11.205 14.1947ZM18.3722 13.9304C18.2011 14.1682 17.83 14.1737 17.7 14.1737C17.4039 14.1737 17.2933 13.9988 16.8406 13.6529C17.2139 13.6054 17.5661 13.5933 17.8467 13.5933C18.3406 13.5933 18.4311 13.6656 18.4995 13.702C18.4872 13.7411 18.455 13.8151 18.3722 13.9304Z" fill="#555555"/>
                                    </svg>
                                </div>
                                <div class="container_content_file">
                                    
                                @php
                                    $nomeCompleto = pathinfo($pdf, PATHINFO_FILENAME); // Usa $pdf, não $post->arquivo_pdf
                                    $nomeSemTimestamp = preg_replace('/^\d+_/', '', $nomeCompleto);
                                @endphp
                                <p class="pdf-title">{{ $nomeSemTimestamp }}</p>
                                    <span>Toque para abrir o ficheiro</span>
                                    
                                </div>
                                <div class="container_icon_download_file">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 15.9943L7 10.9943L8.4 9.54426L11 12.1443V3.99426H13V12.1443L15.6 9.54426L17 10.9943L12 15.9943ZM6 19.9943C5.45 19.9943 4.97917 19.7984 4.5875 19.4068C4.19583 19.0151 4 18.5443 4 17.9943V14.9943H6V17.9943H18V14.9943H20V17.9943C20 18.5443 19.8042 19.0151 19.4125 19.4068C19.0208 19.7984 18.55 19.9943 18 19.9943H6Z" fill="#1D1B20"/>
                                    </svg>
                                </div>
                            </a>
                            </div>
                            @endforeach
                            @else
                            @endif
                        

                        <h3>{{Str::limit($post->title, 80)}}</h3>
                        <p class="expandir_post">{{Str::limit($post->content, 80)}}</p>
                        <p class="content-full" style="display: none;">{{ $post->content }}</p>
                        @if(strlen($post->content) > 80)
                            <button class="toggle-content-btn">Ver mais</button>
                        @endif
                    </div>
                    <hr style="width: 460px; margin: 0 auto;">
                    <div class="post-footer">
                        <div class="items-footerLista" data-postid="{{ $post->id }}">
                            
                            <span class="like-button globalHover" style="cursor: pointer;">
                                <img src="logo/img/icon/{{ Auth::user()->likes()->where('post_id', $post->id)->exists() && Auth::user()->likes()->where('post_id', $post->id)->first()->like ? 'ThumbsUp_pressed.svg' : 'icon_thumbs.svg' }}" class="like-icon" alt="">
                                <span class="like-count">{{ likes_post($post->id) }}</span>
                            </span>
                    
                            <span class="globalHover view-container">
                                <img src="logo/img/icon/Eye-icon.svg" alt="">
                                <span class="post-views-count" data-postid="{{ $post->id }}">{{ $post->views_count }}</span>
                                <div class="views-tooltip"></div>
                            </span>
                            <span class="comment-button globalHover" style="cursor: pointer;" onclick="toggleComments({{ $post->id }})">
                                <img src="logo/img/icon/mode_comment2.svg" alt="">
                                {{ $post->comments()->count() }}
                            </span>
                        </div>
                    </div>

                    <!-- Seção de Comentários -->
                    <div class="comments-section" id="comments-section-{{ $post->id }}" style="display: none;">
                        <!-- Formulário de Comentário -->
                        <form action="{{ route('comment.store', $post->id) }}" method="POST" class="comment-form">
                            @csrf
                            <div class="comment-input-container">
                                <img class="comment-avatar" src="{{ url('public/avatar_users/' . Auth::user()->avatar) }}" alt="">
                                <input type="text" name="comment" class="comment-input" placeholder="Adicionar um comentário" required>
                            </div>
                        </form>
                        <div class="comments-list">
                            @foreach($post->comments()->orderBy('created_at', 'desc')->get() as $comment)
                            <div class="comment-item" id="comment-{{ $comment->id }}">
                                    <div class="comment-header">
                                        <img class="comment-avatar" src="{{ url('public/avatar_users/' . $comment->user->avatar) }}" alt="">
                                        <div class="comment-info-container">
                                            <div class="comment-info">
                                                <div class="comment-info-header">
                                                    <span class="comment-author">{{ $comment->user->name }}</span>
                                                    <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="1.79962" cy="2.20752" r="1.5" fill="#D9D9D9"/>
                                                    </svg>
                                                    <span class="comment-date">{{ date('d/m/Y', strtotime($comment->created_at)) }}</span>
                                                </div>
                                            @if($comment->user_id == auth()->id() || $post->user_id == auth()->id())
                                                <div class="containerOpt">
                                                    <button class="btnOpt"  data-toggle="modal" data-target=".modalOpt-{{ $comment->id }}" style="margin: 0 !important; padding: 0 !important;"><img src="logo/img/icon/frame26.svg" alt="" ></button>
                                                    <div class="modal fade modalOpt modalOpt-{{ $comment->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body modal-bodyOpt">
                                                                <div class="containerBtnOpt">
                                                                    <button type="button" data-toggle="modal" style="border-bottom: none; border-top-left-radius: 5px; border-top-right-radius: 5px;" class="btnPosts editPostButton edit-comment-btn"  data-comment-id="{{ $comment->id }}" data-comment-body="{{ $comment->body }}">
                                                                        Editar
                                                                    </button>
                                                                    <button style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" type="button" class="btnPosts" onclick="deleteComment({{ $comment->id }})">
                                                                        Eliminar
                                                                    </button>
                                                            </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <span class="comment-user-cargo">{{ $comment->user->cargo->titulo }}</span>
                                        
                                        </div>
                                    
                                    </div>
                                <div class="comment-body">{{ $comment->body }}</div>
                                <div class="comment-actions hidden" id="comment-{{ $comment->id }}">
                                <span class="like-buttonComment {{ $comment->likes()->where('user_id', auth()->id())->exists() ? 'likedComment' : '' }}" 
                                        style="cursor: pointer;" 
                                        onclick="likeComment({{ $comment->id }})">
                                        <!-- O ícone começa invisível -->
                                        <img src="logo/img/icon/ThumbsUp_comentario.svg" class="like-iconComment" alt="" style="display: {{ $comment->likes()->where('user_id', auth()->id())->exists() ? 'inline' : 'none' }};">
                                        <span class="like-countComment">{{ $comment->likes()->count() }}.</span>
                                        <span>Gosto</span>
                                        
                                    </span>
                                    <span class="reply-button" style="cursor: pointer;" onclick="toggleReplyForm({{ $comment->id }})">
                                        Responder
                                    </span>
                                </div>


                               

                                <!-- Lista de Respostas -->
                                <div class="replies-list">
                                    
                                    <!-- Contêiner das respostas, inicialmente oculto -->
                                    <div class="replies-container" id="replies-{{ $comment->id }}" style="display: none;">
                                        @foreach($comment->replies()->orderBy('created_at', 'asc')->get() as $reply)
                                        <div class="reply-item">
                                            <div class="comment-header">
                                                <img class="comment-avatar" src="{{ url('public/avatar_users/' . $reply->user->avatar) }}" alt="">
                                                <div class="comment-info-container">
                                                    <div class="comment-info">
                                                        <div class="comment-info-header">
                                                            <span class="comment-author">{{ $reply->user->name }}</span>
                                                            <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="1.79962" cy="2.20752" r="1.5" fill="#D9D9D9"/>
                                                            </svg>
                                                            <span class="comment-date">{{ date('d/m/Y', strtotime($reply->created_at)) }}</span>
                                                        </div>
                                                    </div>
                                                    <span class="comment-user-cargo">{{ $comment->user->cargo->titulo }}</span>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="comment-body reply_container_actions" id="reply-{{ $reply->id }}">
                                                {{ $reply->body }}
                                                <div class="comment-actions">
                                                    <!-- Botão de Curtir -->
                                                    <span class="like-buttonCommentReply {{ $reply->isLikedBy(auth()->user()) ? 'likedReply' : '' }}" 
                                                        style="cursor: pointer;" 
                                                        onclick="likeReply({{ $reply->id }})">
                                                        <span class="like-iconReply" 
                                                            style="display: {{ $reply->isLikedBy(auth()->user()) ? 'inline' : 'none' }};"> <img src="logo/img/icon/ThumbsUp_comentario.svg" alt=""></span>
                                                        <span class="like-countReply">{{ $reply->likes()->count()  }}</span>
                                                        
                                                        <span>Gosto</span>
                                                        
                                                    </span>

                                                    <!-- Botão de Responder -->
                                                    <span class="reply-button" 
                                                        style="cursor: pointer;" 
                                                        onclick="toggleReplyForm({{ $comment->id }})">
                                                        Responder
                                                    </span>
                                                </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                                  <!-- Botão para expandir/recolher, exibido apenas se houver respostas -->
                                @if($comment->replies()->count() > 0)
                                <div class="toggle-replies" id="toggle-replies-{{ $comment->id }}" onclick="toggleReplies({{ $comment->id }})">
                                    <span>Ver mais {{ $comment->replies()->count() }} resposta{{ $comment->replies()->count() > 1 ? 's' : '' }}</span>
                                </div>
                                @endif
                                 <!-- Formulário de Resposta -->
                                 <div class="reply-form-container" id="reply-form-{{ $comment->id }}" style="display: none;">
                                    <form action="{{ route('comment.reply', $comment->id) }}" method="POST" class="reply-form">
                                        @csrf
                                        <div class="comment-input-container">
                                            <img class="comment-avatar" src="{{ url('public/avatar_users/' . Auth::user()->avatar) }}" alt="">
                                            <input type="text" name="reply" class="comment-input" placeholder="Responder ao comentário" required>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        <!-- Barra Lateral Direita -->
    <div class="sidebar-right">
        <!-- Eventos Recentes -->
        <h3>Anúncios em destaque</h3>
        <div class="eventos-recentes">
            <!-- Swiper -->
            <div class="swiper mySwiper mySwiperContainer">
                <div class="swiper-wrapper">
                    @foreach($posts as $post)
                    <div class="swiper-slide">
                        <div class="evento">
                            @if($post->arquivo_imagem)
                            <img src="{{ asset($post->arquivo_imagem) }}" alt="Imagem de Capa">
                            @endif
                            <div class="eventBody">
                                <p>{{ date('d/m/Y H:i', strtotime($post->created_at)) }}</p>
                                <h3>{{ Str::limit($post->title, 80) }}</h3>
                                <p class="textDescription">{{ Str::limit($post->content, 80) }}</p>
                                @if ($post->arquivo_pdf && !empty($post->arquivo_pdf))
                                    @php
                                        $pdfs = json_decode($post->arquivo_pdf, true);
                                        if (!is_array($pdfs)) {
                                            $pdfs = [$post->arquivo_pdf];
                                        }
                                    @endphp
                                    @foreach ($pdfs as $pdf)
                                    <div class="container_pdf_file">
                                        <a href="{{ asset($pdf) }}" target="_blank" class="pdf-item">
                                            <div class="container_icon_pdf_file">
                                                <svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M24.6944 6.71812L24.2661 6.29275L18.6578 0.72309L18.2294 0.297711C18.0356 0.105159 17.7667 -0.0057373 17.4917 -0.0057373H1.36833C0.709445 -0.0057373 0 0.499642 0 1.60861V21.5115V30.6354V30.8908C0 31.3526 0.467778 31.8028 1.02111 31.9446C1.04889 31.9518 1.07556 31.9623 1.10444 31.9678C1.19111 31.9849 1.27944 31.9943 1.36833 31.9943H23.6317C23.7206 31.9943 23.8089 31.9849 23.8956 31.9678C23.9244 31.9623 23.9511 31.9518 23.9789 31.9446C24.5322 31.8028 25 31.3526 25 30.8908V30.6354V21.5115V7.70626C25 7.28309 24.9489 6.97081 24.6944 6.71812ZM23.0194 6.61495H18.3333V1.96116L23.0194 6.61495ZM1.36833 30.8908C1.32889 30.8908 1.29333 30.8765 1.25833 30.8638C1.17167 30.823 1.11111 30.7369 1.11111 30.6354V22.615H23.8889V30.6354C23.8889 30.7369 23.8283 30.8224 23.7417 30.8638C23.7067 30.8765 23.6711 30.8908 23.6317 30.8908H1.36833ZM1.11111 21.5115V1.60861C1.11111 1.48888 1.12944 1.09771 1.36833 1.09771H17.2544C17.2361 1.16723 17.2222 1.23895 17.2222 1.31344V7.7184H23.6717C23.7467 7.7184 23.8183 7.70461 23.8883 7.6864C23.8883 7.69468 23.8889 7.69799 23.8889 7.70626V21.5115H1.11111Z" fill="#555555"/>
                                                    <path d="M8.63443 24.6806C8.44943 24.5299 8.24054 24.4163 8.00776 24.3413C7.77498 24.2657 7.53943 24.2281 7.30165 24.2281H5.69165V29.7873H6.60332V27.7807H7.27943C7.57276 27.7807 7.84165 27.7382 8.08443 27.6527C8.32721 27.5672 8.53498 27.4464 8.70721 27.2908C8.87943 27.1352 9.01332 26.9426 9.10998 26.7137C9.20609 26.4847 9.25443 26.2298 9.25443 25.9479C9.25443 25.6814 9.19721 25.4414 9.08332 25.2273C8.96943 25.0133 8.81943 24.8317 8.63443 24.6806ZM8.28887 26.5173C8.23276 26.6706 8.15998 26.7898 8.06887 26.8753C7.97776 26.9608 7.87776 27.0226 7.76887 27.0601C7.65998 27.0977 7.54943 27.117 7.43832 27.117H6.60276V24.9145H7.28609C7.51887 24.9145 7.70609 24.9509 7.84832 25.0237C7.98998 25.0966 8.09998 25.187 8.17887 25.2952C8.25721 25.4033 8.30887 25.5164 8.33443 25.6345C8.35943 25.7526 8.37221 25.8568 8.37221 25.9473C8.37221 26.1741 8.34443 26.3639 8.28887 26.5173Z" fill="#555555"/>
                                                    <path d="M14.1411 25.0425C13.9055 24.7964 13.6094 24.5984 13.2522 24.4505C12.895 24.3026 12.4811 24.2281 12.0105 24.2281H10.3244V29.7873H12.4433C12.5139 29.7873 12.6228 29.7785 12.77 29.7608C12.9167 29.7432 13.0789 29.7035 13.2561 29.64C13.4333 29.5771 13.6167 29.4828 13.8067 29.357C13.9967 29.2312 14.1672 29.059 14.3194 28.84C14.4717 28.621 14.5967 28.3495 14.6955 28.0251C14.7944 27.7007 14.8439 27.3095 14.8439 26.8521C14.8439 26.52 14.7855 26.1967 14.6694 25.8828C14.5522 25.5694 14.3767 25.2891 14.1411 25.0425ZM13.4767 28.5349C13.2033 28.9272 12.7578 29.123 12.14 29.123H11.2361V24.9139H11.7678C12.2033 24.9139 12.5578 24.9708 12.8311 25.0839C13.1044 25.197 13.3211 25.3454 13.4805 25.5291C13.64 25.7128 13.7472 25.9175 13.8033 26.1437C13.8589 26.3699 13.8867 26.5989 13.8867 26.8301C13.8867 27.5744 13.75 28.1432 13.4767 28.5349Z" fill="#555555"/>
                                                    <path d="M16.1656 29.7873H17.0922V27.283H19.4317V26.6646H17.0922V24.9145H19.6667V24.2281H16.1656V29.7873Z" fill="#555555"/>
                                                    <path d="M17.7378 12.6625C17.2272 12.6625 16.6006 12.7287 15.8722 12.86C14.8556 11.7886 13.7945 10.2239 13.0456 8.68791C13.7883 5.58225 13.4167 5.14253 13.2528 4.93508C13.0783 4.71439 12.8322 4.35632 12.5522 4.35632C12.435 4.35632 12.115 4.40929 11.9878 4.45122C11.6678 4.55715 11.4956 4.80212 11.3578 5.12156C10.965 6.03356 11.5039 7.58832 12.0583 8.78667C11.5845 10.6587 10.7895 12.8992 9.9539 14.7177C7.84834 15.6755 6.73001 16.6162 6.6289 17.5138C6.59223 17.8405 6.67001 18.3199 7.24834 18.7508C7.40667 18.8683 7.59223 18.9307 7.78556 18.9307C8.27167 18.9307 8.76279 18.561 9.33112 17.7682C9.74556 17.19 10.1906 16.4016 10.655 15.4228C12.1428 14.7767 13.9833 14.193 15.5595 13.8658C16.4372 14.7028 17.2233 15.1265 17.8989 15.1265C18.3967 15.1265 18.8233 14.8992 19.1322 14.4694C19.4539 14.022 19.5272 13.6214 19.3489 13.2777C19.135 12.8645 18.6078 12.6625 17.7378 12.6625ZM7.79779 17.9994C7.53779 17.8013 7.55279 17.6678 7.55834 17.6176C7.59279 17.3108 8.07667 16.7663 9.2639 16.1036C8.3639 17.7544 7.88056 17.9734 7.79779 17.9994ZM12.3533 5.35274C12.3772 5.34501 12.9339 5.96019 12.4067 7.12708C11.6145 6.32212 12.2989 5.37094 12.3533 5.35274ZM11.205 14.1947C11.7689 12.86 12.2933 11.3864 12.6906 10.0214C13.3145 11.1348 14.0639 12.2151 14.8139 13.0802C13.6283 13.3566 12.3661 13.7467 11.205 14.1947ZM18.3722 13.9304C18.2011 14.1682 17.83 14.1737 17.7 14.1737C17.4039 14.1737 17.2933 13.9988 16.8406 13.6529C17.2139 13.6054 17.5661 13.5933 17.8467 13.5933C18.3406 13.5933 18.4311 13.6656 18.4995 13.702C18.4872 13.7411 18.455 13.8151 18.3722 13.9304Z" fill="#555555"/>
                                                </svg>
                                            </div>
                                            <div class="container_content_file">
                                                @php
                                                    $nomeCompleto = pathinfo($pdf, PATHINFO_FILENAME);
                                                    $nomeSemTimestamp = preg_replace('/^\d+_/', '', $nomeCompleto);
                                                @endphp
                                                <p class="pdf-title">{{ $nomeSemTimestamp }}</p>
                                                <span>Toque para abrir o ficheiro</span>
                                            </div>
                                            <div class="container_icon_download_file">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 15.9943L7 10.9943L8.4 9.54426L11 12.1443V3.99426H13V12.1443L15.6 9.54426L17 10.9943L12 15.9943ZM6 19.9943C5.45 19.9943 4.97917 19.7984 4.5875 19.4068C4.19583 19.0151 4 18.5443 4 17.9943V14.9943H6V17.9943H18V14.9943H20V17.9943C20 18.5443 19.8042 19.0151 19.4125 19.4068C19.0208 19.7984 18.55 19.9943 18 19.9943H6Z" fill="#1D1B20"/>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                @endif
                                <button style="padding: 0 !important; margin: 0 !important;">Ver</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
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


<div class="modal escurecer" id="modalPreviewImagem" tabindex="-1" aria-labelledby="createPostModal" aria-hidden="true" data-backdrop="false" data-keyboard="true" data-action="">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="bg-white rounded-lg shadow-lg mainContainerPreviewImg">
                     <div class="containerSidesPreview">
                         <div class="leftSideContainerPreview">
                                <!-- Miniaturas -->
                                <div id="thumbnails" class="flex gap-2 miniaturaContainer overflow-x-auto"></div>
                                        <!-- Área de Visualização -->
                                <div class="containerShowPreview relative w-full h-52 border-dashed flex items-center justify-center">
                                    <input type="file" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer ">
                                    <div id="preview" class="text-gray-400 text-sm text-center relative">
                
                                    </div>
                                    <button id="prevBtn" class="absolute left-2 hidden nextPrevBtnPreview">&#10094;</button>
                                    <button id="nextBtn" class="absolute right-2 hidden nextPrevBtnPreview">&#10095;</button>
                                    <button id="deleteBtn" class="absolute deleteBtnPreview hidden"><svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.7363 7.97693L21.0592 6.2998L14.4101 12.9488L7.76111 6.2998L6.08398 7.97693L12.733 14.626L6.08398 21.275L7.76111 22.9521L14.4101 16.3031L21.0592 22.9521L22.7363 21.275L16.0873 14.626L22.7363 7.97693Z" fill="#555555"/>
                                        </svg>
                                        </button>
                                </div>
                         </div>
                
                
                
                        <!-- Botões -->
                        <div class="rightSideContainerPreview">
                            <div class="closeAndTitleContainerPreview">
                                <h2>Comunicações gerais</h2>
                                <span class="close closeModalPreview" aria-label="Close">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#555555"/>
                                </svg>

                                </span>
                            </div>
                            <hr>
                            <div class="headerContainerPreviewRightSide">
                                <img src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                
                                <div class="contentTextHeaderPreviewRightSide">
                                    <span>{{ Auth::user()->name }}</span>
                                    <span class="hidden">Todos podem comentar</span>
                                </div>
                            </div>
                            <div class="containerBodyInputs">
                                <input class="titleInputPost" id="modalTitle" type="text" placeholder="Adiciona um título ao comunicado">
                                <textarea class="contentTextarea" id="modalContent" placeholder="Comece a escrever aqui!"></textarea>
                            </div>
                            <div class="containerBtnPreview">
                                <button id="addMoreBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 13.5H13V19.5H11V13.5H5V11.5H11V5.5H13V11.5H19V13.5Z" fill="#555555"/>
                                    </svg>
                                    </button>
                                <button id="uploadBtn">Publicar</button>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal escurecer" id="modalViewPost" tabindex="-1" aria-labelledby="viewPostModal" aria-hidden="true" data-backdrop="false" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="bg-white rounded-lg shadow-lg mainContainerPreviewImg">
                    <div class="containerSidesPreview">
                        <div class="leftSideContainerPreview">
                            <!-- Área de Visualização -->
                            <div class="containerShowPreview relative w-full h-52 border-dashed flex items-center justify-center">
                                <div id="postPreview" class="text-gray-400 text-sm text-center relative w-full h-full">
                                    <img src="" alt="Imagem do Post" class="w-full h-full imgMainPreview postImage">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Conteúdo do Post -->
                        <div class="rightSideContainerPreview">
                            
                            <div class="topHeaderSideContainerPreview">
                                <div class="headerContainerPreviewRightSide">
                                    <img class="postUserAvatar" src="" alt="Avatar do Usuário">
                                    <div class="contentTextHeaderPreviewRightSide">
                                        <div class="containerHeaderPostView">
                                            <div class="dateAndUserName">
                                                <span id="postUserName"></span>
                                                <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="1.79962" cy="2.20752" r="1.5" fill="#D9D9D9"/>
                                                </svg>
                                                <span id="postsDates"></span>
                                            </div>
                                            <div class="optAndCloseBtn">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.2974 20.167C11.9017 20.167 11.5643 20.0266 11.2851 19.7457C11.0059 19.4651 10.8664 19.1269 10.8664 18.7312C10.8664 18.3356 11.0067 17.9982 11.2874 17.719C11.5682 17.4398 11.9064 17.3002 12.3019 17.3002C12.6975 17.3002 13.0349 17.4407 13.3141 17.7215C13.5933 18.0022 13.7329 18.3403 13.7329 18.736C13.7329 19.1317 13.5925 19.4691 13.3119 19.7482C13.031 20.0274 12.6929 20.167 12.2974 20.167ZM12.2974 13.4335C11.9017 13.4335 11.5643 13.2932 11.2851 13.0125C11.0059 12.7317 10.8664 12.3935 10.8664 11.998C10.8664 11.6023 11.0067 11.2649 11.2874 10.9857C11.5682 10.7066 11.9064 10.567 12.3019 10.567C12.6975 10.567 13.0349 10.7073 13.3141 10.988C13.5933 11.2688 13.7329 11.607 13.7329 12.0025C13.7329 12.3982 13.5925 12.7356 13.3119 13.0147C13.031 13.2939 12.6929 13.4335 12.2974 13.4335ZM12.2974 6.70025C11.9017 6.70025 11.5643 6.55983 11.2851 6.279C11.0059 5.99833 10.8664 5.66016 10.8664 5.2645C10.8664 4.86883 11.0067 4.53141 11.2874 4.25225C11.5682 3.97308 11.9064 3.8335 12.3019 3.8335C12.6975 3.8335 13.0349 3.97391 13.3141 4.25475C13.5933 4.53541 13.7329 4.87358 13.7329 5.26925C13.7329 5.66491 13.5925 6.00233 13.3119 6.2815C13.031 6.56066 12.6929 6.70025 12.2974 6.70025Z" fill="#5F6368"/>
                                                </svg>
                                                <span class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.2996 6.41049L17.8896 5.00049L12.2996 10.5905L6.70962 5.00049L5.29962 6.41049L10.8896 12.0005L5.29962 17.5905L6.70962 19.0005L12.2996 13.4105L17.8896 19.0005L19.2996 17.5905L13.7096 12.0005L19.2996 6.41049Z" fill="#555555"/>
                                                    </svg>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="cargoUser"></span>
                                        <span class="hidden">Todos podem comentar</span>
                                    </div>
                                
                                
                                
                                </div>
                                <div class="containerGeralComments">
                                    <div class="containerBodyInputs">
                                        <h4 class="titleInputPost" id="postTitle"></h4>
                                        <p class="contentTextarea" id="postContent"></p>
                                    </div>
                                
                                
                                
                                </div>
                            </div>
                            <div class="containerComments">
                                
                                    <div class="items-footer" data-postid="">
                                        <span class="like-button globalHover" style="cursor: pointer;">
                                            <img src="logo/img/icon/{{ Auth::user()->likes()->where('post_id', $post->id)->exists() && Auth::user()->likes()->where('post_id', $post->id)->first()->like ? 'ThumbsUp_pressed.svg' : 'icon_thumbs.svg' }}" class="like-icon" alt="">
                                            <span class="like-count">{{ likes_post($post->id) }}</span>
                                            
                                        </span>
                                
                                        <span class="globalHover view-container">
                                            <img src="logo/img/icon/Eye-icon.svg" alt="">
                                            <span class="views-count"></span>
                                            <div class="views-tooltip"></div>
                                        </span>
                                        <span class="globalHover">
                                            <img src="logo/img/icon/mode_comment2.svg" alt="">
                                            <span class="comment-count"></span>
                                        </span>
                                    </div>
                                    <form class="comment-form" id="modalCommentForm" action="" method="POST">
                                            @csrf
                                            <div class="containerEnterComment">
                                            <img class="img_user_post" src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                                                <input type="text" name="comment" placeholder="Adicione um comentário..." required>
                                            </div>
                                    </form>
                                <!-- Seção de Comentários -->
                                <div class="comments-section" id="modalCommentsSection">
                                    <div class="comments-list" id="modalCommentsList">
                                        <!-- Os comentários serão carregados dinamicamente aqui -->
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('frontend/home/script.js') }}"></script>
<script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>

     <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper --><script>
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
    // const dropArea = document.getElementById('drop-area');
    // const fileElem = document.getElementById('fileElem');

    // dropArea.addEventListener('click', () => fileElem.click());
    // ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    //     dropArea.addEventListener(eventName, preventDefaults, false);
    // });

    // function preventDefaults(e) {
    //     e.preventDefault();
    //     e.stopPropagation();
    // }

    // ['dragenter', 'dragover'].forEach(eventName => {
    //     dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#e0e0e0', false);
    // });

    // ['dragleave', 'drop'].forEach(eventName => {
    //     dropArea.addEventListener(eventName, () => dropArea.style.backgroundColor = '#f9f9f9', false);
    // });

    // dropArea.addEventListener('drop', handleDrop, false);

    // function handleDrop(e) {
    //     const dt = e.dataTransfer;
    //     const files = dt.files;
    //     handleFiles(files);
    // }

    // function handleFiles(files) {
    //     const file = files[0];
    //     const reader = new FileReader();
    //     reader.onload = function(e) {
    //         const img = document.createElement('img');
    //         img.src = e.target.result;
    //         dropArea.innerHTML = ''; 
    //         dropArea.appendChild(img);
    //     };
    //     reader.readAsDataURL(file);
    // }

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
        allFiles = [];
        removedPdfs = [];
        console.log('Abrindo modalEdit');
        $('#modalEdit').removeClass('hidden-by-code').css('display', '').modal('show');
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const title = button.data('title');
        const content = button.data('content');

        const modal = $(this);
        modal.find('#title').val(title);
        modal.find('#content').val(content);
        modal.find('form').attr('action', `{{ route('post.update', ['post' => '__POST_ID__']) }}`.replace('__POST_ID__', id));

        // Atualizar campos do modal de preview
        $('#modalTitle').val(title);
        $('#modalContent').val(content);
        $('#modalTitle').removeAttr('readonly').removeAttr('disabled');
        $('#modalContent').removeAttr('readonly').removeAttr('disabled');

        // Buscar a imagem do post atual
        const postImage = $('.postOnly').find(`[data-id="${id}"]`).closest('.postOnly').find('.size_img_post img').attr('src');
    
        if (postImage) {
            images = [];
            images.push(postImage);
            updateThumbnails();
            showImage(0);
            $("#modalEdit").addClass("hidden-by-code").modal("hide");
            $("#modalPreviewImagem").modal("show");
            console.log("tem imagem")
        } else{
            console.log("não tem imagem")
        }

        // Carregar PDFs existentes via AJAX
        console.log('Iniciando AJAX para PDFs');
        $.ajax({
            url: `{{ route('post.edit', ['post' => '__POST_ID__']) }}`.replace('__POST_ID__', id),
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (data) {
                console.log('Resposta AJAX:', data);
                if (data.success) {
                    allFiles = [];
                    removedPdfs = [];
                    if (!fileContainerEdit) {
                        console.error('fileContainerEdit não encontrado no DOM');
                        return;
                    }
                    fileContainerEdit.innerHTML = "";
                    console.log('fileContainerEdit limpo');

                    const pdfPaths = data.post.arquivo_pdf ? JSON.parse(data.post.arquivo_pdf) : [];
                    console.log('PDFs encontrados:', pdfPaths);
                    pdfPaths.forEach(pdfPath => {
                        const fileName = pdfPath.split('/').pop();
                        const fileItem = document.createElement("div");
                        fileItem.className = "file-item";
                        fileItem.innerHTML = `
                            <div class="flex items-center space-x-3 w-full">
                                <span>
                                    <svg width="26" height="34" viewBox="0 0 26 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25.2905 7.43398L24.8518 6.99531L19.1081 1.2516L18.6695 0.812931C18.4709 0.614362 18.1955 0.5 17.9139 0.5H1.40136C0.726569 0.5 0 1.02117 0 2.16479V22.6897V32.0986V32.3621C0 32.8383 0.479069 33.3026 1.04576 33.4488C1.07421 33.4562 1.10152 33.467 1.1311 33.4727C1.21986 33.4903 1.31033 33.5 1.40136 33.5H24.2021C24.2931 33.5 24.3836 33.4903 24.4723 33.4727C24.5019 33.467 24.5292 33.4562 24.5577 33.4488C25.1244 33.3026 25.6035 32.8383 25.6035 32.3621V32.0986V22.6897V8.453C25.6035 8.0166 25.5511 7.69457 25.2905 7.43398ZM23.5751 7.32759H18.7759V2.52836L23.5751 7.32759ZM1.40136 32.3621C1.36097 32.3621 1.32455 32.3473 1.28871 32.3342C1.19995 32.2921 1.13793 32.2033 1.13793 32.0986V23.8276H24.4655V32.0986C24.4655 32.2033 24.4035 32.2915 24.3147 32.3342C24.2789 32.3473 24.2425 32.3621 24.2021 32.3621H1.40136ZM1.13793 22.6897V2.16479C1.13793 2.04133 1.15671 1.63793 1.40136 1.63793H17.6709C17.6522 1.70962 17.6379 1.78359 17.6379 1.8604V8.46552H24.2431C24.3199 8.46552 24.3933 8.45129 24.465 8.43252C24.465 8.44105 24.4655 8.44447 24.4655 8.453V22.6897H1.13793Z" fill="#555555"/>
                                    <path d="M8.84291 25.9578C8.65345 25.8025 8.43951 25.6853 8.20112 25.6079C7.96272 25.53 7.72148 25.4913 7.47796 25.4913H5.8291V31.2242H6.76277V29.1548H7.4552C7.75562 29.1548 8.031 29.111 8.27964 29.0228C8.52827 28.9347 8.74107 28.81 8.91745 28.6496C9.09382 28.4892 9.23095 28.2906 9.32995 28.0545C9.42838 27.8183 9.47788 27.5555 9.47788 27.2647C9.47788 26.9899 9.41927 26.7424 9.30264 26.5217C9.186 26.3009 9.03238 26.1137 8.84291 25.9578ZM8.48901 27.8519C8.43155 28.0101 8.35701 28.133 8.2637 28.2212C8.17039 28.3094 8.06798 28.3731 7.95646 28.4118C7.84495 28.4505 7.73172 28.4704 7.61793 28.4704H6.7622V26.1991H7.46203C7.70043 26.1991 7.89217 26.2366 8.03783 26.3117C8.18291 26.3868 8.29557 26.4801 8.37636 26.5917C8.45658 26.7032 8.5095 26.8198 8.53567 26.9416C8.56127 27.0633 8.57436 27.1709 8.57436 27.2642C8.57436 27.498 8.54591 27.6937 8.48901 27.8519Z" fill="#555555"/>
                                    <path d="M14.4825 26.3311C14.2413 26.0773 13.938 25.873 13.5722 25.7206C13.2063 25.5681 12.7825 25.4913 12.3005 25.4913H10.5737V31.2242H12.7438C12.816 31.2242 12.9275 31.2151 13.0783 31.1969C13.2285 31.1787 13.3947 31.1377 13.5762 31.0723C13.7577 31.0074 13.9454 30.9101 14.14 30.7804C14.3346 30.6507 14.5093 30.4731 14.6652 30.2473C14.8211 30.0214 14.9491 29.7414 15.0504 29.4069C15.1516 29.0723 15.2023 28.6689 15.2023 28.1973C15.2023 27.8548 15.1425 27.5213 15.0236 27.1976C14.9036 26.8744 14.7238 26.5854 14.4825 26.3311ZM13.802 29.9326C13.5221 30.3372 13.0658 30.5391 12.4331 30.5391H11.5074V26.1985H12.0519C12.498 26.1985 12.861 26.2571 13.1409 26.3737C13.4208 26.4904 13.6427 26.6434 13.806 26.8329C13.9693 27.0224 14.0791 27.2334 14.1366 27.4667C14.1935 27.7 14.2219 27.9361 14.2219 28.1745C14.2219 28.942 14.082 29.5287 13.802 29.9326Z" fill="#555555"/>
                                    <path d="M16.1656 29.7873H17.0922V27.283H19.4317V26.6646H17.0922V24.9145H19.6667V24.2281H16.1656V29.7873Z" fill="#555555"/>
                                    <path d="M17.7378 12.6625C17.2272 12.6625 16.6006 12.7287 15.8722 12.86C14.8556 11.7886 13.7945 10.2239 13.0456 8.68791C13.7883 5.58225 13.4167 5.14253 13.2528 4.93508C13.0783 4.71439 12.8322 4.35632 12.5522 4.35632C12.435 4.35632 12.115 4.40929 11.9878 4.45122C11.6678 4.55715 11.4956 4.80212 11.3578 5.12156C10.965 6.03356 11.5039 7.58832 12.0583 8.78667C11.5845 10.6587 10.7895 12.8992 9.9539 14.7177C7.84834 15.6755 6.73001 16.6162 6.6289 17.5138C6.59223 17.8405 6.67001 18.3199 7.24834 18.7508C7.40667 18.8683 7.59223 18.9307 7.78556 18.9307C8.27167 18.9307 8.76279 18.561 9.33112 17.7682C9.74556 17.19 10.1906 16.4016 10.655 15.4228C12.1428 14.7767 13.9833 14.193 15.5595 13.8658C16.4372 14.7028 17.2233 15.1265 17.8989 15.1265C18.3967 15.1265 18.8233 14.8992 19.1322 14.4694C19.4539 14.022 19.5272 13.6214 19.3489 13.2777C19.135 12.8645 18.6078 12.6625 17.7378 12.6625ZM7.79779 17.9994C7.53779 17.8013 7.55279 17.6678 7.55834 17.6176C7.59279 17.3108 8.07667 16.7663 9.2639 16.1036C8.3639 17.7544 7.88056 17.9734 7.79779 17.9994ZM12.3533 5.35274C12.3772 5.34501 12.9339 5.96019 12.4067 7.12708C11.6145 6.32212 12.2989 5.37094 12.3533 5.35274ZM11.205 14.1947C11.7689 12.86 12.2933 11.3864 12.6906 10.0214C13.3145 11.1348 14.0639 12.2151 14.8139 13.0802C13.6283 13.3566 12.3661 13.7467 11.205 14.1947ZM18.3722 13.9304C18.2011 14.1682 17.83 14.1737 17.7 14.1737C17.4039 14.1737 17.2933 13.9988 16.8406 13.6529C17.2139 13.6054 17.5661 13.5933 17.8467 13.5933C18.3406 13.5933 18.4311 13.6656 18.4995 13.702C18.4872 13.7411 18.455 13.8151 18.3722 13.9304Z" fill="#555555"/>
                                </svg>
                                </span>
                                <div class="flex-1">
                                    <p class="font-semibold truncate">${fileName}</p>
                                    <p class="textAbrirContainerPDF">Toque para abrir o ficheiro</p>
                                </div>
                            </div>
                            <button onclick="removeFile(this, '${fileName.replace(/'/g, "\\'")}', 'fileContainerEdit')">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.6035 6.41L18.1935 5L12.6035 10.59L7.01352 5L5.60352 6.41L11.1935 12L5.60352 17.59L7.01352 19L12.6035 13.41L18.1935 19L19.6035 17.59L14.0135 12L19.6035 6.41Z" fill="#555555"/>
                                </svg>
                            </button>
                        `;
                        fileContainerEdit.appendChild(fileItem);
                        allFiles.push(new File([new Blob()], fileName, { type: "application/pdf" }));
                        console.log('Adicionado PDF:', fileName);
                    });

                    const btnMore = document.createElement("div");
                    btnMore.className = "btnMore";
                    btnMore.innerHTML = `
                        <span id="addFileBtnEdit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="#555555"/>
                        </svg>
                        </span>
                    `;
                    fileContainerEdit.appendChild(btnMore);
                    console.log('Botão "Mais" adicionado');

                    updateMaxWidth(fileContainerEdit);
                    checkFileContainer(fileContainerEdit, outroContainerEdit, btnContainerPostEdit);
                } else {
                    console.error('Dados inválidos:', data);
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar PDFs.' });
            }
        });
    });
    
    $('#modalPreviewImagem').on('hidden.bs.modal', function () {
        // Mostra novamente quando o modalPreview for fechado
        images = []; // Reseta o array de imagens
        $("#modalPreviewImagem").addClass("hidden-by-code").modal("hide");
    
    });
    // Envio do formulário via AJAX
    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        console.log('Evento submit disparado');
        const formData = new FormData(this);

        formData.delete("arquivo_pdf[]");
        // Log para depuração
        console.log('Arquivos a enviar:', allFiles.length);
        console.log('Nomes dos arquivos:', allFiles.map(f => f.name).join(', '));

        // Adicionar cada arquivo ao formData
    if (allFiles && allFiles.length > 0) {
        allFiles.forEach(file => {
            // Verificar se o arquivo é válido antes de adicionar
            if (file instanceof File && file.size > 0) {
                console.log('Adicionando arquivo:', file.name, 'Tamanho:', file.size);
                formData.append("arquivo_pdf[]", file);
            } else {
                console.error('Arquivo inválido encontrado:', file);
            }
        });
    }
       // Adicionar lista de PDFs removidos
    if (removedPdfs && removedPdfs.length > 0) {
        console.log('PDFs a remover:', removedPdfs);
        formData.append("removed_pdfs", JSON.stringify(removedPdfs));
    }

        formData.append('_method', 'PUT');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#modalEdit').modal('hide');
                
                Swal.fire({
                    timer: 2000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    title: 'A sua publicação foi editada.',
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos'
                    },
                    willClose: () => {
                        window.location.reload(true)
                    }
                });
            },
            error: function (xhr, status, error) {
            console.error('Status do erro:', status);
            console.error('Mensagem de erro:', error);
            console.error('Resposta completa:', xhr.responseText);
            }
        });
    });

    // Lógica do botão de curtida
    let likeInProgress = false; // Flag para controle do envio

    $(document).on('click', '.like-button', function(event) {
        event.preventDefault();

        if (likeInProgress) return;
    likeInProgress = true;

    // Verifica se o clique veio da lista ou do modal
    const footerLista = $(this).closest('.items-footerLista'); // Lista de posts
    const footerModal = $(this).closest('.items-footer'); // Modal
    const footer = footerLista.length ? footerLista : footerModal; // Usa o que for encontrado

    const postId = footer.attr('data-postid'); // Lê o data-postid com .attr()

    console.log('Origem do clique:', footerLista.length ? 'Lista' : 'Modal');
    console.log('Post ID enviado:', postId);

    if (!postId) {
        console.error('Post ID indefinido! Verifique o data-postid no elemento.');
        likeInProgress = false;
        return;
    }

    const icon = $(this).find('.like-icon');
    const countElement = $(this).find('.like-count');
    const isLiked = icon.hasClass('liked');

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
                const newCount = response.likes_count;
                countElement.text(newCount);
                // Atualiza o contador na lista e no modal
                $(`.items-footerLista[data-postid="${postId}"] .like-count`).text(newCount);
                $(`.items-footer[data-postid="${postId}"] .like-count`).text(newCount);

                const newIconSrc = isLiked ? 'logo/img/icon/icon_thumbs.svg' : 'logo/img/icon/ThumbsUp_pressed.svg';
                const newClassAction = isLiked ? 'removeClass' : 'addClass';

                icon.attr('src', newIconSrc)[newClassAction]('liked');
                // Atualiza o ícone na lista e no modal
                $(`.items-footerLista[data-postid="${postId}"] .like-icon`).attr('src', newIconSrc)[newClassAction]('liked');
                $(`.items-footer[data-postid="${postId}"] .like-icon`).attr('src', newIconSrc)[newClassAction]('liked');
            } else {
                alert(response.message || 'Erro ao registrar a curtida.');
            }
        },
        error: function(xhr) {
            console.error('Erro AJAX:', xhr.responseText);
            alert('Ocorreu um erro. Tente novamente.');
        },
        complete: function() {
            likeInProgress = false;
        }
        });
    });
});

let images = [];
let currentIndex = 0;
const fileInput = document.getElementById("fileInput");
const preview = document.getElementById("preview");
const thumbnails = document.getElementById("thumbnails");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const addMoreBtn = document.getElementById("addMoreBtn");
const deleteBtn = document.getElementById("deleteBtn");

        fileInput.addEventListener("change", handleFiles);
        prevBtn.addEventListener("click", () => changeImage(-1));
        nextBtn.addEventListener("click", () => changeImage(1));
        deleteBtn.addEventListener("click", deleteImage);

        addMoreBtn.addEventListener("click", () => {
        fileInput.value = ""; // Reseta o input para garantir que o evento "change" dispare mesmo se o usuário cancelar
        fileInput.click();
        });
        
        fileInput.addEventListener("click", () => {
            fileInput.value = ""; // Reseta o input antes de abrir
        });

        fileInput.addEventListener("change", function (event) {
            document.getElementById("arquivo_imagem").files = event.target.files;
        });

        fileInput.addEventListener("change", (event) => {
            if (!event.target.files.length && images.length === 0) {
                $("#modalPreviewImagem").modal("hide");
            }
        });
        
        function handleFiles(event) {
            const files = event.target.files;
            
            if (files.length === 0 && images.length === 0) {
                // Fecha o modal se nenhum arquivo for selecionado e não houver imagens
                $("#modalPreviewImagem").modal("hide");
                return;
            }

            for (let file of files) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    images.push(e.target.result);
                    updateThumbnails();
                    showImage(images.length - 1);
                };
                reader.readAsDataURL(file);
            }
        }

        function updateThumbnails() {
    thumbnails.innerHTML = "";
    if (images.length > 1) {
        thumbnails.classList.remove("hidden");
        images.forEach((imgSrc, index) => {
            const wrapper = document.createElement("div"); // Cria um container para a imagem
            wrapper.className = "thumbnail-wrapper"; // Classe para o container

            const img = document.createElement("img");
            img.src = imgSrc;
            img.className = "thumbnail-image  w-12 h-12 object-cover cursor-pointer border-2";
            img.addEventListener("click", () => showImage(index));

            wrapper.appendChild(img); // Adiciona a imagem ao container
            thumbnails.appendChild(wrapper);
        });
    } else {
        thumbnails.classList.add("hidden");
    }
}


        function showImage(index) {
            if (images.length > 0) {
                currentIndex = index;
                preview.innerHTML = `<img src="${images[index]}" class="w-full h-full imgMainPreview">`;
                prevBtn.classList.toggle("hidden", index === 0);
                nextBtn.classList.toggle("hidden", index === images.length - 1);
                deleteBtn.classList.remove("hidden");

                 
        // Remove a classe ativa de todas as miniaturas
        document.querySelectorAll(".thumbnail-wrapper").forEach(wrapper => {
            wrapper.classList.remove("active-thumbnail");
        });

        // Adiciona a classe ativa apenas à miniatura atual - COM VERIFICAÇÃO
        const thumbnails = document.querySelectorAll(".thumbnail-wrapper");
        if (thumbnails.length > 0 && index < thumbnails.length) {
            thumbnails[index].classList.add("active-thumbnail");
        } else {
            console.log("Thumbnail de índice " + index + " não encontrado. Total de thumbnails: " + thumbnails.length);
        }
    }
        }

        function changeImage(direction) {
            let newIndex = currentIndex + direction;
            if (newIndex >= 0 && newIndex < images.length) {
                showImage(newIndex);
            }
        }

        function deleteImage() {
            if (images.length > 0) {
                images.splice(currentIndex, 1);
                updateThumbnails();
                if (images.length > 0) {
                    showImage(0);
                } else {
                    preview.innerHTML = '';
                    deleteBtn.classList.add("hidden");
                    prevBtn.classList.add("hidden");
                    nextBtn.classList.add("hidden");
                    thumbnails.classList.add("hidden");

                    $("#modalPreviewImagem").modal("hide");
                    $("#modalEdit").modal('show');
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const label = document.querySelector(".openModalPreview");
            const previewContainer = document.getElementById("preview");
            const modal = document.getElementById("modalPreviewImagem");

            label.addEventListener("click", function (event) {
                event.preventDefault(); // Evita a abertura padrão do modal
                modal.setAttribute("data-action", "create"); // Define como criação
                images = []; // Reseta as imagens para um novo post
                preview.innerHTML = ''; // Limpa o preview
                updateThumbnails(); // Atualiza as miniaturas
                fileInput.click(); // Simula o clique no input de arquivo
            });

            // Para edição (adicione um botão ou evento específico para editar)
            // Exemplo: se houver um botão com classe ".editPostButton" para abrir o modal em modo de edição
            const editButtons = document.querySelectorAll(".editPostButton"); // Ajuste o seletor conforme seu HTML
            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    modal.setAttribute("data-action", "edit");
                    // Aqui você pode carregar os dados do post existente, se necessário
                    // Exemplo: preencher modalTitle e modalContent com os dados do post
                });
            });

        });

document.addEventListener("DOMContentLoaded", function () {
    // Seleciona os elementos do formulário original e do modal
    const titleInput = document.getElementById("title");
    const contentTextarea = document.getElementById("content");
    const modalTitleInput = document.getElementById("modalTitle");
    const modalContentTextarea = document.getElementById("modalContent");

    // Atualizar campos do modal quando abrir
    document.querySelector(".openModalPreview").addEventListener("click", function () {
        modalTitleInput.value = titleInput.value;
        modalContentTextarea.value = contentTextarea.value;
    });

    // Atualizar os campos do formulário original quando modificar no modal
    modalTitleInput.addEventListener("input", function () {
        titleInput.value = modalTitleInput.value;
    });

    modalContentTextarea.addEventListener("input", function () {
        contentTextarea.value = modalContentTextarea.value;
    });
});

// --- Novo código para o botão "Publicar" ---
document.getElementById("uploadBtn").addEventListener("click", function () {
    const modalTitle = document.getElementById("modalTitle").value;
    const modalContent = document.getElementById("modalContent").value;
    const modal = document.getElementById("modalPreviewImagem");
    const action = modal.getAttribute("data-action");

    let form, url;
    if (action === "edit") {
        form = document.getElementById("editForm");
        url = form.action; // Ex.: /noticias/68
    } else if (action === "create") {
        form = document.getElementById("roleForm");
        url = `{{ route('post.store') }}`; // Ex.: /noticias/store
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Ação não definida!',
        });
        return;
    }

    const titleInput = form.querySelector("#title");
    const contentInput = form.querySelector("#content");
    titleInput.value = modalTitle;
    contentInput.value = modalContent;

    const formData = new FormData(form);
    if (fileInput.files.length > 0) {
        formData.set('arquivo_imagem', fileInput.files[0]);
    }

    const method = action === "edit" ? "POST" : "POST";
    if (action === "edit") {
        formData.append('_method', 'PUT'); // Para edição no Laravel
    }

    $.ajax({
        type: method,
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        success: function (response) {
            if (response.success) {
                $("#modalPreviewImagem").modal("hide");
                if (action === "edit") {
                    const postImageElement = document.querySelector(`.postOnly [data-id="${response.post.id}"]`)
                        .closest('.postOnly').querySelector('.size_img_post img');
                    if (response.post.arquivo_imagem) {
                        postImageElement.src = '/' + response.post.arquivo_imagem;
                    }
                    // Pop-up de sucesso para edição
                    Swal.fire({
                    timer: 2000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    title: 'A sua publicação foi editada.',
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos'
                    },
                    willClose: () => {
                        window.location.reload();
                    }
                });
                } else {
                    // Pop-up de sucesso para criação
                    
                    Swal.fire({
                        timer: 4000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    title: 'A sua publicação foi criada.',
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos'
                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Limpar os campos do roleForm após criar o post
                            form.querySelector("#title").value = "";
                            form.querySelector("#content").value = "";
                            form.querySelector("#arquivo_imagem").value = "";
                            window.location.reload(); // Ou adicione o novo post dinamicamente
                        }
                    });
                    window.location.reload(); // Ou adicione o novo post dinamicamente
                }
            } else {
                alert('Erro: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro na requisição:", xhr.responseText);
            alert('Ocorreu um erro. Por favor, tente novamente.');
        }
    });
});

// document.getElementById("fileInput").addEventListener("change", function (event) {
//     document.getElementById("arquivo_imagem").files = event.target.files;
// });



$(document).ready(function() {
    $('.closeModalPreview').on('click', function(e) {


        Swal.fire({
                    title: 'Descartar',
                    text: "Tem certeza que queres descartar as tuas edições?",
                    showCancelButton: true,
                    confirmButtonColor: '#fff',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    customClass: {
                    confirmButtonColor: 'deleteButton_alert',
                    cancelButtonColor: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                    },	
                }).then((result) => {
            if (result.isConfirmed) {
                $('#modalPreviewImagem').modal('hide'); // Substitua pelo ID do seu modal
                $('#createPostModal').modal('hide'); // Substitua pelo ID do seu modal
                $('#modalEdit').modal('hide');
            }
        });
    });
});

//UPLOAD SCRIPT
let maxWidth = 0;
let allFiles = [];
let removedPdfs = []; // Novo array para PDFs removidos no #modalEdit
// Elementos do #modalEdit
const fileContainerEdit = document.getElementById("fileContainerEdit");
const btnContainerPostEdit = document.querySelector("#modalEdit .btnContainerPost");
const outroContainerEdit = document.querySelector("#modalEdit .outroContainer");

const fileContainer = document.getElementById("fileContainer");
const btnContainerPost = document.querySelector(".btnContainerPost");
const outroContainer = document.querySelector(".outroContainer");

// Função para atualizar a largura de todos os arquivos com base no maior nome
function updateMaxWidth() {
    const allFilesElements = document.querySelectorAll(".file-item");
    let maxWidth = 0; // Resetar para recalcular
    allFilesElements.forEach(fileItem => {
        const tempSpan = document.createElement("span");
        tempSpan.style.visibility = "hidden";
        tempSpan.style.whiteSpace = "nowrap";
        tempSpan.textContent = fileItem.querySelector(".font-semibold").textContent;
        document.body.appendChild(tempSpan);
        const fileWidth = tempSpan.offsetWidth + 80; // Adiciona o padding adicional
        document.body.removeChild(tempSpan);
        if (fileWidth > maxWidth) maxWidth = fileWidth;
    });
    allFilesElements.forEach(el => el.style.width = maxWidth + "px"); // Aplica a largura máxima a todos

     // Para os elementos do feed (container_pdf_file)
     const allFeedPdfElements = document.querySelectorAll(".container_pdf_file a");
    let maxFeedWidth = 0;
    
    const allPostElements = document.querySelectorAll(".post-item");

allPostElements.forEach(post => {
    let maxWidth = 0;
    const pdfElements = post.querySelectorAll(".pdf-item");

    pdfElements.forEach(pdf => {
        const tempSpan = document.createElement("span");
        tempSpan.style.visibility = "hidden";
        tempSpan.style.whiteSpace = "nowrap";
        tempSpan.textContent = pdf.querySelector(".pdf-title").textContent;
        document.body.appendChild(tempSpan);
        const pdfWidth = tempSpan.offsetWidth + 80;
        document.body.removeChild(tempSpan);

        if (pdfWidth > maxWidth) maxWidth = pdfWidth;
    });

    pdfElements.forEach(pdf => pdf.style.width = maxWidth + "px");
});
}

// Chamar a função quando a página carregar completamente
document.addEventListener('DOMContentLoaded', function() {
    updateMaxWidth();
});

const mainContainer = document.querySelector(".mainContainerPDF");
const mainContainerPDFEdit = document.querySelector(".mainContainerPDFEdit");
let isDown = false;
let startX;
let scrollLeft;

mainContainer.addEventListener("mousedown", (e) => {
    isDown = true;
    mainContainer.classList.add("active"); // Opcional: pode usar para mudar o estilo
    startX = e.pageX - mainContainer.offsetLeft;
    scrollLeft = mainContainer.scrollLeft;
});

mainContainer.addEventListener("mouseleave", () => {
    isDown = false;
    mainContainer.classList.remove("active");
});

mainContainer.addEventListener("mouseup", () => {
    isDown = false;
    mainContainer.classList.remove("active");
});

mainContainer.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - mainContainer.offsetLeft;
    const walk = (x - startX) * 2; // Ajusta a velocidade do scroll
    mainContainer.scrollLeft = scrollLeft - walk;
});

fileContainer.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX - fileContainer.offsetLeft;
    scrollLeft = fileContainer.scrollLeft;
    fileContainer.classList.add("active");

    // Impede a seleção de texto ao arrastar
    document.body.style.userSelect = "none";
});

fileContainer.addEventListener("mouseleave", () => {
    isDown = false;
    fileContainer.classList.remove("active");
    document.body.style.userSelect = ""; // Restaura a seleção de texto
});

fileContainer.addEventListener("mouseup", () => {
    isDown = false;
    fileContainer.classList.remove("active");
    document.body.style.userSelect = ""; // Restaura a seleção de texto
});

fileContainer.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault(); // Previne ações padrão do navegador

    const x = e.pageX - fileContainer.offsetLeft;
    const walk = (x - startX) * 2; // Ajuste a velocidade se necessário
    fileContainer.scrollLeft = scrollLeft - walk;
});

// Scroll para fileContainerEdit (novo)
if (fileContainerEdit) {
    mainContainerPDFEdit.addEventListener("mousedown", (e) => {
        isDown = true;
        mainContainerPDFEdit.classList.add("active"); // Opcional: pode usar para mudar o estilo
    startX = e.pageX - mainContainerPDFEdit.offsetLeft;
    scrollLeft = mainContainerPDFEdit.scrollLeft;
    });

    mainContainerPDFEdit.addEventListener("mouseleave", () => {
        isDown = false;
        mainContainerPDFEdit.classList.remove("active");
    });

    mainContainerPDFEdit.addEventListener("mouseup", () => {
        isDown = false;
        mainContainerPDFEdit.classList.remove("active");
    });

    mainContainerPDFEdit.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - mainContainerPDFEdit.offsetLeft;
        const walk = (x - startX) * 2; // Ajusta a velocidade do scroll
        mainContainerPDFEdit.scrollLeft = scrollLeft - walk;
    });

    fileContainerEdit.addEventListener("mousedown", (e) => {
        isDown = true;
        startX = e.pageX - fileContainerEdit.offsetLeft;
        scrollLeft = fileContainerEdit.scrollLeft;
        fileContainerEdit.classList.add("active");

        // Impede a seleção de texto ao arrastar
        document.body.style.userSelect = "none";
    });

    fileContainerEdit.addEventListener("mouseleave", () => {
        isDown = false;
        fileContainerEdit.classList.remove("active");
        document.body.style.userSelect = ""; // Restaura a seleção de texto
    });

    fileContainerEdit.addEventListener("mouseup", () => {
        isDown = false;
        fileContainerEdit.classList.remove("active");
        document.body.style.userSelect = ""; // Restaura a seleção de texto
    });

    fileContainerEdit.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault(); // Previne ações padrão do navegador

        const x = e.pageX - fileContainerEdit.offsetLeft;
        const walk = (x - startX) * 2; // Ajuste a velocidade se necessário
        fileContainerEdit.scrollLeft = scrollLeft - walk;
    });
}

document.getElementById("pdfInput").addEventListener("change", function (event) {
    handleFileUpload(event);
});
 const btnMore = document.createElement("div");
function handleFileUpload(event, container = fileContainer, outro = outroContainer, btnContainer = btnContainerPost) {
    const files = event.target.files;
    if (files.length === 0) return;
    // Adiciona os novos arquivos ao array allFiles
    allFiles = [...allFiles, ...Array.from(files)];
   // Itera sobre os arquivos selecionados e os adiciona ao layout
   Array.from(files).forEach(file => {
        // Criação do item de arquivo
        const fileItem = document.createElement("div");
        const existingBtnMore = container.querySelector(".btnMore");
        if (existingBtnMore) existingBtnMore.remove();
   
    fileItem.className = "file-item";
    btnMore.className = "btnMore";
    fileItem.innerHTML = `
        <div class="flex items-center space-x-3 w-full">
            <span>
                <svg width="26" height="34" viewBox="0 0 26 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25.2905 7.43398L24.8518 6.99531L19.1081 1.2516L18.6695 0.812931C18.4709 0.614362 18.1955 0.5 17.9139 0.5H1.40136C0.726569 0.5 0 1.02117 0 2.16479V22.6897V32.0986V32.3621C0 32.8383 0.479069 33.3026 1.04576 33.4488C1.07421 33.4562 1.10152 33.467 1.1311 33.4727C1.21986 33.4903 1.31033 33.5 1.40136 33.5H24.2021C24.2931 33.5 24.3836 33.4903 24.4723 33.4727C24.5019 33.467 24.5292 33.4562 24.5577 33.4488C25.1244 33.3026 25.6035 32.8383 25.6035 32.3621V32.0986V22.6897V8.453C25.6035 8.0166 25.5511 7.69457 25.2905 7.43398ZM23.5751 7.32759H18.7759V2.52836L23.5751 7.32759ZM1.40136 32.3621C1.36097 32.3621 1.32455 32.3473 1.28871 32.3342C1.19995 32.2921 1.13793 32.2033 1.13793 32.0986V23.8276H24.4655V32.0986C24.4655 32.2033 24.4035 32.2915 24.3147 32.3342C24.2789 32.3473 24.2425 32.3621 24.2021 32.3621H1.40136ZM1.13793 22.6897V2.16479C1.13793 2.04133 1.15671 1.63793 1.40136 1.63793H17.6709C17.6522 1.70962 17.6379 1.78359 17.6379 1.8604V8.46552H24.2431C24.3199 8.46552 24.3933 8.45129 24.465 8.43252C24.465 8.44105 24.4655 8.44447 24.4655 8.453V22.6897H1.13793Z" fill="#555555"/>
                    <path d="M8.84291 25.9578C8.65345 25.8025 8.43951 25.6853 8.20112 25.6079C7.96272 25.53 7.72148 25.4913 7.47796 25.4913H5.8291V31.2242H6.76277V29.1548H7.4552C7.75562 29.1548 8.031 29.111 8.27964 29.0228C8.52827 28.9347 8.74107 28.81 8.91745 28.6496C9.09382 28.4892 9.23095 28.2906 9.32995 28.0545C9.42838 27.8183 9.47788 27.5555 9.47788 27.2647C9.47788 26.9899 9.41927 26.7424 9.30264 26.5217C9.186 26.3009 9.03238 26.1137 8.84291 25.9578ZM8.48901 27.8519C8.43155 28.0101 8.35701 28.133 8.2637 28.2212C8.17039 28.3094 8.06798 28.3731 7.95646 28.4118C7.84495 28.4505 7.73172 28.4704 7.61793 28.4704H6.7622V26.1991H7.46203C7.70043 26.1991 7.89217 26.2366 8.03783 26.3117C8.18291 26.3868 8.29557 26.4801 8.37636 26.5917C8.45658 26.7032 8.5095 26.8198 8.53567 26.9416C8.56127 27.0633 8.57436 27.1709 8.57436 27.2642C8.57436 27.498 8.54591 27.6937 8.48901 27.8519Z" fill="#555555"/>
                    <path d="M14.4825 26.3311C14.2413 26.0773 13.938 25.873 13.5722 25.7206C13.2063 25.5681 12.7825 25.4913 12.3005 25.4913H10.5737V31.2242H12.7438C12.816 31.2242 12.9275 31.2151 13.0783 31.1969C13.2285 31.1787 13.3947 31.1377 13.5762 31.0723C13.7577 31.0074 13.9454 30.9101 14.14 30.7804C14.3346 30.6507 14.5093 30.4731 14.6652 30.2473C14.8211 30.0214 14.9491 29.7414 15.0504 29.4069C15.1516 29.0723 15.2023 28.6689 15.2023 28.1973C15.2023 27.8548 15.1425 27.5213 15.0236 27.1976C14.9036 26.8744 14.7238 26.5854 14.4825 26.3311ZM13.802 29.9326C13.5221 30.3372 13.0658 30.5391 12.4331 30.5391H11.5074V26.1985H12.0519C12.498 26.1985 12.861 26.2571 13.1409 26.3737C13.4208 26.4904 13.6427 26.6434 13.806 26.8329C13.9693 27.0224 14.0791 27.2334 14.1366 27.4667C14.1935 27.7 14.2219 27.9361 14.2219 28.1745C14.2219 28.942 14.082 29.5287 13.802 29.9326Z" fill="#555555"/>
                    <path d="M16.1656 29.7873H17.0922V27.283H19.4317V26.6646H17.0922V24.9145H19.6667V24.2281H16.1656V29.7873Z" fill="#555555"/>
                    <path d="M17.7378 12.6625C17.2272 12.6625 16.6006 12.7287 15.8722 12.86C14.8556 11.7886 13.7945 10.2239 13.0456 8.68791C13.7883 5.58225 13.4167 5.14253 13.2528 4.93508C13.0783 4.71439 12.8322 4.35632 12.5522 4.35632C12.435 4.35632 12.115 4.40929 11.9878 4.45122C11.6678 4.55715 11.4956 4.80212 11.3578 5.12156C10.965 6.03356 11.5039 7.58832 12.0583 8.78667C11.5845 10.6587 10.7895 12.8992 9.9539 14.7177C7.84834 15.6755 6.73001 16.6162 6.6289 17.5138C6.59223 17.8405 6.67001 18.3199 7.24834 18.7508C7.40667 18.8683 7.59223 18.9307 7.78556 18.9307C8.27167 18.9307 8.76279 18.561 9.33112 17.7682C9.74556 17.19 10.1906 16.4016 10.655 15.4228C12.1428 14.7767 13.9833 14.193 15.5595 13.8658C16.4372 14.7028 17.2233 15.1265 17.8989 15.1265C18.3967 15.1265 18.8233 14.8992 19.1322 14.4694C19.4539 14.022 19.5272 13.6214 19.3489 13.2777C19.135 12.8645 18.6078 12.6625 17.7378 12.6625ZM7.79779 17.9994C7.53779 17.8013 7.55279 17.6678 7.55834 17.6176C7.59279 17.3108 8.07667 16.7663 9.2639 16.1036C8.3639 17.7544 7.88056 17.9734 7.79779 17.9994ZM12.3533 5.35274C12.3772 5.34501 12.9339 5.96019 12.4067 7.12708C11.6145 6.32212 12.2989 5.37094 12.3533 5.35274ZM11.205 14.1947C11.7689 12.86 12.2933 11.3864 12.6906 10.0214C13.3145 11.1348 14.0639 12.2151 14.8139 13.0802C13.6283 13.3566 12.3661 13.7467 11.205 14.1947ZM18.3722 13.9304C18.2011 14.1682 17.83 14.1737 17.7 14.1737C17.4039 14.1737 17.2933 13.9988 16.8406 13.6529C17.2139 13.6054 17.5661 13.5933 17.8467 13.5933C18.3406 13.5933 18.4311 13.6656 18.4995 13.702C18.4872 13.7411 18.455 13.8151 18.3722 13.9304Z" fill="#555555"/>
                </svg>
            </span>
            <div class="flex-1">
                <p class="font-semibold truncate">${file.name}</p>
                <p class="textAbrirContainerPDF">Toque para abrir o ficheiro</p>
            </div>
            
        </div>
        <button onclick="removeFile(this, '${file.name.replace(/'/g, "\\'")}', '${container.id}')">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6035 6.41L18.1935 5L12.6035 10.59L7.01352 5L5.60352 6.41L11.1935 12L5.60352 17.59L7.01352 19L12.6035 13.41L18.1935 19L19.6035 17.59L14.0135 12L19.6035 6.41Z" fill="#555555"/>
                </svg>
            </button>
        
    `;
    btnMore.innerHTML = `
        <span id="addFileBtn${container.id === 'fileContainer' ? '' : 'Edit'}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="#555555"/>
            </svg>
        </span>
    `;
    container.appendChild(fileItem);
});
    container.appendChild(btnMore);
    updateMaxWidth(container);// Atualiza a largura de todos os itens
    checkFileContainer(container, outro, btnContainer); // U
}

function removeFile(button, fileName, containerId) {
    console.log("Removendo arquivo:", fileName);
    allFiles = allFiles.filter(file => file.name !== fileName);
    console.log("allFiles após filtro:", allFiles);

    if (containerId === "fileContainerEdit") {
        removedPdfs.push(fileName); // Rastreia PDFs removidos no #modalEdit
        console.log('PDF removido:', fileName);
        console.log('removedPdfs atual:', removedPdfs);
    }
    const fileItem = button.parentElement; // O pai do botão é o file-item
    fileItem.remove();
    const container = document.getElementById(containerId);
    const outro = containerId === "fileContainer" ? outroContainer : outroContainerEdit;
    const btnContainer = containerId === "fileContainer" ? btnContainerPost : btnContainerPostEdit;
    checkFileContainer(container, outro, btnContainer);
    updateMaxWidth(container);
}

// Função para verificar se há arquivos e exibir/ocultar a div
function checkFileContainer(container, outro, btnContainer) {
    // Filtra os filhos do fileContainer, ignorando btnMore
    let validChildren = [...container.children].filter(child => !child.classList.contains("btnMore"));

    if (validChildren.length > 0) {
        outro.style.display = "block";
        btnContainer.style.display = "none";
    } else {
        outro.style.display = "none";
        btnContainer.style.display = "flex";
    }
}

// Adicionar evento para #pdfInputEdit
document.getElementById("pdfInputEdit").addEventListener("change", function (event) {
    handleFileUpload(event, fileContainerEdit, outroContainerEdit, btnContainerPostEdit);
});


// Adicionar evento para "Adicionar Mais" no #modalEdit
document.addEventListener("click", function (e) {
    const addFileBtnEdit = e.target.closest("#addFileBtnEdit");
    if (addFileBtnEdit) {
        document.getElementById("pdfInputEdit").click();
    }
});

document.addEventListener("click", function (e) {
    const addFileBtn = e.target.closest("#addFileBtn"); // Verifica se o clique foi no botão
    if (addFileBtn) {
        const testee = document.getElementById("pdfInput");
        if (testee) {
            testee.click(); // Simula o clique no input de arquivo
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const createPostModal = document.getElementById("createPostModal");
    const roleForm = document.getElementById("roleForm");
    const titleInput = roleForm.querySelector(".titleClear");
    const contentTextarea = roleForm.querySelector(".contentClear");

    // Limpar os campos quando o modal for fechado
    createPostModal.addEventListener("hidden.bs.modal", function () {
        titleInput.value = "";
        contentTextarea.value = "";
        // Opcional: Limpar o input de arquivo, se desejar
        roleForm.querySelector("#arquivo_imagem").value = "";
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Interceptar envio do roleForm
    const roleForm = document.getElementById("roleForm");
    roleForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(roleForm);
        const input = document.getElementById("pdfInput");
        // Limpa os arquivos existentes no FormData para evitar duplicatas
        formData.delete("arquivo_pdf[]");
        allFiles.forEach(file => {
            formData.append("arquivo_pdf[]", file);
        });
        $.ajax({
            type: "POST",
            url: roleForm.action,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            success: function (response) {
                if (response.success) {
                    $("#createPostModal").modal("hide");
                    Swal.fire({
                    timer: 2000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    title: 'A sua publicação foi criada.',
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos'
                    },
                    willClose: () => {
                        window.location.reload();
                    }
                })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.message || 'Algo deu errado!',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro na requisição:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro. Por favor, tente novamente.',
                });
            }
        });
    });
});


function deleteData(postId) {
    Swal.fire({
       title: 'Eliminar',
        text: "Tem a certeza que queres eliminar esta publicação?",
        showCancelButton: true,
        confirmButtonColor: '#fff',
        cancelButtonColor: '#fff',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        customClass: {
        confirmButtonColor: 'deleteButton_alert',
        cancelButtonColor: 'cancelButton_alert',
        title: 'title_delete_alert',
         popup: 'popup_delete_alert',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + postId).submit();
        }
    });
}
console.log('Views count inicial na lista:', $('.post-views-count').text());
function openPostPreview(title, content, imageSrc, userName, userAvatar, datasPosts, postId, cargo, authUserId, postUserId) {
    // Atualiza os campos do modal de visualização
    document.getElementById('postTitle').textContent = title;
    document.getElementById('postContent').textContent = content;
    document.getElementById('postUserName').textContent = userName;
    document.querySelector('.postUserAvatar').src = userAvatar;
    document.querySelector('.postImage').src = imageSrc;
    document.getElementById('postsDates').textContent = datasPosts;
    document.getElementById('cargoUser').textContent = cargo;
    
    // Configura o formulário de comentários
    const commentForm = document.getElementById('modalCommentForm');
    commentForm.action = `/comments/${postId}`;

    const modalFooter = document.querySelector('#modalViewPost .items-footer');
    modalFooter.setAttribute('data-postid', postId);

    // Busca o número atual de visualizações
    fetch(`/post/${postId}/views-count`)
            .then(response => response.json())
            .then(data => {
                const viewsCount = data.views_count;
                $(`#modalViewPost .items-footer .views-count`).text(viewsCount);
                $(`.items-footerLista[data-postid="${postId}"] .post-views-count`).text(viewsCount);
            })
            .catch(error => console.error('Erro ao buscar contagem de visualizações:', error));

    // Busca o número atual de visualizações sem registrar uma nova visualização
    fetch(`/post/${postId}/views-count`) // Nova rota para obter apenas a contagem
        .then(response => response.json())
        .then(data => {
            const viewsCount = data.views_count;
            $(`#modalViewPost .items-footer .views-count`).text(viewsCount);
            // Opcional: Sincroniza com a lista, mas não é necessário se a lista já estiver atualizada
            $(`.items-footerLista[data-postid="${postId}"] .post-views-count`).text(viewsCount);
        })
        .catch(error => console.error('Erro ao buscar contagem de visualizações:', error));

   // Sincroniza o estado do botão de like no modal com o estado atual na lista
    const listIcon = $(`.items-footerLista[data-postid="${postId}"] .like-icon`); // Alterado para .items-footerLista
    const modalIcon = $(`.items-footer[data-postid="${postId}"] .like-icon`);
    const listCount = $(`.items-footerLista[data-postid="${postId}"] .like-count`).text();
    const isLiked = listIcon.hasClass('liked');
    const iconSrc = isLiked ? 'logo/img/icon/ThumbsUp_pressed.svg' : 'logo/img/icon/icon_thumbs.svg';

    modalIcon.attr('src', iconSrc)[isLiked ? 'addClass' : 'removeClass']('liked');
    $(`.items-footer[data-postid="${postId}"] .like-count`).text(listCount);

    // Carrega os comentários existentes
    fetch(`/comments/${postId}`)
        .then(response => response.json())
        .then(data => {
            const commentsList = document.getElementById('modalCommentsList');
            commentsList.innerHTML = '';
            
            data.forEach(comment => {
                const commentElement = document.createElement('div');
                commentElement.className = 'comment-item';
                commentElement.innerHTML = `
                    <div class="comment-header">
                       <img src="{{ url('public/avatar_users/' . $comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="comment-avatar">
                       
                        <div class="comment-info-container">
                            <div class="comment-info">
                                <div class="comment-info-header">
                                    <span class="comment-author">${comment.user.name}</span>
                                    <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="1.79962" cy="2.20752" r="1.5" fill="#D9D9D9"/>
                                    </svg>
                                    <span class="comment-date">${new Date(comment.created_at).toLocaleDateString()}</span>
                                </div>
                              ${(comment.user_id == authUserId || postUserId == authUserId) ? `
                                <div class="containerOpt">
                                    <button class="btnOpt" data-toggle="modal" data-target="#modalOpt-${comment.id}">
                                        <img src="logo/img/icon/frame26.svg" alt="">
                                    </button>
                                    <div class="modal fade modalOpt" id="modalOpt-${comment.id}"  aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body modal-bodyOpt">
                                                    <div class="containerBtnOpt containerBtnOptViewPost">
                                                        
                                                       ${(comment.user_id == authUserId) ? `
                                                        <button class="btnOpt btnOptViewPost edit-comment-btn" data-comment-id="${comment.id}" data-comment-body="${comment.body}" style="margin: 0 !important; padding: 0 !important;">
                                                            Editar
                                                        </button>
                                                        ` : ''}
                                                        <button class="btnOpt btnOptViewPost" onclick="deleteComment(${comment.id})" style="margin: 0 !important; padding: 0 !important;">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                            
                            </div>
                            <span class="comment-user-cargo">{{ $comment->user->cargo->titulo }}</span>
                        </div>
                        
                    </div>
                    <div class="comment-body">
                        ${comment.body}
                        <div class="comment_content_footer">
                            <span>Gosto</span>
                            <span>Responder</span>
                        </div>
                    </div>
                `;
                commentsList.appendChild(commentElement);
                // Inicializa o modal dinamicamente após adicioná-lo ao DOM
                if (comment.user_id == {{ auth()->id() }}) {
                    $(`#modalOpt-${comment.id}`).modal({ show: false }); // Inicializa o modal
                }
            });
            // Atualiza a quantidade de comentários
           // Atualiza a contagem de comentários no modal
           const commentCountElement = document.querySelector('#modalViewPost .items-footer .comment-count');
            if (commentCountElement) {
                commentCountElement.textContent = data.length;
            } else {
                console.error('Elemento .comment-count não encontrado no modal!');
            }

            // Opcional: Atualiza a contagem na lista também, se necessário
            const listCommentCount = document.querySelector(`.items-footerLista[data-postid="${postId}"] .comment-count`);
            if (listCommentCount) {
                listCommentCount.textContent = data.length;
            }
        })
        .catch(error => console.error('Erro ao carregar comentários:', error));
        // Configuração do hover no modal
        const modalViewContainer = document.querySelector(`#modalViewPost .items-footer .view-container`);
        const modalTooltip = modalViewContainer.querySelector('.views-tooltip');
        let modalLoaded = false;

        modalViewContainer.addEventListener('mouseenter', function() {
            if (!modalLoaded) {
                fetch(`/post/${postId}/viewers`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Visualizadores no modal:', data.viewers);
                        if (data.success && data.viewers.length > 0) {
                            const ul = document.createElement('ul');
                            data.viewers.forEach(viewer => {
                                const li = document.createElement('li');
                                li.textContent = viewer;
                                ul.appendChild(li);
                            });
                            modalTooltip.innerHTML = '';
                            modalTooltip.appendChild(ul);
                            console.log('Tooltip do modal preenchida');
                        } else {
                            modalTooltip.textContent = 'Nenhum visualizador';
                            console.log('Tooltip do modal: Nenhum visualizador');
                        }
                        modalLoaded = true;
                    })
                    .catch(error => {
                        console.error('Erro ao buscar visualizadores no modal:', error);
                        modalTooltip.textContent = 'Erro ao carregar';
                    });
            }
        });
    
    // Abre o modal
    $('#modalViewPost').modal('show');
}

function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
}

// Função para excluir comentário via AJAX
window.deleteComment = function (commentId) {
        Swal.fire({
            title: 'Eliminar',
                    text: "Tem certeza que queres eliminar o comentário?",
                    showCancelButton: true,
                    confirmButtonColor: '#fff',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    customClass: {
                    confirmButtonColor: 'deleteButton_alert',
                    cancelButtonColor: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                    },	
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/comment/' + commentId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#comment-' + commentId).remove();
                            window.location.reload();
                        } else {
                            Swal.fire('Erro', response.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Erro', 'Ocorreu um erro ao excluir o comentário.', 'error');
                    }
                });
            }
        });
    };

    $(document).ready(function () {
    let originalAction = '';
    let originalPlaceholder = '';

    // Função para cancelar a edição
    function cancelEdit() {
        const form = $('.comment-form');
        form.attr('action', originalAction);
        form.find('input[name="comment"]').val('');
        form.find('input[name="comment"]').attr('placeholder', originalPlaceholder);
        form.find('.cancel-edit-btn').remove();
    }

    // Evento de clique no botão de edição de comentário
    $(document).on('click', '.edit-comment-btn', function () {
        const commentId = $(this).data('comment-id');
        const commentBody = $(this).data('comment-body');
        const form = $('.comment-form');
        const input = form.find('input[name="comment"]');

        // Salvar a ação original e o placeholder
        originalAction = form.attr('action');
        originalPlaceholder = input.attr('placeholder');

        // Alterar a ação do formulário para a rota de atualização do comentário
        form.attr('action', `/comment/${commentId}`);
        input.val(commentBody);
        input.attr('placeholder', 'Edite seu comentário...');

        // Adicionar botão de cancelar edição
        if (!form.find('.cancel-edit-btn').length) {
            form.append('<button type="button" class="cancel-edit-btn">Cancelar</button>');
        }
    });

    // Evento de clique no botão de cancelar edição
    $(document).on('click', '.cancel-edit-btn', function () {
        cancelEdit();
    });

    // Evento de envio do formulário de comentário
    $('.comment-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const formData = new FormData(this);

        // Verificar se é uma edição de comentário
        const isEdit = action.includes('/comment/');

        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Atualizar o comentário na página ou adicionar um novo comentário
                    if (isEdit) {
                        const commentItem = $(`#comment-${response.comment.id}`);
                        commentItem.find('.comment-content').text(response.comment.body);
                        cancelEdit();
                    } else {
                        window.location.reload();
                    }
                } else {
                    alert(response.message || 'Erro ao adicionar comentário');
                }
            },
            error: function (xhr) {
                alert('Erro ao adicionar comentário');
            }
        });
    });
});
function likeComment(commentId) {
    fetch(`/comment/${commentId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const likeButton = document.querySelector(`#comment-${commentId} .like-buttonComment`);
            const likeIcon = likeButton.querySelector('.like-iconComment');
            const likeCount = likeButton.querySelector('.like-countComment');
            
            // Atualiza a contagem de likes no frontend
            likeCount.textContent = data.likes_count;
            
            // Verifica se o usuário curtiu ou descurtiu com base em 'liked_by_user'
            if (data.liked_by_user) {
                // Quando o like é dado
                likeIcon.style.display = 'inline';  // Torna o ícone visível
                likeButton.classList.add('likedComment'); // Adiciona a classe para mudar a cor
            } else {
                // Quando o like é removido
                likeIcon.style.display = 'none';   // Torna o ícone invisível
                likeButton.classList.remove('likedComment'); // Remove a classe
            }
        }
    })
    .catch(error => console.error('Erro:', error));
}

function likeReply(replyId) {
    const likeButtonReply = document.querySelector(`#reply-${replyId} .like-buttonCommentReply`);
    const likeIcon = likeButtonReply.querySelector('.like-iconReply');
    const likeCount = likeButtonReply.querySelector('.like-countReply');
    const isLiked = likeButtonReply.classList.contains('likedReply');

    // Feedback imediato
    if (isLiked) {
        likeIcon.style.display = 'none';
        likeButtonReply.classList.remove('likedReply');
        likeCount.textContent = parseInt(likeCount.textContent) - 1;
    } else {
        likeIcon.style.display = 'inline';
        likeButtonReply.classList.add('likedReply');
        likeCount.textContent = parseInt(likeCount.textContent) + 1;
    }

    fetch(`/comment-reply/${replyId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            likeCount.textContent = data.likes_count;
            if (data.liked_by_user) {
                likeIcon.style.display = 'inline';
                likeButtonReply.classList.add('likedReply');
            } else {
                likeIcon.style.display = 'none';
                likeButtonReply.classList.remove('likedReply');
            }
        } else {
            // Reverte em caso de erro
            if (isLiked) {
                likeIcon.style.display = 'inline';
                likeButtonReply.classList.add('likedReply');
            } else {
                likeIcon.style.display = 'none';
                likeButtonReply.classList.remove('likedReply');
            }
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        // Reverte em caso de falha
        if (isLiked) {
            likeIcon.style.display = 'inline';
            likeButtonReply.classList.add('likedReply');
        } else {
            likeIcon.style.display = 'none';
            likeButtonReply.classList.remove('likedReply');
        }
    });
}


function toggleReplyForm(commentId) {
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Manipular envio do formulário de resposta
    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const commentId = this.action.split('/').slice(-2)[0];
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const repliesList = document.querySelector(`#comment-${commentId} .replies-list`);
                    const replyHtml = `
                        <div class="reply-item">
                            <div class="comment-header">
                                <img class="comment-avatar" src="{{ url('public/avatar_users/${data.reply.user.avatar}') }}" alt="">
                                <div class="comment-info-container">
                                    <div class="comment-info">
                                        <div class="comment-info-header">
                                            <span class="comment-author">${data.reply.user.name}</span>
                                            <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="1.79962" cy="2.20752" r="1.5" fill="#D9D9D9"/>
                                            </svg>
                                            <span class="comment-date">${new Date(data.reply.created_at).toLocaleDateString()}</span>
                                        </div>
                                    </div>
                                    <div class="comment-body">${data.reply.body}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    repliesList.insertAdjacentHTML('beforeend', replyHtml);
                    this.reset();
                    document.getElementById(`reply-form-${commentId}`).style.display = 'none';
                    window.location.reload();
                }
            })
            .catch(error => console.error('Erro:', error));
        });
    });
});

function toggleReplies(commentId) {
    const repliesContainer = document.getElementById(`replies-${commentId}`);
    const toggleButton = document.getElementById(`toggle-replies-${commentId}`);
    const commentItem = document.getElementById(`comment-${commentId}`);

    if (repliesContainer.style.display === "none" || repliesContainer.style.display === "") {
        repliesContainer.style.display = "block";
        toggleButton.innerHTML = `<span>Ver menos respostas</span>`;
        // Adiciona a linha vermelha ao comentário principal
        commentItem.classList.add('line-active');
    } else {
        repliesContainer.style.display = "none";
        toggleButton.innerHTML = `<span>Ver mais ${repliesContainer.children.length} resposta(s)</span>`;
        // Remove a linha vermelha do comentário principal
        commentItem.classList.remove('line-active');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.querySelector('.toggle-content-btn');
    const previewContent = document.querySelector('.expandir_post');
    const fullContent = document.querySelector('.content-full');

    toggleBtn.addEventListener('click', function() {
        if (fullContent.style.display === 'none') {
            fullContent.style.display = 'block';
            previewContent.style.display = 'none';
            toggleBtn.textContent = 'Ver menos';
        } else {
            fullContent.style.display = 'none';
            previewContent.style.display = 'block';
            toggleBtn.textContent = 'Ver mais';
        }
    });
});


</script>

    <script src="https://cdnjs.cloudflare.com/ajax/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.min.js"></script>
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

    <script>

        

        document.addEventListener('DOMContentLoaded', function() {
    const posts = document.querySelectorAll('.post-item');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const postId = entry.target.querySelector('.post-views-count').getAttribute('data-postid');
                const timeoutId = setTimeout(() => {
                $.ajax({
                    url: `/post/${postId}/view`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            const viewsCount = response.views_count;
                            $(`.items-footerLista[data-postid="${postId}"] .post-views-count`).text(viewsCount);
                            console.log(`Visualização registrada para post ${postId}: ${viewsCount}`);
                        }
                    },
                    error: function(xhr) {
                        console.error('Erro ao registrar visualização:', xhr.responseText);
                    }
                });
                observer.unobserve(entry.target);
                }, 2000); // Espera de 2 segundos

                entry.target.dataset.timeoutId = timeoutId;
            } else {
                // Cancela o timeout se o post sair da visualização antes dos 2 segundos
                clearTimeout(entry.target.dataset.timeoutId);
            }
        });
    }, {
        threshold: 0.5 // Registra quando 50% do post está visível
    });

    posts.forEach(post => {
        observer.observe(post);
    });

    // Configuração do hover para exibir os nomes dos visualizadores
    const viewContainers = document.querySelectorAll('.view-container');
    viewContainers.forEach(container => {
        const postId = container.querySelector('.post-views-count').getAttribute('data-postid');
        const tooltip = container.querySelector('.views-tooltip');
        let loaded = false;

        container.addEventListener('mouseenter', function() {
            if (!loaded) {
                fetch(`/post/${postId}/viewers`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Visualizadores:', data.viewers);
                        if (data.success && data.viewers.length > 0) {
                            // Cria uma lista HTML com os nomes
                            const ul = document.createElement('ul');
                            data.viewers.forEach(viewer => {
                                const li = document.createElement('li');
                                li.textContent = viewer;
                                ul.appendChild(li);
                            });
                            tooltip.innerHTML = ''; // Limpa o conteúdo anterior
                            tooltip.appendChild(ul);
                            console.log('Tooltip preenchida com lista de visualizadores');
                        } else {
                            tooltip.textContent = 'Nenhum visualizador';
                            console.log('Tooltip preenchida com: Nenhum visualizador');
                        }
                        loaded = true;
                    })
                    .catch(error => {
                        console.error('Erro ao buscar visualizadores:', error);
                        tooltip.textContent = 'Erro ao carregar';
                    });
            }
        });
    });
});
    </script>
@endsection