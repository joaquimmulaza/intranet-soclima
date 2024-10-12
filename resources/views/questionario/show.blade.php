@extends('master.layout')
@section('title', 'Questionário')

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
                <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-3 tz-gallery">
                    <div class="row">
                        {{-- --}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="view overlay zoom">
                                <img class="card-img-top figure-img img-fluid rounded" src="/storage/{{$questionario->capa}}" alt="{{$questionario->title}}">
                            </div>
                        </div>

                        {{-- --}}
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row">

                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                    <h1 class="text-white font-weight-bold text-center mt-5">
                                        {{$questionario->title}}
                                    </h1>
                                    <h6 class="text-white font-weight-bold text-center note-fontsize-10">
                                        {{$questionario->content}}
                                    </h6>

                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @can('app.dashboard')
                                        @if($questionario->status == 'Aberto')
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                    <a type="button" class="btn btn-lg btn-primary z-depth-1 rounded"
                                                       href="{{route('question.novo', ['questionario'=> $questionario->id])}}">
                                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                <i class="fas fa-plus-circle fa-w-20"></i>
                                                                Adicionar questões
                                                            </span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if($questionario->questions->count() > 0 && $questionario->status == 'Aberto')
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                    <button type="button" class="btn btn-lg btn-success z-depth-1 rounded"
                                                            onClick="finalizaQuestData({{ $questionario->id }})">
                                                               <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                    <i class="far fa-save fa-w-20"></i>
                                                               </span>
                                                        Finalizar enquete
                                                    </button>
                                                    <form id="quest-form-{{ $questionario->id  }}"
                                                          action="{{route('questionario.finaliza', ['questionario' => $questionario->id])}}" style="display: none;">
                                                        @csrf()
                                                    </form>
                                                </div>
                                            </div>
                                        @elseif($questionario->status != 'Aberto')
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                    <a type="button" class="btn btn-lg btn-success z-depth-1 rounded"
                                                       href="{{route('admin.enquete', ['questionario' => $questionario->id])}}">
                                                           <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                <i class="fas fa-clipboard fa-w-20"></i>
                                                           </span>
                                                        Verificar dados do questionário
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan


                                    @if($questionario->status != 'Aberto')
                                        @if(respond_survey($questionario->id))
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-4">
                                                    <a type="button" class="btn btn-lg btn-primary z-depth-4 rounded" href="{{route('survey.show', ['questionario'=> $questionario->id])}}">
                                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="far fa-clipboard fa-w-20"></i>
                                                        </span>
                                                        Responder pesquisa
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-2">
                                                <div style="display: flex; align-items: center; justify-content: center;" class="mt-5">
                                                    <div class="card indigo text-center z-depth-2">
                                                        <div class="card-body">
                                                            <h3 class="text-uppercase font-weight-bold amber-text mt-2 mb-3"><strong>Respondido</strong><i class="far fa-heart ml-3"></i></h3>
                                                            <p class="white-text mb-0">Obrigado por participar!</p>
                                                        </div>
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

    @can('app.dashboard')
        @if($questionario->status != 'Finalizado')
            <div class="container-flex">
                <div class="card ml-2 mr-2 mt-1 collapsed-card">
                    <div class="card-header rgba-indigo-strong rounded">
                        <h3 class="card-title text-white font-weight-bold text-center">Questões criadas
                            @if($questionario->questions->count() == 0)
                                <span style="border-radius: 50%; font-size: 16px;" class="ml-3 badge badge-info">{{$questionario->questions->count()}}</span>
                            @else
                                <span style="border-radius: 50%; font-size: 16px;" class="ml-3 badge badge-success">{{$questionario->questions->count()}}</span>
                            @endif
                        </h3>

                        <div class="card-tools close">
                            <a class="btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($questionario->questions as $question)
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    {{$question->question}}
                                </div>

                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    @can('app.roles.edit')
                                    <a type="button" class="btn btn-sm btn-success rounded text-white"
                                       href="{{route('question.edit', ['questionario' => $questionario->id, 'question' => $question->id])}}">
                                           <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fas fa-edit fa-w-20"></i>
                                           </span>
                                        Editar
                                    </a>
                                    @endcan

                                    @can('app.roles.destroy')
                                    <button type="button" class="btn btn-sm btn-danger rounded float-right" onClick="questionData({{ $question->id }})">
                                               <span class="btn-icon-wrapper pr-2 opacity-9">
                                                    <i class="fas fa-trash-alt fa-w-20"></i>
                                               </span>
                                        Deletar
                                    </button>
                                    <form id="question-form-{{ $question->id  }}"
                                          action="{{ route('question.delete', ['questionario' => $questionario->id, 'question' => $question->id]) }}"
                                          method="POST" style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
@endsection
