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
    </style>

    <link href="{{asset('frontend/home/estilo.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('baguettebox/baguetteBox.min.css')}}" type="text/css" rel="stylesheet">

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="container-flex purple-gradient" style="padding: 20px 10px; color: #ffffff; border: none;">
        <div class="row curved">
            {{--POSTAGENS DESTAQUE--}}
            <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-3 tz-gallery">
                <div class="row">
                        {{-- IMAGEM--}}
                        <div class="col col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="mdb-lightbox">
                                <figure>
                                    <a href="/storage/{{$post->capa}}" data-size="{{$post->capa}}" class="lightbox">
                                        <img src="/storage/{{$post->capa}}" alt="{{$post->title}}" class="img-fluid rounded">
                                    </a>
                                </figure>
                            </div>
                        </div>

                        {{-- DESCRITIVOS--}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-8">
                            <div class="row">
                                {{-- TITULO--}}
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <h1 class="mt-1 text-center ">
                                        <a class="mb-3 text-white font-weight-bold" href="{{route('post.show', ['post'=> $post])}}">
                                            {{$post->title}}
                                        </a>
                                    </h1>
                                </div>

                                {{-- PAINEL LIKES/VIEWS--}}
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="flex-row font-weight-normal font-weight-light">
                                        <i class="far fa-heart text-sm-center">
                                            <span class="badge badge-warning">{{likes_post($post->id)}}</span>
                                        </i>
                                        <i class="far fa-eye text-sm-center">
                                            <span class="badge badge-warning">{{ $post->view }}</span>
                                        </i>
                                        <i class="far fa-comments text-sm-center">
                                            <span class="badge badge-warning">{{$post->comments()->count()}}</span>
                                        </i>
                                    </div>
                                </div>

                                {{-- TEXTO NOTICIA--}}
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <p class="dark-grey-text text-wrap text-news">
                                        {{Str::limit($post->subtitle, 160)}}
                                    </p>

                                    {{-- DADOS DO POST--}}
                                    <div style="position:absolute; float: right; color: #ffffff;" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-md-right text-lg-right d-flex flex-row">

                                        <img class="img-circle mr-2" src="{{URL::to('/')}}/public/avatar_users/{{$post->user->avatar}}" width=20" height="20" alt="User Image">
                                        <a class="text-sm-center font-small mr-2">{{$post->user->name}}</a>
                                        <h6>|</h6>
                                        <p class="ml-2 text-sm-center font-small"><i class="far fa-clock mr-1"></i> {{date('d/m/Y', strtotime($post->created_at))}}</p>
                                    </div>

                                    {{-- BOTÃO SAIBA MAIS--}}
                                    <div style="position:relative; float: right;" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-justify d-flex flex-row-reverse fixed-bottom">
                                        <a style="position:relative; float: right; color: #ffffff;"
                                           class="btn btn-lg btn-amber btn-rounded waves-effect z-depth-2"
                                           href="{{route('post.show', ['post'=> $post])}}" role="button">
                                            saiba mais
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>

            {{-- SVG CURVA DIV--}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 204">
                <path fill="#fff" fill-opacity="1" d="M0,64L60,96C120,128,240,192,360,202.7C480,213,600,171,720,149.3C840,128,960,128,1080,128C1200,128,1320,128,1380,128L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <section class="content white">
           <div class="row">
            {{-- POSTAGENS LEFT--}}
            <section class="col-sm-12 col-md-8 col-lg-8 col-xl-8 pl-4 pt-2">

                <h5 class="indigo-text text-black-50 font-weight-bold"><strong>Últimas notícias</strong></h5>

                <div class="row">
                    @foreach($posts as $post)
                        {{-- ULTIMAS POSTAGENS --}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 m-0">
                            {{--POSTEGNS --}}
                            <div class="row mt-4">
                                {{--IMAGEM --}}
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0">
                                    <div class="view overlay z-depth-1">
                                        <img src="/storage/{{$post->capa}}" alt="{{$post->title}}" class="img-fluid rounded size">
                                        <div class="mask rgba-white-slight waves-effect waves-light aling-items-center text-center py-4 px-3">
                                            <h6 class="btn btn-sm rounded cloudy-knoxville-gradient waves-effect waves-light text-indigo font-weight-bolt">
                                                <a class="text-purple font-weight-bold" href="{{route('post.show', ['post'=> $post])}}">
                                                    Saiba mais
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                {{--COLUNA DE DADOS --}}
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0 p-0">
                                    {{-- POSTAGEM DADOS --}}

                                    <p class="mb-1">
                                        <a href="{{route('post.show', ['post'=> $post])}}" class="text-hover font-weight-bold">{{$post->title}}</a>
                                    </p>
                                    <p class="dark-grey-text text-wrap">
                                        {{Str::limit($post->subtitle, 60)}}
                                    </p>

                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                @if($posts->count() == 8)
                    <div class="mt-3 pl-5 pr-5 float-right p-1"><a class="align-middle" href="">Mais notícias <i class="fas fa-angle-double-right" style="font-size: 18px;"></i></a></div>
                @endif
            </section>

            {{--QUESTIONÁRIOS RIGHT--}}
            <section class="col-sm-12 col-md-4 col-lg-4 col-xl-4 pt-2">
                <h5 class="indigo-text text-black-50 font-weight-bold"><strong>Questionários</strong></h5>

                <section class="row features-small mt-5">

                    @foreach($questionarios as $questionario)
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-center">
                                    @if(respond_survey($questionario->id))
                                        <i class="fas fa-clipboard fa-2x mb-1 indigo-text"></i>
                                    @else
                                        <i class="fas fa-clipboard-check fa-2x mb-1 green-text"></i>
                                    @endif
                                </div>
                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <h5 class="feature-title font-bold mb-1">
                                        {{-- ADMIN--}}
                                        @can('app.dashboard')
                                            <a href="{{route('questionario.show', ['questionario'=> $questionario->id])}}">
                                                <strong>{{Str::limit($questionario->title, 30)}}</strong>
                                            </a>
                                        @elsecan('app.users.index')
                                            <a href="{{route('quest.enquete', ['questionario'=> $questionario->id])}}">
                                                <strong>{{$questionario->title}}</strong>
                                            </a>
                                        @endcan
                                    </h5>
                                    <p class="grey-text mt-2">
                                        {{Str::limit($questionario->content, 30)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </section>
                @if($questionarios->count() == 8)
                    <div class="mt-3 pl-5 pr-5 float-right p-1"><a class="align-middle" href="">Mais questionários <i class="fas fa-angle-double-right" style="font-size: 18px;"></i></a></div>
                @endif


            </section>
        </div>
    </section>


    <script src="{{ asset('frontend/home/script.js') }}"></script>
    <script src="{{ asset('baguettebox/baguetteBox.min.js') }}"></script>
@endsection