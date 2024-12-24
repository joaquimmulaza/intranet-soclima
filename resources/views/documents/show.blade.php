@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Gerenciar documentos enviados</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container docs_container">
   
@foreach ($documents as $document)
    <table class="docs_table">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Enviado Por</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $document->document_type }}
                    <br>
                    <small class="text-muted">{{ $document->description }}</small>
                </td>
                <td>{{ $document->user->name ?? 'Usuário desconhecido' }}</td>
                <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-primary" target="_blank">Download</a>
                    <form method="POST" action="{{ route('documents.destroy', $document->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-bottom: 20px;"></div> <!-- Espaçamento explícito entre tabelas -->
@endforeach

   
</div>
@endsection