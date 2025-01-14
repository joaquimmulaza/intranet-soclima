@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
<div class="container-fluid">
        <div class="row mb-2 justify-content-between">
            <div class="">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências</li>
                </ol>
            </div>
    </div>
</div>
<hr>
<div class="main_container manager_doc">
            <div class="detail_user_justificativo">
                <div>
                    <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt="">
                </div>
                <div class="content_detail_user_justificativo">
                    <span class="content_detail_user_name">{{  $ausencia->user->name  }} </span>
                    <div class="content_detail_user_work">
                        <span>{{  $ausencia->user->unidade->titulo  }} </span>|<span> {{$ausencia->user->cargo->titulo  }}</span>
                    </div>
                </div>
            </div>
            <!-- <a href="#">Gerenciar</a> -->
        </div>
<div class="main_container doc_container content_ausencia visible" id="content-justificada">
        
                <div class="form_ausencias">
                    <div class="form-group">
                        <!-- Área de Drop e Seleção de Arquivo -->
                        <div class="drop-area_docs" id="drop-area_docs">
                            <div class="drop-icon">
                                <img src="{{asset('logo/img/icon/view_file.svg')}}" alt="Upload Icon">
                            </div>
                            <p>Visualizar ficheiro</p>
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
                            <label for="recipient">Tipo de falta</label>
                            <div class="destinatário">
                                <span>{{ $ausencia->tipo_falta}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Tipo de registo</label>
                            <div class="destinatário">
                                <span>{{ $ausencia->tipo_registo }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Motivo</label>
                            <div class="destinatário">
                                <span>{{ $ausencia->motivo }}</span>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias">
                            <label for="document_type">Data que faltou</label>
                            <div class="destinatário" style="width: 208px;  padding:0;">
                            <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->data_inicio->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mySelectAusencias">
                            <label for="document_type">Adicionar observação</label>
                            <input type="text" name="motivo" class="form-injustificada-input">
                        </div>
                        
                     
                        <div class="ausencias_container_btn">
                            <button type="button">Rejeitar</button>
                            <button type="submit" id="justificar-injustificada">Aprovar</button>
                        </div>
                    </div>
                </div>
        </div>
      
        <div>
            @if($ausencia->arquivo_comprovativo)
                <div id="pdfViewer"></div>
            @else
                <p>Nenhum arquivo comprovativo enviado.</p>
            @endif
        </div>
  
        <!-- Adicionando PDF.js --> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($ausencia->arquivo_comprovativo)
            const url = "{{ asset('storage/' . $ausencia->arquivo_comprovativo) }}";
            const pdfjsLib = window['pdfjs-dist/build/pdf'];

            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    const scale = 1.5;
                    const viewport = page.getViewport({ scale: scale });

                    const canvas = document.createElement('canvas');
                    document.getElementById('pdfViewer').appendChild(canvas);
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            });
        @endif
    });
</script>
@endsection
