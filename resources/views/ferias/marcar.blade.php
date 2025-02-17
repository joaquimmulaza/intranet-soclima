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
        <form action="{{ route('ferias.store') }}" method="POST">
        @csrf
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
                                {{ Auth::user()->responsavel->name}}
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
                        <div class="destinatário" style="width: 146px;">
                        <span>
                            @if($anoDesconto)
                                {{ $anoDesconto }}
                            @else
                                Sem saldo de férias disponível
                            @endif
                        </span>
                    </div>
                        <!-- <select name="tipo_registo" class="mySelect2Global">
                            <option value="Dia Justificado">2025</option>
                            <option value="Desconto por atraso">2024</option>
                            <span class="select2-selection__arrow" role="presentation">
                            <b role="presentation"></b>
                            </span>
                        </select> -->
                        
                    </div>
                </div>

                <div class="form-group container_set_date" style="position: relative;">

                    <div class="container_start_date ">
                        <label for="description">Data de inicio</label>
                        <input type="date" id="one_day" name="data_inicio" min="{{ now()->format('Y-m-d')}}">
                        <div class="container_checkbox " id="checkbox_container" style="opacity: 0.2;">
                            <input type="checkbox" name="data_fim" id="todo_dia" value="">
                            <label for="data_inicio">Ausentar-se todo o dia</label>
                        </div>
                        
                    </div>

                    <div class="transition_animation">
                        <label for="description" id="label_hidden">Data de fim</label>
                        <div class="container_start_date transition_animation">
                            <input type="date" id="when_one_day" name="data_fim" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" style="color: red;">
                        </div>
                    </div>
                    
                    <!-- <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span> -->
                </div>
                
                
            </div>
            @if ($errors->any())
                    <div class="alert alert-danger msg_error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.5 5.13824L15.4612 15.4378H3.53875L9.5 5.13824ZM9.5 1.97949L0.791664 17.0212H18.2083L9.5 1.97949ZM10.2917 13.0628H8.70833V14.6462H10.2917V13.0628ZM10.2917 8.31283H8.70833V11.4795H10.2917V8.31283Z" fill="#FF0000"/>
                                    </svg>
                                    <strong>Erro: </strong>{{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
            <div class="ausencias_container_btn">
                <button >Cancelar</button>
                <button type="submit">Solicitar</button>
            </div>
        </div>
        </form>
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

document.addEventListener("DOMContentLoaded", function () {
    let oneDayInput = document.getElementById("one_day");
    let labelColor = document.getElementById("label_hidden");
    let todoDiaCheckbox = document.getElementById("todo_dia");
    let whenOneDayInput = document.getElementById("when_one_day");
    let checkboxContainer = document.getElementById("checkbox_container");
    

    // Esconder o checkbox inicialmente
    checkboxContainer.style.opacity = 0.2
    todoDiaCheckbox.disabled = true;

    // Exibir checkbox quando a data for escolhida
    oneDayInput.addEventListener("change", function () {
        if (oneDayInput.value) {
            checkboxContainer.style.display = "flex"; // Aparece suavemente
            checkboxContainer.style.opacity = 0;
            checkboxContainer.disabled = false;
            todoDiaCheckbox.disabled = false;
            setTimeout(() => {
                checkboxContainer.style.opacity = 1;
                checkboxContainer.style.transition = "opacity 0.5s";
            }, 10);
        } else {
            checkboxContainer.style.opacity = 0.2
            checkboxContainer.disabled = true;
        }
         // Se o checkbox já estiver marcado, atualiza o value
         if (todoDiaCheckbox.checked) {
            todoDiaCheckbox.value = oneDayInput.value;
        }
        
    });

    // Atribuir a data ao checkbox apenas quando ele for selecionado
    todoDiaCheckbox.addEventListener("change", function () {
        if (todoDiaCheckbox.checked) {
            todoDiaCheckbox.value = oneDayInput.value; // Define o valor do checkbox
        } else {
            todoDiaCheckbox.value = ""; // Limpa o valor se for desmarcado
        }
    });

    whenOneDayInput.addEventListener("change", function () {
        if(whenOneDayInput.value) {
            checkboxContainer.style.display = "flex";
            checkboxContainer.style.opacity = 0.2
            checkboxContainer.disabled = true;
        } else {
            checkboxContainer.style.display = "flex"; // Aparece suavemente
            checkboxContainer.style.opacity = 0;
            checkboxContainer.disabled = false;
            setTimeout(() => {
                checkboxContainer.style.opacity = 0;
                checkboxContainer.style.transition = "opacity 0.5s";
            }, 10);
        }

       
    })

    // Desativar/ocultar o campo de data de fim se "Todo dia" for marcado
    todoDiaCheckbox.addEventListener("change", function () {
        if (todoDiaCheckbox.checked) {
            whenOneDayInput.style.borderColor = "#ababab70";
            checkboxContainer.style.opacity = 1;
            labelColor.style.color = "#ababab70";
            whenOneDayInput.disabled = true;
            whenOneDayInput.value="";
            whenOneDayInput.style.setProperty('color', '#ababab70', 'important');
        } else {
            labelColor.style.color = "#7B7B7B";
            whenOneDayInput.style.display = "block";
            checkboxContainer.style.opacity = 0.2
            whenOneDayInput.disabled = false;
            whenOneDayInput.style.borderColor = "#ABABAB"
            whenOneDayInput.style.setProperty('color', '#7B7B7B', 'important');
        }
    });

});

    

</script>
@endsection
