@extends('master.layout')
@section('title', 'Administrar questionário')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Administrar questionário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content mb-0">
        <div class="row">
            <div class="container-flex purple-gradient" style="padding: 20px 10px; color: #ffffff; border: none;">
                <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        {{-- --}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="view overlay zoom">
                                        <img class="card-img-top z-depth-1 rounded" id="output"
                                             src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}" alt="capa de questionario">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <h5 class="text-white text-center note-fontsize-10 mt-2">
                                        {{$questionario->content}}
                                    </h5>

                                    <div class="flex-row font-small font-weight-light text-center">
                                        <span class="text-small">Postado em {{date('d/m/Y', strtotime($questionario->created_at))}}</span>
                                         -  Total de questões <span style="border-radius: 50%; font-size: 16px;" class="ml-3 badge badge-success">{{$questionario->questions->count()}}</span>
                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- --}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 font-small">
                            <h4 class="text-white font-weight-bold text-center">
                                {{$questionario->title}}
                            </h4>
                            @foreach($questionario->questions as $question)
                                <div class="card m-2 collapsed-card rgba-amber-light">
                                    <div class="card-header rounded">
                                        <p class="card-title text-white font-small text-center"><i class="fas fa-question-circle mr-2"></i>{{$question->question}}</p>

                                        <div class="card-tools close">
                                            <a class="btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="row">
                                            <ul class="list-group">
                                                <li class="list-group indigo-text p-2">
                                                    <div class="row">
                                                        @foreach($question->answers as $answer)
                                                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                                            {{$answer->answer}}
                                                        </div>
                                                        <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                                            {{$answer->responses->count()}}
                                                        </div>
                                                        @if($question->responses->count())
                                                            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                                @if(intval($answer->responses->count() * 100 / $question->responses->count()) == 100)
                                                                    <span class="badge badge-success badge-pill">{{intval($answer->responses->count() * 100 / $question->responses->count())}}%</span>
                                                                @else
                                                                    <span class="badge badge-primary badge-pill">{{intval($answer->responses->count() * 100 / $question->responses->count())}}%</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @endforeach
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="m-3">
                                <h5>Usuários que responderam</h5>
                                <div class="row">
                                    @foreach(survey_names($questionario->id) as $names)
                                        <div class="col-sm-3 col-md-5 col-lg-5 col-xl-5">
                                            <i class="fas fa-user-circle mr-2"></i>{{$names->nome}}
                                        </div>
                                        <div class="col-sm-9 col-md-7 col-lg-7 col-xl-7">
                                            <i class="fas fa-clock mr-2"></i> {{date('d/m/Y', strtotime($names->created_at))}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
