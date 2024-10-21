@extends('master.layout')
@section('title', 'Solicitar Férias')

@section('content')
    <div class="container">
        <h2>Solicitar Férias</h2>
        <form action="{{ route('ferias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="data_inicio">Data de Início</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
            </div>

            <div class="form-group">
                <label for="data_fim">Data de Fim</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim" required>
            </div>

            <button type="submit" class="btn btn-primary">Solicitar Férias</button>
        </form>
    </div>
@endsection
