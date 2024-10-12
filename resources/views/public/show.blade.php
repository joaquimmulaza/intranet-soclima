@extends('...master.layout')
@section('title', 'Exibir notícia')

@section('content')

    <!-- Header breadcrumb -->
    <div class="content-header p-1">
        <div class="container-fluid">
            @include('flash::message')
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Notícia</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="container">
            <div class="row">
                <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row">
                            {{-- TITULO E AUTOR DA NOTÍCIA --}}
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                {{-- TITULO --}}

                                <h1 class="mt-4 text-black-50 text-bold text-center">{{$post->title}}</h1>

                                <div class="text-justify">
                                    <p class="text-black-50">{{$post->subtitle}}</p>
                                </div>

                                <div class="flex-row font-weight-normal font-weight-light mb-2 text-right">
                                    <span>
                                        <img src="{{URL::to('/')}}/public/avatar_users/{{$post->user->avatar}}" class="img-circle elevation-2" width=20" alt="minha imagem">
                                    </span>
                                    <span>{{$post->user->name}}</span>
                                    <span class="text-small"> - Postado em {{date('d/m/Y', strtotime($post->created_at))}}</span>
                                </div>

                                {{-- CAPA --}}
                                <div class="view overlay zoom">
                                    <img class="card-img-top figure-img img-fluid rounded" src="/storage/{{$post->capa}}" width="100%" height="50%" alt="{{$post->title}}">

                                    <div class="mask rgba-white-slight waves-effect waves-light aling-items-center text-center py-4 px-3">
                                        <h6 class="btn btn-rounded cloudy-knoxville-gradient waves-effect waves-light text-indigo font-weight-bolt">
                                            <a class="text-purple font-weight-bold" href="{{route('post.download', ['post'=>$post->id])}}">
                                                Baixar imagem
                                            </a>
                                        </h6>
                                    </div>

                                </div>

                                <hr>

                                {{-- CONTEÚDO DA NOTÍCIA --}}
                                <p class="lead">{!!$post->content !!}</p>

                                <p class="lead">{!!$post->resumo!!}</p>

                                {{-- LIKES --}}
                                <article class="post" data-postid="{{ $post->id }}">
                                    <div class="interaction mb-2" style="font-size: 18px;">
                                        <a href="#" class="like">
                                            {{
                                                Auth::user()->likes()->where('post_id', $post->id)->first() ?
                                                Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ?
                                                'Eu gostei muito!!' : 'Gostar' : 'Gostar'
                                            }}
                                        </a> |
                                        <a href="#" class="like">
                                            {{
                                                Auth::user()->likes()->where('post_id', $post->id)->first() ?
                                                Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ?
                                                'Eu não gostei!!' : 'Não gostar' : 'Não gostar'
                                            }}
                                        </a>
                                    </div>
                                </article>

                                {{-- CATEGORIAS --}}
                                <div class="d-flex mb-2">
                                    @foreach($post->categorias as $cat)
                                        <span class="badge badge-warning m-1">{{$cat->titulo}}</span>
                                    @endforeach
                                </div>

                                {{-- BOTÕES --}}
                                <div class="d-flex">
                                    @can('app.dashboard')
                                        <a type="button" class="btn btn-sm btn-success rounded text-white"
                                           href="{{ route('post.edit', ['post' => $post->id]) }}">
                                               <span class="btn-icon-wrapper pr-2 opacity-7">
                                                    <i class="fas fa-edit"></i>
                                               </span>
                                            Editar
                                        </a>

                                        <button type="button" class="btn btn-sm btn-danger rounded" onClick="deleteData({{ $post->id }})">
                                               <span class="btn-icon-wrapper pr-2 opacity-9">
                                                    <i class="fas fa-trash-alt fa-w-20"></i>
                                               </span>
                                            Deletar notícia
                                        </button>
                                        <form id="delete-form-{{ $post->id }}"
                                              action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST" style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                </div>



                                {{-- BLOCO DE COMENTÁRIOS --}}
                                @if($post->comments->count() > 0)
                                    <div >
                                        <div class="timeline timeline-inverse">
                                            @foreach($post->comments as $comment)
                                                <div class="time-label">
                                                    <span class="bg-success">
                                                      {{date('d/M/y', strtotime($comment->created_at))}}
                                                    </span>
                                                </div>

                                                <div>
                                                <i class="fas fa-comments bg-warning"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> {{date('d/m/y', strtotime($comment->created_at))}}</span>

                                                    <div class="d-flex align-content-between">
                                                        <img src="{{URL::to('/')}}/public/avatar_users/{{$comment->user->avatar}}" alt="avatar"
                                                             class="m-2 avatar rounded-circle d-flex align-self-center z-depth-1" width=35" height="35">
                                                        <div class="text-small">
                                                            <strong class="text-indigo text-bold">{{$comment->user->name}}</strong>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-body">
                                                        {{$comment->body}}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div>
                                                <i class="far fa-clock bg-gray"></i>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <h6 class="mt-1 mb-1" align="left">Sem comentários. Seja o primeiro a comentar!</h6>
                                @endif
                                    <!-- POST COMMENT -->
                                    <p class="font-weight-normal size font-weight-bold text-md-left">Sessão de comentários <strong class="text-indigo text-bold">({{$post->comments()->count()}})</strong></p>

                                    <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="post">
                                        @csrf
                                        <div class="md-form md-outline purple-border">
                                            <textarea class="md-textarea form-control" id="comment" name="comment" rows="2" cols="20"></textarea>
                                            <label class="text-black-50 font-weight-bold text-md-left" for="title">Comentar aqui</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="far fa-comments fa-w-20"></i>
                                            </span>
                                            Comentar
                                        </button>
                                    </form>

                            </div>
                        </div>
                </section>

                <section class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                    <hr/>
                    <p class="font-weight-normal font-weight-bold text-md-left">Conteúdo relacionado</p>
                    <div class="row p-2 mt-2">
                        @foreach($posts as $post)
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="row">
                                    {{--IMAGEM --}}
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0">
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

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0">
                                        <p class="mb-1" align="center">
                                            <a href="{{route('post.show', ['post'=> $post])}}" class="text-hover font-weight-bold">{{$post->title}}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
    </section>
    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
    <script>
        var token = '{{ csrf_token() }}';
        var urlLike = '{{ route('like') }}';
    </script>
@endsection

@section('partialspost_js')
    <script src="{{asset('js/app.js')}}"></script>
@endsection
