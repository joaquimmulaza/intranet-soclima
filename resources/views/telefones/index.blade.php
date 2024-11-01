@extends('master.layout')
@section('title', 'Lista Telefônica')

@section('content')

{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Lista Telefônica</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="content" style="display: none;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Telefones</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Departamento</th>
                                    <th>Função</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($telefones as $telefone)
                                    <tr>
                                        <td>{{ $telefone->nome }}</td>
                                        <td>{{ $telefone->departamento }}</td>
                                        <td>{{ $telefone->funcao }}</td>
                                        <td>{{ $telefone->telefone }}</td>
                                        <td>{{ $telefone->email }}</td>
                                        <td>
                                            <a href="{{ route('telefones.edit', $telefone->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('telefones.destroy', $telefone->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este telefone?')">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <div class="containerPhones">
        <header>
                <button class="add-button">Adicionar</button>
                <div>
                    <input type="text" placeholder="Procurar" class="search-input">
                    <button><img src="logo/img/icon/filter.svg" alt=""></button>
                </div>
            </div>
        </header>
        <div class="table-container">
            <table>
                <!-- <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Departamento</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr class="bodyTr">
                        <div>
                            <td><span class="avatar">T</span> <span class="name">Inserir nome do usuário</span></td>
                            <td>Departamento Comercial</td>
                        </div>
                        <td>+933000000</td>
                        <td>username@domain.com</td>
                        <td><button class="action-button">...</button></td>
                    </tr>
                    <!-- Repita as linhas conforme necessário -->
                </tbody>
            </table>
        </div>
    </div>



@endsection
