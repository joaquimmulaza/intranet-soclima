@extends('master.layout')
@section('title', 'Exibir cargo')

@section('content')

    <!-- Header breadcrumb -->
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pesquisa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                {{--CARD: QUESTIONARIO --}}
                <div class="card card-cascade wider">

                    <div class="view view-cascade">
                        <img class="card-img-top z-depth-1 rounded" id="output"
                             src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}" alt="capa de questionario">
                        <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>

                    <div class="card-body card-body-cascade">
                        <div class="text-center">
                            <h2 class="indigo-text text-black-50 font-weight-bold"><strong>{{$questionario->title}}</strong></h2>
                            <h3 class="card-text">{{$questionario->content}}</h3>
                        </div>
                        <hr/>
                        <div class="container">
                            <form action="{{route('survey.store', ['questionario'=> $questionario->id])}}" method="post">
                            @csrf
                                @foreach($questionario->questions as $key => $quest)
                                    <h5 class="indigo-text text-black-50 font-weight-bold mt-2"><strong>({{$key + 1}}) -{{$quest->question}}</strong></h5>

                                    @error('responses.'.$key.'.answer_id')
                                    <small class="text-danger">Precisa escolher uma alternativa!</small>
                                    @enderror

                                    {{--CARD: PERGUNTAS--}}
                                    <ul class="list-group">
                                        @foreach($quest->answers as $answer)
                                            <label for="answer{{$answer->id}}">
                                                <li class="list-group-item">
                                                    <input type="radio" required="true" name="responses[{{$key}}][answer_id]" id="answer{{$answer->id}}"
                                                            {{(old('responses.'.$key.'.answer_id') == $answer->id) ? 'checked' : ''}}
                                                           class="mr-1" value="{{$answer->id}}">
                                                    {{$answer->answer}}

                                                    <input type="hidden" name="responses[{{$key}}][question_id]" value="{{$quest->id}}">
                                                </li>
                                            </label>
                                        @endforeach
                                    </ul>
                                @endforeach


                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                    <button type="submit" class="btn btn-lg btn-primary z-depth-4">
                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                            <i class="fas fa-clipboard-check fa-w-20"></i>
                                        </span>
                                        Finalizar pesquisa
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection