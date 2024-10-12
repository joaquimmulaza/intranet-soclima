@extends('master.layout')
@section('title', 'Cadastrar cargo')

@section('content')

    <!-- Header breadcrumb -->
    <div class="content-header p-1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{isset($cargo) ? 'Editar' : 'Criar novo'}} cargo</li>
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
                            <form action="{{isset($cargo) ? route('cargo.update', $cargo->id) : route('cargo.store')}}"
                                  id="roleFrom" role="form" method="POST">
                                @csrf
                                @if (isset($cargo))
                                    @method('PUT')
                                @endif
                                <div class="card-body">
                                    <h3 class="text-black-50 font-weight-bold text-md-left">{{isset($cargo) ? 'Editar' : 'Criar novo'}} cargo</h3>

                                    <div class="md-form form-sm">
                                        <input id="titulo" name="titulo" type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror"
                                               value="{{$cargo->titulo ?? old('titulo')}}" autofocus/>
                                        <label class="text-black-50 font-weight-bold text-md-left" for="titulo">Nome do cargo</label>
                                        @error('titulo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="md-form md-outline pink-textarea active-pink-textarea">
                                        <textarea class="clearfix md-textarea form-control" id="atividades" name="atividades" required="required" rows="5" cols="20">{{isset($cargo) ? $cargo->atividades ?? old('atividades') : ""}}</textarea>
                                        <label class="text-black-50 font-weight-bold text-md-left" for="title">Descrição sobre a unidade</label>
                                    </div>

                                    <button type="submit" class="btn btn-success rounded">
                                        @isset($cargo)
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

                                    @isset($cargo)
                                    <a type="button" class="btn btn-danger rounded" href="{{route('cargo.index')}}">
                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                            <i class="fas fa-eraser fa-w-20"></i>
                                        </span>
                                        Cancelar
                                    </a>
                                    @else
                                        <button type="button" class="btn btn-danger rounded" onClick="limpaForm()">
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
<script>
    var campo = $(".campo-digitacao");
    // outros códigos
    var digitado = campo.val().trim();
</script>
@section('partialspost_js')
    <script src="{{asset('frontend/utilities/clearforms.js')}}"></script>
@endsection