@extends('master.layout')
@section('title', 'Lista Telefônica')

@section('content')

<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Envio de documentos</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container manager_doc">
    <span>Nenhum documento recebido</span>
    <a href="#">Gerenciar</a>
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
                <label for="recipient">Destinatário</label>
                <div class="destinatário">
                <input type="hidden" name="recipient" value="Recursos Humanos" />
                    <span>Recursos Humanos</span>
                </div>
            </div>
            <div class="form-group">
                <label for="document_type">Tipo de documento</label>
                <select name="document_type" class="form-control" id="document_type" required>
                    <option value="Cópia do bilhete de identidade">Cópia do bilhete de identidade</option>
                    <option value="Contrato de trabalho">Contrato de trabalho</option>
                </select>
            </div>
            
            <div class="form-group" style="position: relative;">
                <label for="description">Descrição</label>
                <textarea id="description" name="description" class="form-control" rows="3" maxlength="200" required></textarea>
                <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span>
            </div>
            <button type="submit" id="submit-btn" style="cursor: not-allowed;" disabled>Enviar</button>
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
    const docType = document.getElementById("document_type");
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




    </script>
@endsection


