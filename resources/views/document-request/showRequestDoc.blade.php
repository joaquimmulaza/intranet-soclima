@extends('master.layout')
@section('content')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2 justify-content-between">
            <div class="">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Documentos solicitados</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
    <div class="main_container manager_doc">
        <div class="detail_user_justificativo">
            <div class="container_detail_user_justificativo">
                <span class="globla_status_style {{ $documentRequest->status }}">{{ $documentRequest->status === 'concluído' ? 'Pronto' : $documentRequest->status }}</span>
                <div>
                    <img src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="">
                </div>
                <div class="content_detail_user_justificativo">
                    <span class="content_detail_user_name">{{ $documentRequest->user->name }}</span>
                    <div class="content_detail_user_work">
                        <span>{{ $documentRequest->user->unidade->titulo }}</span> | <span>{{ $documentRequest->user->cargo->titulo }}</span>
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
    <div class="main_container doc_container content_ausencia visible
    @if($documentRequest->documento_path && $documentRequest->status === 'concluído')
        showDocumentRequest
    @else
    @endif
    " id="content-justificada">
        <!-- Botão para visualizar o PDF -->
@if($documentRequest->documento_path && $documentRequest->status === 'concluído')
    <div class="drop-area_docs" data-toggle="modal" data-target="#modalJustificativo" id="drop-area_docs">
        <div class="drop-icon">
            <img src="{{ asset('logo/img/icon/view_file.svg') }}" alt="Upload Icon">
        </div>
        <p>Visualizar ficheiro</p>
    </div>

    
    @else
@endif

        <div class="form_ausencias">
            <form method="POST" action="{{ route('admin.document-request.upload', $documentRequest->id) }}" style="display: flex; gap: 36px;">
                @csrf
                <div class="document-inputs">
                    <div class="">
                        <div class="form-group">
                            <label for="recipient">Tipo de documento</label>
                            <div class="destinatário">
                                <span>{{ $documentRequest->tipo_documento }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Finalidade do documento</label>
                            <div class="destinatário">
                                <span>{{ $documentRequest->finalidade ?? 'Não especificado' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mySelectAusencias select_in_view">
                        <div class="">
                            <label for="description" class="description_label">Prazo de entrega</label>
                            <div class="">
                                <div class="destinatário" style="width: 110px; padding: 0;">
                                    <span style="width: 208px; text-align: center; padding:0;">{{ \Carbon\Carbon::parse($documentRequest->prazo_entrega)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="document_type">Forma de entrega</label>
                            <div class="destinatário" style="width: 208px; padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $documentRequest->forma_entrega }}</span>
                            </div>
                        </div>
                    </div>
                    @if(!empty($documentRequest->observacoes))
                        <div class="container_obs_desc">
                            <span>Observações</span>
                            <span style="background: #f3f3f3;">{{ $documentRequest->observacoes }}</span>
                        </div>
                    @endif
                    <div class="aprovacao_container_justificativos aprovacao_container_injustificada" style="padding-right: 80px !important;">
                        @if(!empty($documentRequest->observacoes_admin))
                            <div class="container_obs_desc">
                                <span>Observações</span>
                                <span style="background: #fff;">{{ $documentRequest->observacoes_admin }}</span>
                            </div>
                        @endif
                        @if($documentRequest->status === 'pendente')
                            @can('app.dashboard')
                                <div class="form-group mySelectAusencias" style="margin: 0 auto;">
                                <div class="mb-3">
                                    <label for="salario_base" class="form-label">Adicionar salário base*</label>
                                    <input type="text" id="salario_base" name="salario_base" class="form-control" placeholder="" required>
                                </div>
                                    <label for="observacoes_admin">Adicionar observação</label>
                                    <input type="text" name="observacoes_admin" class="form-injustificada-input">
                                    <div class="ausencias_container_btn">
                                    <!-- Botão para gerar o documento -->
                                    <button type="submit" id="btnAprovar" class="btnAprovar" style="background-color: #009AC1; color: #fff;">Enviar</button>
                                </div>
                                </div>
                                
                            @endcan
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para visualização do PDF -->
<div class="modal escurecer fade modalJustificativo" id="modalJustificativo" tabindex="-1" aria-labelledby="modalJustificativoLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container_popUp_Justificativo">
                        <div class="testando">
                            <div class="modal-header modal_header_justificativos">
                                <div class="modal_header_justificativos_content">
                                    <!-- Botão de download -->
                                    <a href="{{ route('downloadDocument', $documentRequest->id) }}" class="btn_download" download>
                                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 6.45833C0 2.89149 2.89149 0 6.45833 0H24.5417C28.1085 0 31 2.89149 31 6.45833V24.5417C31 28.1085 28.1085 31 24.5417 31H6.45833C2.89149 31 0 28.1085 0 24.5417V6.45833Z" fill="white"/>
                                            <path d="M23.2498 19.3748V23.2498H7.74984V19.3748H5.1665V23.2498C5.1665 24.6707 6.329 25.8332 7.74984 25.8332H23.2498C24.6707 25.8332 25.8332 24.6707 25.8332 23.2498V19.3748H23.2498ZM21.9582 14.2082L20.1369 12.3869L16.7915 15.7194V5.1665H14.2082V15.7194L10.8628 12.3869L9.0415 14.2082L15.4998 20.6665L21.9582 14.2082Z" fill="#009AC1"/>
                                        </svg>
                                    </a>
                                    <!-- Botão de fechar -->
                                    <button type="button" class="" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">
                                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 6.45833C0 2.8915 2.89149 0 6.45833 0H24.5417C28.1085 0 31 2.89149 31 6.45833V24.5417C31 28.1085 28.1085 31 24.5417 31H6.45833C2.8915 31 0 28.1085 0 24.5417V6.45833Z" fill="white"/>
                                                <path d="M24.5418 8.27975L22.7206 6.4585L15.5002 13.6789L8.27975 6.4585L6.4585 8.27975L13.6789 15.5002L6.4585 22.7206L8.27975 24.5418L15.5002 17.3214L22.7206 24.5418L24.5418 22.7206L17.3214 15.5002L24.5418 8.27975Z" fill="#009AC1"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- Exibir o PDF -->
                            <div id="pdfViewer" class="zoom-image" onclick="toggleZoom(this)"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Adicionando PDF.js --> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js"></script>
<script>
        $(document).on('click', function (event) {
            const $modal = $('.modalJustificativo');
            if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
                $modal.modal('hide');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const url = "{{ asset('storage/' . $documentRequest->documento_path) }}";
            console.log('URL do PDF:', url);
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
            }).catch(function(error) {
                console.error('Erro ao carregar o PDF:', error);
                document.getElementById('pdfViewer').innerHTML = '<p>Erro ao carregar o PDF.</p>';
            });
        });

        function toggleZoom(element) {
            element.classList.toggle('zoomed');
        }
    </script>
@endsection