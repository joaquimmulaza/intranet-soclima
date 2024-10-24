@extends('master.layout')
@section('title', 'Home')

@section('content')

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

/* Postagens */



/* Barra Lateral Direita */



.evento button {
    margin-top: 10px;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.evento button:hover {
    background-color: #0056b3;
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
                    <a href="#">Gerir Usuários</a>
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
                    <a href="#">Lista Telefônica</a>
                </li>
            </ul>
        </div>
    

        <!-- Post 1 -->
        <div class="postContainer">
            <div class="mainPostContainer">
                <div class="inputPost">
                    <img src="logo/img/icon/avatar-input.svg" alt="">
                    <input type="text" placeholder="Comunique algo...">
                </div>
            </div>

            <div class="AllpostsContainer">
                <div class="post-header">
                    <div class="postContentHeader">
                        <img src="logo/img/icon/avatar-input.svg" alt="">
                        <h3 style="padding: 0; margin: 0;">Recursos Humanos Soclima</h3>
                        <img src="logo/img/icon/Ellipse3.svg" alt="">
                        <p style="padding: 0; margin: 0;">13.10.2024</p>
                    </div>
                    <div>
                        <img src="logo/img/icon/frame26.svg" alt="">
                    </div>
                </div>
                <div class="post-body">
                    Sem post disponível
                </div>
                <hr style="width: 460px; margin: 0 auto;">
                <div class="post-footer">

                    <div class="items-footer">
                        <span>
                            <img src="logo/img/icon/Thumbs-up.svg" alt="">
                            11 gostos
                        </span>
                        
                        <span>
                            <img src="logo/img/icon/Group2.svg" alt="">
                            Visto por 28 pessoas
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Barra Lateral Direita -->
    <div class="sidebar-right">
        <!-- Eventos Recentes -->
        <h3>Eventos Recentes</h3>
        <div class="eventos-recentes">
            
            <div class="evento">
                <p><strong>33 anos Soclima</strong></p>
                <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                <button>Ver Evento</button>
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
                        <h2 style="margin: 0 !important; padding: 0 !important;">Alberto Figueiredo e mais 3 pessoas</h2>
                        <p style="margin: 0 !important; padding: 0 !important;" >Fazem anos amanhã!</p>
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

    

    


    <script src="{{ asset('frontend/home/script.js') }}"></script>
    <script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>
@endsection