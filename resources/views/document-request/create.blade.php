@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Pedido de documento</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container">
    <form method="POST" action="{{ route('document-request.store') }}">
        @csrf

        <div class="second_column">
            <div class="type_doc">
                <label for="tipo_documento" class="form-label">Tipo de documento*</label>
                <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                    <option value="Declaração de trabalho">Declaração de trabalho</option>
                    <option value="Comprovativo de residência">Comprovativo de residência</option>
                    <!-- Adicione outros tipos de documentos aqui -->
                </select>
            </div>
            <div class="mb-3">
                <label for="finalidade" class="form-label">Finalidade do documento*</label>
                <input type="text" id="finalidade" name="finalidade" class="form-control" required>
            </div>
        </div>

        <div class="third_column">
            <div class="">
                <label class="form-label">Forma de entrega</label>
                <div class="container_radios">
                    <div class="radio-docs">
                        <input type="radio" id="email" name="forma_entrega" value="email" required>
                        <label for="email">Envio por E-mail</label>
                    </div>
                    <div class="radio-docs">
                        <input type="radio" id="fisica" name="forma_entrega" value="fisica">
                        <label for="fisica">Entrega física no RH</label>
                    </div>
                    <div class="radio-docs">
                        <input type="radio" id="intranet" name="forma_entrega" value="intranet">
                        <label for="intranet">Envio na intranet</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="prazo_entrega" class="form-label">Prazo para entrega*</label>
                <input type="date" id="prazo_entrega" name="prazo_entrega" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea id="observacoes" name="observacoes" class="form-control"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Solicitar</button>
    </form>
</div>
@endsection