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
@if($user->cargo->titulo == 'Gerente')
    @if($documents->count() > 0)
        <div class="main_container manager_doc ">
            <span>{{$documents->count()}} documento(s) recebido(s)</span>
            <a href="{{route('documento-request.showSendDocs')}}">Gerenciar</a>
        </div>
    @else
    <div class="main_container manager_doc">
            <span>Nenhum documento recebido</span>
            <a href="{{route('documento-request.showSendDocs')}}">Gerenciar</a>
        </div>
    @endif 
@else
@endif

<div class="main_container doc_container">
    <form method="POST" class="formDocs" action="{{ route('documento-request.store') }}" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
        <!-- Área de Drop e Seleção de Arquivo -->
        <div class="drop-area_docs" id="drop-area_docs">
            <div class="drop-icon">
                <img src="{{asset('logo/img/icon/upload_file.svg')}}" alt="Upload Icon">
            </div>
            <p>Insira ou arrasta</p>
            <input type="file" id="file-upload" class="hidden" name="file"/>
        </div>  
        
      

        <!-- Cartão de Upload com a Barra de Progresso -->
        <div class="upload-card" id="upload-card" style="display: none;">
            <div class="upload-icon">
            <img src="{{asset('logo/img/icon/upload_file.svg')}}" alt="Upload Icon">
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
                    <span>Recursos Humanos</span>
                </div>
            </div>
            <div class="form-group">
                <label for="document_type">Tipo de documento</label>
                <select name="document_type" class="form-control" required>
                    <option value="Cópia do bilhete de identidade">Cópia do bilhete de identidade</option>
                    <option value="Cópia do passaporte">Cópia do passaporte</option>
                    <option value="Justificativo médico">Justificativo médico</option>
                    <option value="Justificativo de falta">Justificativo de falta</option>
                </select>
            </div>
            
            <div class="form-group" style="position: relative;">
                <label for="description">Descrição</label>
                <textarea id="description" name="description" class="form-control" rows="3" maxlength="200"></textarea>
                <span id="char-count" style="position: absolute; bottom: 5px; right: 10px; color: #888;">200</span>
            </div>
            <button type="submit">Enviar</button>
        </div>
    </form>
    <ul style="display: none;">
        @foreach ($documents as $document)
            <li>
                {{ $document->file_name }} - {{ $document->document_type }} - 
                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">Ver arquivo</a>
            </li>
        @endforeach
    </ul>
</div>

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

dropArea.addEventListener('click', (event) => {
    if (event.target !== fileInput) {
        fileInput.click();
    }
});


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
        xhr.open('POST', '{{ route('documento-request.store') }}', true);

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

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.formDocs'); // Seleciona o formulário

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previne o envio padrão do formulário

        let formData = new FormData(form); // Captura os dados do formulário

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                timer: 2000,
                position: "bottom-start",
                imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                imageAlt: "Custom image",
                imageWidth: 40,
                title: data.message,
                showConfirmButton: false,
                width: 225,
                backdrop: false,
                customClass: {
                popup: 'container_sweet_justificativos',
                icon: 'icon_sweet_justificativos',
                title: 'title_sweet_justificativos',
                image: 'img_sweet_justificativos'
            },
            willClose: () => {
                        window.location.reload();
                    }
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Ocorreu um erro ao enviar o documento.',
                confirmButtonColor: '#d33'
            });
        });
    });
});


</script>
@endsection