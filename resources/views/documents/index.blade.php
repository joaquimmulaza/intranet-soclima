@extends('master.layout')
@section('title', 'Ausências')

@section('content')

<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .mySelectAusencias .select2-selection__arrow {
        background-image: url('{{ asset('logo/img/icon/seta_dowm.svg') }}') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        width: 32px !important;
        height: 32px !important;
        position: absolute !important;
        top: 4px !important;
        right: 10px !important;
    }

    /* Seta para cima quando o Select2 está aberto */
.mySelectAusencias .select2-selection[aria-expanded="true"] .select2-selection__arrow {
    background-image: url('{{ asset('logo/img/icon/seta-up.svg') }}') !important;
    background-size: contain !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    width: 32px !important;
    height: 32px !important;
    position: absolute !important;
    top: 4px !important;
    right: 10px !important;
}
</style>
{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2 justify-content-between">
            <div class="">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências</li>
                </ol>
            </div>

            <div class="changePageBtn">
                <a href="#" class="ChangeBtnFaltas active" id="btnFaltas" onclick="showContent('faltas')">Faltas</a>
                <a href="#" class="ChangeBtnFerias" id="btnFerias" onclick="showContent('ferias')">Férias</a>
            </div>
    </div>
   
</div>
<hr>
<div class="containerBtnAusencias">
    <a href="{{ route('ferias.show', ['id' => $id]) }}">Consultar Férias</a>
    <a href="{{ route('ferias.marcar') }}">Solicitar Férias</a>
</div>

<div id="contentFaltas">
   
    <form method="POST" class="formDocs" action="{{ route('documents.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="">
        
        <div class="main_container manager_doc">
            <div class="container_radio_foul">
                <span>Tipo de falta</span>
                <div class="radio_foul">
                    <div class="radio-docs">
                        <input type="radio" name="tipo_falta" id="justificada" value="justificada" checked onchange="toggleContent(this)">
                        <label for="justificada">Justificada</label>
                    </div>
                    <div class="radio-docs">
                        <input type="radio" name="tipo_falta" id="injustificada" value="Injustificada" onchange="toggleContent(this)">
                        <label for="injustificada">Injustificada</label>
                    </div>
                </div>
            </div>
            @can('app.dashboard')
            <a href="{{ route('documents.show') }}" class="globalBtn_with_border">Justificativos</a>
            @endcan
        </div>
        <!-- Conteúdo para Injustificada -->
            <div id="content-injustificada" class="content_ausencia hidden">
                <div class="document-inputs">
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
                        <div class="form-group">
                            <label for="recipient">Departamento</label>
                            <div class="destinatário">
                                <span>{{ Auth::user()->unidade->titulo }}</span>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias">
                            <label for="document_type">Tipo de registo</label>
                            <select name="tipo_registo" class=" form-control" id="mySelect3" >
                                <option value="Dia Injustificado">Dia Injustificado</option>
                                <option value="Desconto por atraso">Desconto por atraso</option>
                                <span class="select2-selection__arrow" role="presentation">
                                <b role="presentation"></b> <!-- Esta é a seta interna -->
                                </span>
                            </select>
                        </div>
                    </div>
                    <div class="form-injustificada">
                        <div class="form-group mySelectAusencias">
                            <label for="motivo">Motivo</label>
                            <input type="text" name="motivo" class="form-injustificada-input">
                        </div>
                        <div class="form-group container_set_date" style="position: relative;">
                            <div class="container_start_date">
                                <label for="description">Data que faltou</label>
                                <input type="date" name="data_inicio">
                            </div>
                            <div class="container_end_date container_end_date2">
                                <label for="description" class="ocultado">Faltou apenas</label>
                                <div class="container_input_end_date_select3">
                                    <input type="number" name="horas" id="input_hours" class="ocultado" placeholder="0">
                                    <span class="ocultado">Horas</span>
                                </div>
                            </div>
        
                            <!-- <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span> -->
                        </div>
        
        
                    </div>
                    <div class="container_descontar_ferias">
                        <div class="descontar_nasFerias">
                            <p>Subtrair nas férias anuais</p>
                            <div class="radio_descontar">
                            <div class="radio-docs">
                            <input type="radio" name="descontar_nas_ferias" id="sim" value="Sim" checked>
                            <label for="sim">Sim</label>
                        </div>
                    </div>
        
                    <div class="radio-docs">
                        <input type="radio" name="descontar_nas_ferias" id="não" value="Não">
                        <label for="não">Não</label>
                    </div>
                        </div>
                    </div>
                    <div class="ausencias_container_btn">
                        <button type="button">Cancelar</button>
                        <button type="submit" id="justificar-injustificada">Justificar</button>
                    </div>
                </div>
        
            </div>
        <div class="main_container doc_container content_ausencia visible" id="content-justificada">
        
                <div class="form_ausencias">
                    <div class="form-group">
                        <!-- Área de Drop e Seleção de Arquivo -->
                        <div class="drop-area_docs" id="drop-area_docs">
                            <div class="drop-icon">
                                <img src="logo/img/icon/upload_file.svg" alt="Upload Icon">
                            </div>
                            <p>Insira ou arrasta</p>
                            <input type="file" id="file-upload" name="arquivo_comprovativo"  />
                        </div>
                        <!-- Cartão de Upload com a Barra de Progresso -->
                        <div class="upload-card" id="upload-card" style="display: none;">
                            <div class="upload-icon">
                            <img src="logo/img/icon/upload_file.svg" alt="Upload Icon">
                                <div style="overflow: hidden; text-overflow: ellipsis; font-size: 11px;">
                                    <strong id="file-name">untitled</strong>
                                </div>
                            </div>
                            <span class="close-btn" onclick="resetUpload()"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#555555"/>
                            </svg>
                            </span>
                            <div class="progress-container">
                                <div class="progress-bar" id="progress-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="document-inputs">
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
                        <div class="form-group">
                            <label for="recipient">Departamento</label>
                            <div class="destinatário">
                                <span>{{ Auth::user()->unidade->titulo }}</span>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias">
                            <label for="document_type">Tipo de registo</label>
                            <select name="tipo_registo" class="mySelect form-control" id="mySelect" >
                                <option value="Dia Justificado">Dia Justificado</option>
                                <option value="Desconto por atraso">Desconto por atraso</option>
                                <span class="select2-selection__arrow" role="presentation">
                                <b role="presentation"></b> <!-- Esta é a seta interna -->
                                </span>
                            </select>
                        </div>
                        <div class="form-group mySelectAusencias">
                            <label for="document_type">Motivo</label>
                            <select name="motivo" class="form-control" id="document_type" >
                                <option style=" border-bottom-right-radius: 0 !important;
                                border-bottom-left-radius: 0 !important;" value="Assistência membro familiar">Assistência membro familiar</option>
                                <option value="Doença">Doença</option>
                                <option value="Justificação de filhos">Justificação de filhos</option>
                                <option value="Licença matrimónio">Licença matrimónio</option>
                                <option value="Óbito">Óbito</option>
                            </select>
                        </div>
                        <div class="form-group container_set_date" style="position: relative;">
                            <div class="container_start_date">
                                <label for="description" >Data que faltou</label>
                                <input type="date" name="data_inicio">
                            </div>
                            <div class="container_end_date">
                                <label for="description" class="description_label">Faltou apenas</label>
                                <div class="container_input_end_date">
                                    <input type="number" name="horas" class="input_hours description_label " placeholder="0">
                                    <span class="description_label">Horas</span>
                                </div>
                            </div>
                            <!-- <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span> -->
                        </div>
                        <div class="ausencias_container_btn">
                            <button type="button">Cancelar</button>
                            <button type="submit" id="justificar-injustificada">Justificar</button>
                        </div>
                    </div>
                </div>
        </div>
        
        </div>
    </div>
<p class="short_info">Faltas sem qualquer comunicação prévia serão consideradas injustificadas, caso não seja apresentado o devido justificativo</p>
</form>


<div id="contentFerias">
    <div class="container_calendar">
        <!-- Exibindo o calendário -->
        <div id="calendar"></div>
    </div>
</div>



<!-- Popup -->
<div id="success-popup" style="display: none;">
    <div class="content-sucess-popup">
        <img src="logo/img/icon/Completed.svg" alt="Success Icon">
        <p>Ficheiro enviado com sucesso!</p>
        <button id="popup-ok-btn">Ok</button>
    </div>
</div>
<div id="overlay" style="display: none;"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/locale/pt.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
const fileInput = document.getElementById('file-upload');
const dropArea = document.getElementById('drop-area_docs');
const uploadCard = document.getElementById('upload-card');
const fileNameDisplay = document.getElementById('file-name');
const progressBar = document.getElementById('progress-bar');

// Adicionar eventos de arrastar
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.style.backgroundColor = '#f5f5f5';
});

dropArea.addEventListener('dragleave', () => {
    dropArea.style.backgroundColor = 'white';
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.style.backgroundColor = 'white';
    const file = e.dataTransfer.files[0];
    handleFile(file);
});

// Clique para selecionar o arquivo
dropArea.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    handleFile(file);
});

// Função para manipular o arquivo e exibir a barra de progresso
function handleFile(file) {
    if (file) {
        dropArea.style.display = 'none'; // Esconder área de drop
        uploadCard.style.display = 'block'; // Mostrar barra de progresso
        fileNameDisplay.textContent = file.name;

        // Simular upload usando XMLHttpRequest
        const formData = new FormData();
        formData.append('file', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('documents.store') }}', true);

        // Atualizar a barra de progresso
        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBar.style.width = percentComplete + '%';
            }
        };

        

        xhr.send(formData);
    }
}

function resetUpload() {
    fileInput.value = '';
    uploadCard.style.display = 'none';
    dropArea.style.display = 'flex';
    progressBar.style.width = '0%';
}


    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".formDocs");
    const fileInput = document.getElementById("file-upload");
    const docType = document.getElementById("mySelect");
    const description = document.getElementById("description");
    const submitButton = document.getElementById("submit-btn");

    function checkFields() {
        // Verifica se todos os campos obrigatórios foram preenchidos
        if (
            fileInput.files.length > 0 &&
            docType.value !== "" &&
            description.value.trim() !== ""
        ) {
            submitButton.style.backgroundColor = "#009AC1"; // Cor verde
            submitButton.style.color = "#fff";
            submitButton.style.cursor = "pointer";
            submitButton.disabled = false;
        } else {
            submitButton.style.backgroundColor = "#E2E2E2"; // Cor cinza
            submitButton.style.cursor = "not-allowed";
            submitButton.disabled = true;
        }
    }

    // Adiciona eventos de input para verificar os campos em tempo real
    fileInput.addEventListener("change", checkFields);
    docType.addEventListener("change", checkFields);
    // description.addEventListener("input", checkFields);
});




function updateFieldState() {
    const selects = document.querySelectorAll('.mySelect'); // Seleciona todos os selects com a classe
    const inputHoursElements = document.querySelectorAll('.input_hours'); // Seleciona todos os inputs de horas
    const descriptionLabels = document.querySelectorAll(".description_label"); // Seleciona todos os labels de descrição

    // Itera sobre todos os selects para aplicar a lógica
    selects.forEach(select => {
        const value = $(select).val(); // Obtém o valor do select (mantém compatibilidade com Select2)

        if (value === 'Dia Justificado') {
            inputHoursElements.forEach(input => {
                input.disabled = true; // Desabilita o input
            });
            descriptionLabels.forEach(label => {
                label.classList.add('disabled-label'); // Adiciona estilo desabilitado
            });
        } else {
            inputHoursElements.forEach(input => {
                input.disabled = false; // Habilita o input
            });
            descriptionLabels.forEach(label => {
                label.classList.remove('disabled-label'); // Remove estilo desabilitado
            });
        }
    });
}

function atualizarEstadoCampos() {
    const select = $('#mySelect3');  // Seleciona o elemento usando jQuery Select2
    const inputHours = document.getElementById('input_hours');
    const descriptionLabels = document.querySelectorAll(".container_end_date2 label, .container_end_date2 span"); // Seleciona o label e o span
    const containerInputEndDate = document.querySelector(".container_input_end_date_select3"); // Seleciona o contêiner do input

    // Usando o valor do select através do Select2
    if (select.val() === 'Dia Injustificado') {
        inputHours.disabled = true; // Desabilita o input
        // Adiciona a classe 'ocultado' tanto no label quanto no span e no input
        descriptionLabels.forEach(label => {
            label.classList.add('ocultado');
        });
        containerInputEndDate.classList.add('ocultado'); // Oculta o contêiner do input
    } else {
        inputHours.disabled = false; // Habilita o input
        // Remove a classe 'ocultado' para tornar o label, span e input visíveis
        descriptionLabels.forEach(label => {
            label.classList.remove('ocultado');
        });
        containerInputEndDate.classList.remove('ocultado'); // Exibe o contêiner do input
    }
}

// Atualiza o estado ao carregar a página
document.addEventListener('DOMContentLoaded', atualizarEstadoCampos);

// Atualiza o estado ao mudar o valor do select
document.getElementById('mySelect3').addEventListener('change', atualizarEstadoCampos);

$(document).ready(function() {
    // Inicializando o Select2 para o select com o id 'mySelect3'
    $('#mySelect3').select2({
        minimumResultsForSearch: -1  // Remove a caixa de pesquisa
    });

    // Chama a função atualizarEstadoCampos sempre que o valor mudar
    $('#mySelect3').on('change', function() {
        atualizarEstadoCampos();
    });
});







// Atualiza o estado ao carregar a página
document.addEventListener('DOMContentLoaded', updateFieldState);

// Atualiza o estado ao mudar o valor do select
document.getElementById('mySelect').addEventListener('change', updateFieldState);


$(document).ready(function() {
    // Inicializando o Select2 para todos os selects com a classe 'mySelectAusencias'
    $('.mySelectAusencias select').select2({
        minimumResultsForSearch: -1  // Remove a caixa de pesquisa
    });

    // Chama a função updateFieldState sempre que o valor mudar
    $('.mySelectAusencias select').on('change', function() {
        updateFieldState();
    });
});

$(document).ready(function() {
    let eventCountByDate = {}; // Objeto para contar quantos eventos já ocorreram em um determinado dia

    // Função para gerar cores alternadas para eventos no mesmo dia
    function generateAlternatingHexColor(date, index) {
        // Gerar cor base de forma similar ao código anterior
        const baseHash = (date.getTime() + index);
        const hexColor = "#" + ((baseHash & 0x00FFFFFF) | 0x808080).toString(16).padStart(6, '0');
        return hexColor;
    }

    $('#calendar').fullCalendar({
        locale: 'pt', // Define o idioma como português
        events: '/events',  // URL que retorna os eventos (pedidos de férias)
        editable: false,  // Desabilitar edição
        droppable: false,  // Não permitir arrastar eventos
        eventRender: function(event, element) {
            element.find('.fc-title').append('<br/>' + event.description);  // Exibe descrição do evento

            // Extraímos a data de início e a data de fim do evento
            const startDate = new Date(event.start);
            const endDate = event.end ? new Date(event.end) : startDate;

            // Criamos um identificador único para o dia (usando data de início e fim)
            let eventKey = startDate.toISOString().split('T')[0]; // Usa a data no formato YYYY-MM-DD como chave
            if (!eventCountByDate[eventKey]) {
                eventCountByDate[eventKey] = 0; // Se não houver eventos no mesmo dia, inicia o contador
            }

            // Alterna a cor para cada evento no mesmo dia
            const color = generateAlternatingHexColor(startDate, eventCountByDate[eventKey]);
            
            // Atribui a cor de fundo ao evento
            element.css('background-color', color);
            element.css('border-color', color);

            // Incrementa o contador para o dia
            eventCountByDate[eventKey]++;
        },
    });
});

function showContent(type) {
    const btnAusencias = document.querySelector('.containerBtnAusencias');
    const short_info = document.querySelector('.short_info');
    // Esconde ambos os conteúdos
    document.getElementById('contentFaltas').style.visibility = 'hidden';
    document.getElementById('contentFaltas').style.position = 'absolute';

    document.getElementById('contentFerias').style.visibility = 'hidden';
    document.querySelector('.short_info').style.display = 'block';
    document.getElementById('contentFerias').style.position = 'absolute';

    // Exibe o conteúdo selecionado
    if (type === 'faltas') {
        document.getElementById('contentFaltas').style.visibility = 'visible';
        document.getElementById('contentFaltas').style.position = 'relative';

        btnAusencias.style.display = 'none'; // Oculta o botão
        document.getElementById('btnFaltas').classList.add('active');
        document.getElementById('btnFerias').classList.remove('active');
    } else if (type === 'ferias') {
        document.getElementById('contentFerias').style.visibility = 'visible';
        document.getElementById('contentFerias').style.position = 'relative';
        btnAusencias.style.display = 'flex'; 
        document.querySelector('.short_info').style.display = 'none';
        document.getElementById('btnFerias').classList.add('active');
        document.getElementById('btnFaltas').classList.remove('active');
    }
}


function toggleContent(radio) {
    // Ocultar todos os conteúdos
    const contents = document.querySelectorAll('.content_ausencia');
    contents.forEach(content => {
        content.classList.remove('visible');
        content.classList.add('hidden');
    });

    // Exibir o conteúdo correspondente ao radio selecionado
    const selectedContent = document.getElementById(`content-${radio.value.toLowerCase()}`);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
        selectedContent.classList.add('visible');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const contentJustificada = document.getElementById("content-justificada");
    const contentInjustificada = document.getElementById("content-injustificada");
    const form = document.querySelector(".formDocs");

    const toggleFields = () => {
        if (contentJustificada.classList.contains("visible")) {
            // Remover os campos de "injustificada"
            contentInjustificada.querySelectorAll("input, select").forEach(input => input.remove());
        } else {
            // Remover os campos de "justificada"
            contentJustificada.querySelectorAll("input, select").forEach(input => input.remove());
        }
    };

    form.addEventListener("submit", function (event) {
        toggleFields();
    });
});

</script>

@endsection