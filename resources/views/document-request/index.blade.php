@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Documentos solicitados</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div> 
<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Tipo de Documento</th>
                <th>Forma de Entrega</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->tipo_documento }}</td>
                    <td>{{ ucfirst($request->forma_entrega) }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>
                        @if ($request->status === 'pendente')
                            <form action="{{ route('admin.document-request.upload', ['id' => $request->id])}}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="documento" class="form-control mb-2" required>
                                <button type="submit" class="btn btn-primary btn-sm">Upload Documento</button>
                            </form>
                        @endif
                        @if ($request->forma_entrega === 'fisicamente' && $request->status !== 'concluído')
                            <form action="{{ route('admin.document-request.complete', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Marcar como Concluído</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma solicitação encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $requests->links() }}
</div>
@endsection
