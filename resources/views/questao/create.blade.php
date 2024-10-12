@extends('master.layout')
@section('title', 'Cadastrar questão')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($questionario) ? 'Editar' : 'Criar nova' }} questão</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <section class="content">
        <div class="container-fluid">
            {{--FORMULÁRIO DE UPDATE OU CREATE:: --}}
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form action="{{isset($question) ? route('question.update', ['questionario' => $questionario->id, 'question' => $question->id] ) : route('question.criar', $questionario->id) }}"
                                  id="roleFrom" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($question))
                                    @method('PUT')
                                    <label class="text-black-50 font-weight-bold text-md-left" for="titulo">{{$questionario->title}}</label>
                                @endif


                                <div class="card-body">
                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{ isset($question) ? 'Editar' : 'Criar nova' }} questão</h3>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">

                                            <div class="md-form form-sm">
                                                <input id="question" name="question[question]" aria-describedby="questionHelp" type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror"
                                                       value="{{$question->question ?? old('question.question')}}" autofocus/>
                                                <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Pergunta da questão</label>

                                                @error('question.question')
                                                    <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                    <div>
                                                        <div class="form-group">
                                                            <input name="answers[][answer]" id="answer1" aria-describedby="choiceHelp" type="text" class="form-control" placeholder="Resposta..."
                                                                   value="{{$question['answers'][0]['answer'] ?? old('answer.0.answer')}}"/>
                                                        </div>

                                                        @error('answer.0.answer')
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <div class="form-group">
                                                            <input name="answers[][answer]" id="answer2" aria-describedby="choiceHelp" type="text" class="form-control" placeholder="Resposta..."
                                                                   value="{{$question['answers'][1]['answer'] ?? old('answer.1.answer')}}"/>
                                                        </div>

                                                        @error('answer.1.answer')
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <div class="form-group">
                                                            <input name="answers[][answer]" id="answer3" aria-describedby="choiceHelp" type="text" class="form-control" placeholder="Resposta..."
                                                                   value="{{$question['answers'][2]['answer'] ?? old('answer.2.answer')}}"/>
                                                        </div>

                                                        @error('answer.2.answer')
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <div class="form-group">
                                                            <input name="answers[][answer]" id="answer4" aria-describedby="choiceHelp" type="text" class="form-control" placeholder="Resposta..."
                                                                   value="{{$question['answers'][3]['answer'] ?? old('answer.3.answer')}}"/>
                                                        </div>

                                                        @error('answer.3.answer')
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 m-0">
                                            {{--IMAGEM PREVIEW --}}
                                            <figure id="upload" class="figure file-upload-wrapper">
                                                <img class="figure-img img-fluid z-depth-1 rounded" id="output"
                                                     src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}"
                                                     alt="capa de questionario">
                                            </figure>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success rounded">
                                        @isset($question)
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-edit fa-w-20"></i>
                                            </span>
                                            Atualizar
                                        @else
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="far fa-save fa-w-20"></i>
                                            </span>
                                            Salvar
                                        @endisset
                                    </button>

                                    @isset($question)
                                        <a type="button" class="btn btn-danger rounded" href="{{route('questionario.show', ['questionario'=> $questionario->id])}}">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-eraser fa-w-20"></i>
                                            </span>
                                            Cancelar
                                        </a>
                                    @else
                                        <button type="reset" class="btn btn-danger rounded">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-eraser fa-w-20"></i>
                                            </span>
                                            Limpar
                                        </button>
                                    @endisset
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

