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
                        <li class="breadcrumb-item active">Questionários</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Questionários</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="main-card m-3 p-4 card card-primary card-outline">
                        <div class="row">
                        @foreach($questionarios as $questionario)
                            {{-- CARDS PARA REALIZAR OS QUESTIONÁRIOS--}}
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2 mb-2">

                                <div class="card card-cascade wider" style="height: 100%;">

                                    <div class="view view-cascade">
                                        <img class="card-img-top z-depth-1 rounded" id="output"
                                             src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}" alt="capa de questionario">
                                            @if(respond_survey($questionario->id))
                                                <a  href="{{route('quest.enquete', ['questionario'=> $questionario->id])}}">
                                                    <div class="mask rgba-white-slight"></div>
                                                </a>
                                            @else
                                                <a>
                                                    <div class="mask rgba-white-slight"></div>
                                                </a>
                                            @endif
                                    </div>

                                    <div class="card-body card-body-cascade">
                                        <div class="text-center">
                                            <h4 class="indigo-text text-black-50 font-weight-bold"><strong>{{Str::limit($questionario->title, 30)}}</strong></h4>
                                            <h6 class="card-text" style="height: 100%;">{{Str::limit($questionario->content, 50)}}</h6>
                                        </div>

                                        <hr/>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2 fixed-bottom" style="position: absolute;">
                                            <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                @if(respond_survey($questionario->id))
                                                    <a type="button" class="btn btn-sm btn-success z-depth-1 rounded" href="{{route('survey.show', ['questionario'=> $questionario->id])}}">
                                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                <i class="fas fa-clipboard-check fa-w-20"></i>
                                                            </span>
                                                        Responder enquete
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-danger z-depth-1 rounded">
                                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-clipboard-check fa-w-20"></i>
                                                        </span>
                                                        Respondida
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection