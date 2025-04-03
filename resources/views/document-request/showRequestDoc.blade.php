@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
<div class="container-fluid">
        <div class="row mb-2 justify-content-between">
            <div class="">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Documentos solicitados</li>
                </ol>
            </div>
        </div>
</div>
<hr>
<div class="main_container manager_doc">
    <div class="detail_user_justificativo">
        <div class="container_detail_user_justificativo">
            <span class="globla_status_style {{ $documentRequest->status }}">{{  $documentRequest->status === 'concluído' ? 'Pronto' : $documentRequest->status}}</span>
            <div>
                <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt="">
            </div>
            <div class="content_detail_user_justificativo">
                <span class="content_detail_user_name">{{  $documentRequest->user->name  }} </span>
                <div class="content_detail_user_work">
                    <span>{{  $documentRequest->user->unidade->titulo  }} </span>|<span> {{$documentRequest->user->cargo->titulo  }}</span>
                </div>
            </div>
        </div>
    </div>
    @if($documentRequest->user->role_id == 1)
    <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar</a>
    @else
    <a href="" class="globalBtn_with_border right_side">Voltar</a>
    @endif
   
    

    
</div>
<div class="main_container doc_container content_ausencia visible" id="content-justificada">
        
                <div class="form_ausencias">
                        
                <form method="POST" action="{{ route('admin.document-request.upload', $documentRequest->id) }}" enctype="multipart/form-data" style="display: flex; gap: 36px;">
                        @csrf
                            <div class="form-group">
                            <!-- Área de Drop e Seleção de Arquivo -->
                            <div class="drop-area_docs" id="drop-area_docs">
                                <div class="drop-icon">
                                    <img src="{{asset('logo/img/icon/upload_file.svg')}}" alt="Upload Icon">
                                </div>
                                <p>Insira ou arrasta</p>
                                <input type="file" id="file-upload" class="hidden" name="documento_path"/>
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
                        <div class="">
                            <div class="form-group">
                                <label for="recipient">Tipo de documento</label>
                                <div class="destinatário">
                                    <span>{{ $documentRequest->tipo_documento}}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient">Finalidade do documento</label>
                                <div class="destinatário">
                                    <span>{{$documentRequest->finalidade ?? 'Não especificado'}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias select_in_view">
                            <div class="">
                                <label for="description" class="description_label">Prazo de entrega</label>
                                <div class="">
                                <div class="destinatário" style="width: 110px;  padding: 0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ \Carbon\Carbon::parse($documentRequest->prazo_entrega)->format('d/m/Y') }}</span>
                                </div>
                                </div>
                            </div>
                            <div>
                                <label for="document_type">Forma de entrega</label>
                                <div class="destinatário" style="width: 208px;  padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $documentRequest->forma_entrega }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!empty($documentRequest->observacoes))
                            <div class="container_obs_desc">
                                <span>Observações</span>
                                <span style="background: #f3f3f3;">{{ $documentRequest->observacoes}}</span>
                            </div>
                        @else
                        @endif
                        
                        <div class="aprovacao_container_justificativos aprovacao_container_injustificada">
                        @if(!empty($documentRequest->observacoes_admin))
                            <div class="container_obs_desc">
                                <span>Observações</span>
                                <span style="background: #fff;">{{ $documentRequest->observacoes_admin}}</span>
                            </div>
                        @else
                        @endif
                           
                                
                                
                                    @if(($documentRequest->status === 'pendente'))
                                        @can('app.dashboard')
                                    
                                            <div class="form-group mySelectAusencias">
                                                <label for="document_type">Adicionar observação</label>
                                                <input type="text" name="observacoes_admin" class="form-injustificada-input">
                                                @if($documentRequest->status === 'pendente')
                                @can('app.dashboard')
                                <div class="ausencias_container_btn">
                                    <!-- Botão Rejeitar -->
                                    <button type="submit" id="btnAprovar" class="btnAprovar">Enviar</button>
                                </div>
                                @endcan
                                @else
                          
                                @endif
                                            </div>
                                        @endcan
                                    @else
                                       
                                    @endif
                                   
                                <!-- Botões de Aprovar e Rejeitar -->
                                
                               
                                
                                </form>
                        </div>

                    </div>
                  
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

</script>
@endsection