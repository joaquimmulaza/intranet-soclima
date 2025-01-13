@extends('master.layout')
@section('title', 'Solicitar Férias')

@section('content')
<style>
    .container_select2_ferias .select2-selection__arrow {
        background-image: url('{{ asset('logo/img/icon/seta_dowm.svg') }}') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        width: 32px !important;
        height: 32px !important;
        position: absolute !important;
        top: 4px !important;
        right: 65px !important;
    }

    /* Seta para cima quando o Select2 está aberto */
.container_select2_ferias .select2-selection[aria-expanded="true"] .select2-selection__arrow {
    background-image: url('{{ asset('logo/img/icon/seta-up.svg') }}') !important;
    background-size: contain !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    width: 32px !important;
    height: 32px !important;
    position: absolute !important;
    top: 4px !important;
    right: 65px !important;
}

.select2-container--default .select2-dropdown.select2-dropdown--below {
    width: 145.94px !important;
}

.auto_preenchimento{
    width: 145.94px;
}

.container_set_date {
    gap: 32px ;
}

</style>
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Solicitar férias</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
    <div class="container hidden">
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

            <button type="submit" class="btn btn-primary">Solicitar</button>
        </form>
    </div>

    <div id="content-injustificada" class="main_container">
        <div class="document-inputs">
            <div class="form-injustificada">
                <div class="form-group">
                    <label for="recipient">Departamento</label>
                    <div class="destinatário">
                        <span>{{ Auth::user()->unidade->titulo }}</span>
                    </div>
                </div>
                <div class="form-injustificada">
                    <div class="form-group">
                        <label for="recipient">A solicitar a</label>
                        <div class="destinatário">
                            <span>@if(Auth::user()->responsavel_id)
                                {{ Auth::user()->responsavel_id }}
                            @else
                                Sem Chefe de departamento
                            @endif</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-injustificada">
                <div class="form-group">
                    <label for="recipient">Nome completo</label>
                    <div class="destinatário">
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>
            
                <div class="form-group">
                    <label for="recipient">Função</label>
                    <div class="destinatário">
                        <span>{{ Auth::user()->cargo->titulo }}</span>
                    </div>
                </div>
            </div>
            
            <div class="form-injustificada">
                <div class="container_double_input">
                    <div class="form-group mySelectAusencias">
                        <label for="motivo">Nº mecanográfico*</label>
                        <div class="auto_preenchimento">
                            <span>{{ Auth::user()->numero_mecanografico }}</span>
                        </div>
                    </div>
                    <div class="form-group container_select2_ferias">
                        <label for="motivo">Férias relativas ao ano</label>
                        <select name="tipo_registo" class="mySelect2Global" required>
                            <option value="Dia Justificado">2025</option>
                            <option value="Desconto por atraso">2024</option>
                            <span class="select2-selection__arrow" role="presentation">
                            <b role="presentation"></b> <!-- Esta é a seta interna -->
                            </span>
                        </select>
                    </div>
                </div>
                <div class="form-group container_set_date" style="position: relative;">
                    <div class="container_start_date">
                        <label for="description">Data de inicio</label>
                        <input type="date" name="data_inicio">
                    </div>
                    <div>
                        <label for="description">Data de fim</label>
                        <div class="container_start_date">
                            <input type="date" name="horas">
                        </div>
                    </div>
                    
                    <!-- <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span> -->
                </div>
                
                
            </div>
            
            <div class="ausencias_container_btn">
                <button type="submit">Cancelar</button>
                <button type="submit">Justificar</button>
            </div>
        </div>
        
    </div>

<script>
    // Função genérica para inicializar Select2
function initializeSelect2(selector) {
    $(selector).select2({
        allowClear: false, // Remove o botão de limpar
        minimumResultsForSearch: Infinity,
    });
}

// Inicializar todos os selects com a classe 'mySelect'
$(document).ready(function () {
    initializeSelect2('.mySelect2Global');
});
</script>
@endsection
