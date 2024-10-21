@extends('master.layout')
@section('title', 'Atribuir Dias de Férias')

@section('content')

    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        
                        <li class="breadcrumb-item active">Atribuir Dias de Férias</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3 class="text-black-50 font-weight-bold text-md-left">Atribuir Dias de Férias para {{ $user->name }}</h3>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form action="{{ route('users.ferias.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="form-group">
                                    <label for="dias_disponiveis">Dias Disponíveis</label>
                                    <input type="number" class="form-control" id="dias_disponiveis" name="dias_disponiveis" 
                                           value="{{ $user->diasFerias->dias_disponiveis ?? 0 }}" min="0">
                                </div>

                                <button type="submit" class="btn btn-success rounded">
                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                        <i class="far fa-save fa-w-20"></i>
                                    </span>
                                    Atualizar
                                </button>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
