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
<div class="main_container manager_doc">
    <span>Veja os status das suas solicitações</span>
    <a href="#">Consultar</a>
</div>
<div class="main_container request_document">
    <form method="POST" action="{{ route('document-request.store') }}">
        @csrf

        <div class="all_column">
            <div class="first_column">
                <div class="form-group">
                    <label for="recipient">Nome completo</label>
                    <div class="destinatário">
                    <input type="hidden" name="recipient" value="Recursos Humanos">
                        <span>Recursos Humanos</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="recipient">A solicitar ao</label>
                    <div class="destinatário">
                    <input type="hidden" name="recipient" value="Recursos Humanos">
                        <span>Recursos Humanos</span>
                    </div>
                </div>
            </div>
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
                <div class="prazo_obs">
                    <div class="mb-3">
                        <label for="prazo_entrega" class="form-label">Prazo para entrega*</label>
                        <input type="date" id="prazo_entrega" name="prazo_entrega" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="btnsRequest">
                <button type="submit" class="cancelRequest">Cancelar</button>
                <button type="submit" class="requestBtn">Solicitar</button>
            </div>
        </div>
    </form>
</div>
@endsection