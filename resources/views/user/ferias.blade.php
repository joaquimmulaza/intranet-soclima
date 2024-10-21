@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Atribuir Dias de Férias para {{ $user->name }}</h3>

    <form action="{{ route('users.ferias.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="form-group">
            <label for="dias_disponiveis">Dias Disponíveis</label>
            <input type="number" class="form-control" id="dias_disponiveis" name="dias_disponiveis" 
                   value="{{ $user->diasFerias->dias_disponiveis ?? 0 }}" min="0">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
