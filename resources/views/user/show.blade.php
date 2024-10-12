@extends('master.layout')
@section('title', 'Exibir usuário')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Perfil e detalhes do usuário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                  {{-- CARD DE PERFIL --}}
                  <div class="card testimonial-card">
                        <div class="card-up aqua-gradient lighten-1"></div>

                        <div class="avatar mx-auto white">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}"
                                 alt="User profile picture">
                        </div>

                        <div class="card-body">
                                <h3 class="profile-username text-center indigo-text"><strong>{{$user->name}}</strong></h3>

                                <p class="text-muted text-center mb-0">{{$user->cargo->titulo}}</p>
                                <p class="text-muted text-center mb-0">{{$user->email}}</p>
                                <p class="text-muted text-center">{{$user->formacao}}</p>

                                <ul class="list-group list-group-unbordered mb-3 text-justify">
                                    <li class="list-group-item">
                                        <b>Status</b> <a class="float-right">{{$user->state_civil}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Ramal</b> <a class="float-right">{{$user->ramal}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Aniversário em</b>
                                            @if($user->nascimento != null)
                                                <a class="float-right">{{date('d/m', strtotime($user->nascimento))}}</a>
                                             @endif
                                    </li>
                                    <li class="list-group-item">
                                        <b>Idade</b> <a class="float-right">@if($user->nascimento != null){{calc_idade($user->nascimento)}}@endif</a>

                                    </li>
                                </ul>

                                <a type="button" class="btn btn-sm btn-block btn-primary rounded text-white"
                                   href="{{route('user.edit', ['user' => $user->id])}}">
                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                            <i class="fas fa-user-edit fa-w-20" style="font-size: 20px;"></i>
                                       </span>
                                    Editar
                                </a>
                            </div>
                  </div>
                </div>

                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                    <div class="card card-primary card-outline">
                        {{-- CARD MENU MASTER/DETAILS--}}
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#sobre" data-toggle="tab"><i class="fas fa-address-card mr-1" style="font-size: 20px;"></i>Sobre</a></li>
                                @if($user->status == 'ativo')
                                    <li class="nav-item"><a class="nav-link" href="#endereco" data-toggle="tab"><i class="fas fa-map-marked-alt mr-1" style="font-size: 20px;"></i>Endereço</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#questionarios" data-toggle="tab"><i class="fas fa-paste mr-1" style="font-size: 20px;"></i>Questionários</a></li>
                                    @can('app.dashboard')
                                        <li class="nav-item"><a class="nav-link" href="#postagens" data-toggle="tab"><i class="fas fa-newspaper mr-1" style="font-size: 20px;"></i>Postagens</a></li>
                                    @endcan
                                @endif
                            </ul>
                        </div>

                        {{-- CARD DE CONTEÚDOS--}}
                        <div class="card-body">
                            <div class="tab-content">

                                {{-- CARD MINHAS INFORMAÇÕES--}}
                                <div class="active tab-pane" id="sobre">
                                    <div class="row">
                                        <div class="post clearfix col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 mb-2">
                                            <div class="card card-cascade wider" style="height: 100%;">
                                                <h5 class="indigo-text text-black-50 font-weight-bold"><i class="fas fa-user-cog" style="font-size: 35px;color: #0000cc;"></i> Dados pessoais </h5>
                                                <span class="time" style="font-size: 12px;">Perfil de {{$user->role->slug}} <i class="far fa-clock"></i>
                                                    cadastrado em {{date('d/m/Y', strtotime($user->created_at))}} - <span class="badge badge-warning text-indigo" style="font-size: 10px;">
                                                        @if($user->ultimo_acesso != null)
                                                            Último acesso em {{date('d/m/Y', strtotime($user->ultimo_acesso))}}</span></span>
                                                        @else
                                                            sem acesso</span></span>
                                                        @endif
                                                <div class="row mt-2 mb-2">
                                                    <div class="clearfix col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="d-flex m-2 mt-3 ml-3">
                                                            <i class="fas fa-envelope-open-text align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                {{$user->email}}</h6>
                                                        </div>
                                                        <div class="d-flex m-2 ml-3">
                                                            @if($user->nascimento != null)
                                                                <i class="fas fa-calendar-day align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                    Data de nascimento {{date('d/m/Y', strtotime($user->nascimento))}}</h6>
                                                            @else
                                                                <i class="fas fa-calendar-day align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                    Data de nascimento</h6>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex m-2 ml-3">
                                                            @if($user->status == "ativo")
                                                                <i class="fas fa-toggle-on align-middle" style="color: #00e25b; text-shadow: #002b36; font-size: 20px;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                Status {{$user->status}}</h6>
                                                            @else
                                                                <i class="fas fa-toggle-off align-middle" style="color: #e20909; text-shadow: #002b36; font-size: 20px;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                Status {{$user->status}}</h6>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="clearfix col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="d-flex m-2 ml-3">
                                                            <i class="fas fa-user-graduate align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                Formação {{$user->formacao}}</h6>
                                                        </div>
                                                        <div class="d-flex m-2 ml-3">
                                                            <i class="fas fa-male align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                Estado civil {{$user->state_civil}}</h6>
                                                        </div>
                                                        <div class="d-flex m-2 ml-3">
                                                            <i class="fas fa-phone align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">
                                                                Fone {{$user->fone}}</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                <blockquote>
                                                    <small>Minha descrição</small>
                                                    <p>{{$user->descricao}}</p>
                                                </blockquote>

                                                <div class="callout callout-info mt-3 p-3 ml-2">
                                                    <div class="d-flex ml-2">
                                                        <i class="fas fa-user-tie align-middle" style="color: #0000cc; font-size: 18px;"></i>
                                                        <h6 class="indigo-text font-weight-bold align-text-top ml-2" style="font-size: 18px;">
                                                            Cargo de {{$user->cargo->titulo}}
                                                        </h6>
                                                    </div>
                                                    <span class="time ml-4" style="font-size: 14px; font-family: 'Arial', 'Helvetica', sans-serif">
                                                        Responsabilidades - {{$user->cargo->atividades}}</span>

                                                    <div class="d-flex mt-2 ml-2">
                                                        <i class="fas fa-building align-middle" style="color: #0000cc; font-size: 18px;"></i>
                                                        <h6 class="indigo-text font-weight-bold align-text-top ml-2" style="font-size: 18px;">
                                                            Unidade de trabalho {{$user->unidade->titulo}}
                                                        </h6>
                                                    </div>
                                                    <span class="time ml-4" style="font-size: 14px; font-family: 'Arial', 'Helvetica', sans-serif">
                                                        Área {{$user->unidade->descricao}}</span>
                                                </div>

                                                <hr class="mt-3 mb-1"/>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- CARD ENDEREÇO--}}
                                <div class="tab-pane" id="endereco">
                                    <div class="row">
                                         <div class="post clearfix col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 mb-2">
                                             <div class="card card-cascade wider" style="height: 100%;">
                                                @if($user->endereco != null)
                                                     <h5 class="indigo-text text-black-50 font-weight-bold"><i class="fas fa-home icon" style="font-size: 35px;color: #0000cc;"></i> Endereço</h5>
                                                     <p class="description" style="font-size: 11px;">criado em - {{date('d/m/Y : H:m:s', strtotime($user->endereco->created_at))}}</p>
                                                     <div class="d-flex m-2 mt-3 ml-3">
                                                         <i class="fas fa-road align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2"> {{$user->endereco->street}}, {{$user->endereco->number}}</h6>
                                                     </div>
                                                     <div class="d-flex m-2 ml-3">
                                                        <i class="fas fa-city align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">Bairro {{$user->endereco->bairro}}, {{$user->endereco->city}}/{{$user->endereco->state}}</h6>
                                                     </div>
                                                     <div class="d-flex m-2 ml-3">
                                                         <i class="fas fa-map-marker-alt align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2">Cep {{$user->endereco->cep}}</h6>
                                                     </div>
                                                @else
                                                     <h5 class="indigo-text text-black-50 font-weight-bold"><i class="fas fa-home" style="font-size: 35px;color: red;;"></i> Endereço</h5>
                                                     <p class="description" style="font-size: 11px;">criado em ---</p>
                                                     <div class="d-flex">
                                                         <i class="fas fa-road align-middle" style="color: #0000cc;"></i><h6 class="text-black-50 font-weight-bold align-text-top ml-2"> Endereço não registrado...</h6>
                                                     </div>
                                                @endif

                                                <hr class="mt-5 mb-5"/>

                                             </div>
                                         </div>
                                    </div>
                                </div>

                                {{-- CARD QUESTIONARIOS--}}
                                <div class="tab-pane" id="questionarios">
                                    <div class="row">
                                        <div class="post clearfix col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 mb-2">
                                            <h5 class="indigo-text text-black-50 font-weight-bold"><i class="fas fa-book" style="font-size: 35px;color: #0000cc;"></i> Questionários</h5>

                                            <div class="row mt-4">
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="small-box bg-light text-center">
                                                        <div class="inner">
                                                            <span class="info-box-text text-center text-muted">Total de questionários para responder</span>
                                                            <span class="info-box-number text-center text-muted mb-0">{{total_finalizados() - $enquetes->count()}}</span>
                                                        </div>
                                                        @if(total_finalizados() - $enquetes->count() != 0)
                                                            <a href="{{route('quest.do.finaliza')}}" class="small-box-footer bg-gradient-blue"> Ver questionários <i class="fas fa-arrow-circle-right"></i></a>
                                                        @else
                                                            <span class="small-box-footer badge bg-success p-2 mb-1">Parabéns!! Você respondeu todos questionários disponiveis!!</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="small-box bg-light text-center">
                                                        <div class="inner">
                                                            <span class="info-box-text text-center text-muted">Total questionários respondidos</span>
                                                        </div>
                                                        <a class="small-box-footer bg-gradient-blue">{{$enquetes->count()}}<i class="far fa-check-square ml-2"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <div class="card mt-3 card-indigo">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Questionários respondidos</h3>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                <tr>
                                                                    <th>Questionário</th>
                                                                    <th>Data de conclusão</th>
                                                                    <th style="width: 200px;">Questões respondidas</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($enquetes as $enq)
                                                                    <tr>
                                                                        <td>{{$enq->questionaire->title}}</td>
                                                                        <td>
                                                                            {{date('d/m/Y', strtotime($enq->created_at))}}
                                                                        </td>
                                                                        <td class="text-center"><span class="badge bg-success">{{$enq->questionaire->questions->count()}}</span></td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <hr>

                                            <p class="description" style="font-size: 14px;">Questionários criados <span style="font-size: 16px;">({{$questionarios->count()}})</span></p>

                                            <div class="row mb-3">
                                                @can('app.dashboard')
                                                @foreach($questionarios as $questionario)
                                                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 mt-2">
                                                            <img class="card-img-top z-depth-1 rounded" id="output"
                                                                 src="{{URL::to('/')}}/storage/{{isset($questionario) ? $questionario->capa : 'capa_quest/capa_default.jpg'}}"
                                                                 alt="capa de questionario">
                                                        </div>

                                                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                                            <div class="row">
                                                            <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                                                <div class="post clearfix">
                                                                    <div class="user-block">
                                                                        <h6>{{$questionario->title}}</h6>
                                                                        <span class="time" style="font-size: 12px;"><i class="far fa-clock mr-2"></i>cadastrado em {{date('d/m/Y', strtotime($questionario->created_at))}}</span>

                                                                        <div class="flex-row font-weight-normal font-weight-light">
                                                                            <i class="far fa-eye text-sm-center">
                                                                                <span class="badge badge-warning">{{ $questionario->view }}</span>
                                                                            </i>
                                                                            <i class="fas fa-clipboard-check text-sm-center">
                                                                                <span class="badge badge-success">{{ $questionario->respondidas }}</span>
                                                                            </i>
                                                                        </div>
                                                                        <div class="flex-row font-weight-normal font-weight-light">
                                                                            @if($questionario->status == 'Finalizado')
                                                                                <i class="fas fa-toggle-on text-sm-center" style="color: #00e25b; text-shadow: #002b36; font-size: 15px;">
                                                                                    <span class="badge badge-success"> {{ $questionario->status }}</span>
                                                                                </i>
                                                                            @else
                                                                                <i class="fas fa-toggle-off text-sm-center" style="color: red; text-shadow: #002b36; font-size: 15px;">
                                                                                    <span class="badge badge-danger"> {{ $questionario->status }}</span>
                                                                                </i>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 mb-7 post">
                                                                <p>
                                                                    {{Str::limit($questionario->content, 100)}}
                                                                </p>
                                                                @if(!respond_survey($questionario->id))
                                                                    <i class="fas fa-share mr-1"></i></a><a href="{{$questionario->publicPath()}}">{{$questionario->publicPath()}}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        </div>
                                                    @endforeach
                                                @endcan

                                            </div>
                                        </div>
                                    </div>

                                    <hr class="mt-5 mb-5"/>

                                </div>

                                {{-- CARD POSTAGENS--}}
                                <div class="tab-pane" id="postagens">

                                    <div class="row">
                                        <div class="post clearfix col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 mb-2">
                                            <h5 class="indigo-text text-black-50 font-weight-bold"><i class="fas fa-newspaper" style="font-size: 35px;color: #0000cc;"></i> Notícias</h5>
                                            <p class="description" style="font-size: 14px;">Minhas postagens criadas foram <span style="font-size: 16px;">({{$user->posts()->count()}})</span> e foram realizados ({{$user->comments()->count()}}) comentários</p>

                                            <hr>

                                            <div class="row mb-3">
                                                @foreach($user->posts as $post)
                                                    <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mt-2">
                                                        <img class="card-img-top z-depth-1 rounded" id="output"
                                                             src="{{URL::to('/')}}/storage/{{isset($post) ? $post->capa : 'capa_quest/capa_default.jpg'}}"
                                                             alt="capa de questionario">
                                                    </div>

                                                    <div class="col-sm-12 col-md-11 col-lg-11 col-xl-11">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                                                <div class="post clearfix">
                                                                    <div class="user-block">
                                                                        <h6><a class="mb-3 font-weight-bold" href="{{route('post.show', ['post'=> $post])}}">
                                                                                {{$post->title}}
                                                                            </a>
                                                                        </h6>
                                                                        <span class="time" style="font-size: 12px;"><i class="far fa-clock mr-2"></i>cadastrado em {{date('d/m/Y', strtotime($post->created_at))}}</span>

                                                                        <div class="flex-row font-weight-normal font-weight-light">
                                                                            <i class="far fa-eye text-sm-center">
                                                                                <span class="badge badge-warning">{{ $post->view }}</span>
                                                                            </i>
                                                                            <i class="far fa-thumbs-up text-sm-center">
                                                                                <span class="badge badge-success">{{likes_post($post->id)}}</span>
                                                                            </i>
                                                                            <i class="far fa-comments text-sm-center">
                                                                                <span class="badge badge-warning">{{$post->comments()->count()}}</span>
                                                                            </i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 mb-7 post">
                                                                <p>
                                                                        {{Str::limit($post->subtitle, 100)}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="mt-5 mb-5"/>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

@endsection

