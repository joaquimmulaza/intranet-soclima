@extends('master.layout')
@section('title', 'Editar usuário')

@section('content')

    <!-- Header breadcrumb -->
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Liberar pedido de usuário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            <form action="{{ route('user.liberar', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">

                    {{--USUÁRIO --}}
                    <section class="col-lg-3 connectedSortable">
                        <div class="card card-primary card-outline" style="width: 100%; height: 100%;">
                            <div class="card-body box-profile">
                                <div class="text-center mb-4">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}"
                                         alt="User profile picture">
                                </div>
                                <div class="input-group mb-4">
                                    <input id="name" name="name" type="text" class="form-control" required="required" placeholder="Informe seu nome completo"
                                            value="{{$user->name}}"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-4">
                                    <input id="email" name="email" type="email" class="form-control" required="required" placeholder="Informe seu email"
                                           value="{{$user->email}}"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-4">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Informe uma senha"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Liberar pedido</button>
                </div>
            </form>
        </div>
    </section>
@endsection
