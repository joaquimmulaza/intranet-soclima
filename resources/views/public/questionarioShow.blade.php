@extends('master.layout')
@section('title', 'Listagem de questionarios')

@section('content')
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Questionário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content white">
        <div class="row">

            {{--POSTAGENS DESTAQUE--}}
            <div class="container-flex purple-gradient" style="padding: 20px 10px; color: #ffffff; border: none;">
                <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12 pb-5">
                    <div class="row">
                        {{-- --}}
                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <div class="view overlay zoom">
                                <img class="card-img-bottom figure-img img-fluid rounded" src="/storage/{{$questionario->capa}}" alt="{{$questionario->title}}">
                            </div>
                        </div>

                        {{-- --}}
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="row">

                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                    <h1 class="text-white font-weight-bold text-center">
                                        {{$questionario->title}}
                                    </h1>
                                    <h6 class="text-white font-weight-bold text-center note-fontsize-10">
                                        {{$questionario->content}}
                                    </h6>
                                    <div class="text-center mt-5">
                                        <h3 class="text-uppercase font-weight-bold pink-text mr-1"><strong>{{$questionario->view}}</strong><i class="far fa-eye ml-3"></i></h3>
                                    </div>
                                    <div class="flex-row font-weight-normal font-weight-light mb-5 text-center">
                                        <span class="text-small ">Postado em {{date('d/m/yy', strtotime($questionario->created_at))}}</span>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @if($questionario->status != 'aberto')
                                        @if(respond_survey($questionario->id))
                                            <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                <a type="button" class="btn btn-lg btn-primary z-depth-4 rounded" href="{{route('survey.show', ['questionario'=> $questionario->id])}}">
                                                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                    <i class="far fa-clipboard fa-w-20"></i>
                                                                </span>
                                                    Responder pesquisa
                                                </a>
                                            </div>
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center;" class="mt-5">
                                                <div class="card indigo text-center z-depth-2 rounded">
                                                    <div class="card-body">
                                                        <h3 class="text-uppercase font-weight-bold amber-text mt-2 mb-3"><strong>Respondido</strong><i class="far fa-heart ml-3"></i></h3>
                                                        <p class="white-text mb-0">Obrigado por participar!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

@endsection

