@extends('master.layout')
@section('title', 'Adicionar Telefone')

@section('content')

{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Adicionar Telefone</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulário de Adição de Contato</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('telefones.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nome" placeholder="Informe o nome" required>
                            </div>

                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" name="departamento" class="form-control" id="departamento" placeholder="Informe o departamento" required>
                            </div>

                            <div class="form-group">
                                <label for="funcao">Função</label>
                                <input type="text" name="funcao" class="form-control" id="funcao" placeholder="Informe a função" required>
                            </div>

                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Informe o telefone">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Informe o email (opcional)">
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Adicionar Contato</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
