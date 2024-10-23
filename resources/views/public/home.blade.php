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




/* Menu Lateral */
.sidebar-left {
    width: 120px;
    text-align: left;
    min-height: 100vh;
}

.sidebar-left ul {
    list-style-type: none;
    display: flex;
    flex-direction: column;
    justify-content: start;
    margin: 0;
    padding: 0;
}

.sidebar-left ul li {
    margin-bottom: 2px;
}

.sidebar-left ul li a {
    text-decoration: none;
    font-size: 16px;
    color: #333;
  
    display: block;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.sidebar-left ul li a:hover {
    background-color: #ddd;
}

/* Conteúdo Principal */
.main-content {
    display: flex;
    width: 1080px;
    border: 1px solid #000;
    margin: 0 auto;
    padding: 20px;
    justify-content: space-between;
}

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


.post-header h3 {
    margin-bottom: 5px;
}

.post-body img {
    width: 100%;
    margin-bottom: 10px;
}

.post-footer {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
}

.post-footer span {
    font-size: 14px;
    color: #666;
}

/* Barra Lateral Direita */
.sidebar-right {
    width: 326px;
    
    background-color: #f9f9f9;
    min-height: 100vh;
}

.sidebar-right .eventos-recentes, .aniversarios, .ferias {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

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
                <li><a href="#">Gerir Usuários</a></li>
                <li><a href="#">Recibos</a></li>
                <li><a href="#">Justificativos</a></li>
                <li><a href="#">Lista Telefônica</a></li>
            </ul>
        </div>
    

        <!-- Post 1 -->
        <div class="postContainer">
            <div class="mainPostContainer">
                <div class="inputPost">
                    <img src="logo/img/icon/avatar-input.svg" alt="">
                    <input type="text" placeholder="Comunique Algo">
                </div>
            </div>
            <div class="post-header">
                <h3>Recursos Humanos Soclima</h3>
                <p>13.10.2024</p>
            </div>
            <div class="post-body">
                <a href="#"><img src="path-to-pdf-icon" alt="PDF Icon"> Comunicação Interna (PDF)</a>
                <p>Bom dia, caros colegas. Espero a atenção de todos!</p>
            </div>
            <div class="post-footer">
                <span>11 gostos</span>
                <span>Visto por 28 pessoas</span>
            </div>
        </div>

        <!-- Barra Lateral Direita -->
    <div class="sidebar-right">
        <!-- Eventos Recentes -->
        <div class="eventos-recentes">
            <h3>Eventos Recentes</h3>
            <div class="evento">
                <p><strong>33 anos Soclima</strong></p>
                <p>30 de Novembro de 2024, 08:00 - 15:00</p>
                <button>Ver Evento</button>
            </div>
        </div>

        <!-- Aniversários -->
        <div class="aniversarios">
            <h3>Aniversários</h3>
            <p>Alberto Figueiredo e mais 3 pessoas fazem anos amanhã!</p>
        </div>

        <!-- Veja quem está de férias -->
        <div class="ferias">
            <h3>Veja quem está de férias</h3>
            <p>Alfredo Mário e mais 6 pessoas estão desfrutando de merecidas férias.</p>
        </div>
    </div>

    </div>

    

    


    <script src="{{ asset('frontend/home/script.js') }}"></script>
    <script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>
@endsection