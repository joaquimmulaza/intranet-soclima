@extends('master.layout')
@section('title', 'Lista Telefônica')

@section('content')

<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .mySelectAusencias .select2-selection__arrow {
        background-image: url('{{ asset('logo/img/icon/seta_dowm.svg') }}') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        width: 20px !important;
        height: 20px !important;
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
    }

    /* Seta para cima quando o Select2 está aberto */
.mySelectAusencias .select2-selection[aria-expanded="true"] .select2-selection__arrow {
    background-image: url('{{ asset('logo/img/icon/seta-up.svg') }}') !important;
    background-size: contain !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    width: 20px !important;
    height: 20px !important;
    position: absolute !important;
    top: 10px !important;
    right: 10px !important;
}
</style>
{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container manager_doc">
    <div class="container_radio_foul">
        <span>Tipo de falta</span>
        <div class="radio_foul">
            <div class="radio-docs">
                <input type="radio" name="tipo_falta" id="justificada" value="Justificada" required>
                <label for="justificada">Justificada</label>
            </div>
            <div class="radio-docs">
                <input type="radio" name="tipo_falta" id="injustificada" value="Injustificada">
                <label for="injustificada">Injustificada</label>
            </div>
            <div class="radio-docs">
                <input type="radio" name="tipo_falta" id="ausentar" value="Desejo ausentar-se">
                <label for="ausentar">Desejo ausentar-se</label>
            </div>
        </div>
    </div>
    <!-- <a href="#">Gerenciar</a> -->
</div>
<div class="main_container doc_container">
    <form method="POST" class="formDocs" action="{{ route('documents.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <!-- Área de Drop e Seleção de Arquivo -->
            <div class="drop-area_docs" id="drop-area_docs">
                <div class="drop-icon">
                    <img src="logo/img/icon/upload_file.svg" alt="Upload Icon">
                </div>
                <p>Insira ou arrasta</p>
                <input type="file" id="file-upload" name="file" required />
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
                <input type="hidden" name="recipient" value="Recursos Humanos" />
                    <span>Nome User</span>
                </div>
            </div>
            <div class="form-group">
                <label for="recipient">Função</label>
                <div class="destinatário">
                <input type="hidden" name="recipient" value="Recursos Humanos" />
                    <span>Designer</span>
                </div>
            </div>
            <div class="form-group">
                <label for="recipient">Departamento</label>
                <div class="destinatário">
                <input type="hidden" name="recipient" value="Recursos Humanos" />
                    <span>Marketing</span>
                </div>
            </div>
            
            <div class="form-group mySelectAusencias">
                <label for="document_type">Tipo de registo</label>
                <select name="document_type" class="form-control" id="mySelect" required>
                    <option value="Dia Justificado">Dia Justificado</option>
                    <option value="Desconto por atraso">Desconto por atraso</option>
                    <span class="select2-selection__arrow" role="presentation">
      <b role="presentation"></b> <!-- Esta é a seta interna -->
    </span>
                </select>
            </div>

            <div class="form-group mySelectAusencias">
                <label for="document_type">Motivo</label>
                <select name="document_type" class="form-control" id="document_type" required>
                    <option style=" border-bottom-right-radius: 0 !important;
    border-bottom-left-radius: 0 !important;" value="Cópia do bilhete de identidade">Assistência membro familiar</option>
                    <option value="Contrato de trabalho">Doença</option>
                    <option value="Contrato de trabalho">Justificação de filhos</option>
                    <option value="Contrato de trabalho">Licença matrimónio</option>
                    <option value="Contrato de trabalho">Óbito</option>
                </select>
            </div>
            
            
            <div class="form-group container_set_date" style="position: relative;">
                <div class="container_start_date">
                    <label for="description" >Data que faltou</label>
                    <input type="date">
                </div>
                <div class="container_end_date">
                    <label for="description" class="description_label ocultado">Faltou apenas</label>
                    <div class="container_input_end_date">
                        <input type="number" id="input_hours" class="description_label ocultado" placeholder="0">
                        <span class="description_label ocultado">Horas</span>
                    </div>
                </div>
                <!-- <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span> -->
            </div>
            <div class="ausencias_container_btn">
                <button type="submit">Cancelar</button>
                <button type="submit">Enviar</button>
            </div>
        </div>
    </form>
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

document.addEventListener('DOMContentLoaded', function() {
      const textarea = document.getElementById('description');
      const charCount = document.getElementById('char-count');
      const maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', function() {
        const remaining = maxLength - textarea.value.length;
        charCount.textContent = remaining;
      });
    });

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
    description.addEventListener("input", checkFields);
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".formDocs");
    const popup = document.getElementById("success-popup");
    const overlay = document.getElementById("overlay");
    const okButton = document.getElementById("popup-ok-btn");
    const charCount = document.getElementById("char-count");
    const description = document.getElementById("description");
    const fileInput = document.getElementById("file-upload");
    const dropArea = document.getElementById("drop-area_docs");
    const uploadCard = document.getElementById("upload-card");

    // Usar AJAX para enviar o formulário
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Impedir o recarregamento da página

        const formData = new FormData(form);

        // Fazer a requisição AJAX
        fetch(form.action, {
            method: form.method,
            body: formData,
        })
            .then(response => {
                if (response.ok) {
                    showPopup(); // Mostrar popup em caso de sucesso
                } else {
                    console.error("Erro ao enviar o documento.");
                }
            })
            .catch(error => console.error("Erro na requisição:", error));
    });

    // Mostrar popup
    function showPopup() {
        popup.style.display = "block";
        overlay.style.display = "block";
    }

    // Fechar popup ao clicar no botão "OK"
    okButton.addEventListener("click", function () {
        closePopup();
        resetForm(); // Limpar o formulário ao fechar o popup
    });

    // Fechar popup ao clicar no overlay
    overlay.addEventListener("click", function () {
        closePopup();
        resetForm(); // Limpar o formulário ao fechar o popup
    });

    // Função para fechar o popup
    function closePopup() {
        popup.style.display = "none";
        overlay.style.display = "none";
    }

    // Função para redefinir os campos do formulário
    function resetForm() {
        form.reset(); // Limpa todos os valores dos inputs, selects e textareas
        charCount.textContent = "200"; // Redefinir contador de caracteres
        resetFileInput(); // Redefinir o campo de upload para o estado inicial
    }

    // Função para redefinir o campo de upload para o estado inicial
    function resetFileInput() {
        fileInput.value = ""; // Limpa o campo de arquivo
        uploadCard.style.display = "none"; // Esconde o cartão de upload
        dropArea.style.display = "flex"; // Mostra o estilo original do drop area
    }

    // Atualizar contador de caracteres na descrição
    description.addEventListener("input", function () {
        const remaining = 200 - description.value.length;
        charCount.textContent = remaining;
    });
});


function updateFieldState() {
    const select = $('#mySelect');  // Seleciona o elemento usando jQuery Select2
    const inputHours = document.getElementById('input_hours');
    const descriptionLabels = document.querySelectorAll(".description_label");

    // Usando o valor do select através do Select2
    if (select.val() === 'Dia Justificado') {
        inputHours.disabled = true; // Desabilita o input
        descriptionLabels.forEach(label => {
            label.classList.add('disabled-label'); // Aplica estilo desabilitado
        });
    } else {
        inputHours.disabled = false; // Habilita o input
        descriptionLabels.forEach(label => {
            label.classList.remove('disabled-label'); // Remove estilo desabilitado
        });
    }
}


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


    </script>
@endsection


