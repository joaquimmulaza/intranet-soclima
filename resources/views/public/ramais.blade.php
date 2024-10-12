@extends('master.layout')
@section('title', 'Exibir ramais')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Ramais</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <div class="card card-primary card-outline">
                        {{--UNIDADES --}}
                        <div class="card-header">
                            <h3 class="card-title">Ramais principais</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                @foreach($units as $unit)
                                <li class="nav-item active">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-building mr-3"></i> {{$unit->titulo}}
                                        <span class="badge bg-primary float-right">{{$unit->ramal}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                    <div class="card card-primary card-outline">
                        {{-- RAMAIS--}}
                        <div class="card-header">
                            <h3 class="card-title">Ramais</h3>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr class="m-0">
                                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                            <td class="mailbox-name">{{$user->name}}</td>
                                            @if($user->ramal != null)
                                                <td class="mailbox-subject"><b>{{$user->unidade->titulo}}</b> <span class="badge bg-success float-right">{{$user->ramal}}</span></td>
                                            @else
                                                <td class="mailbox-subject"><b>{{$user->unidade->titulo}}</b> - <code>Sem ramal no momento</code></td>
                                            @endif
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{$user->cargo->titulo}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

@endsection

