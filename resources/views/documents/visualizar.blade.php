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
        <div class="container_detail_user_justificativo">
            <span class="globla_status_style {{ $ausencia->status }}">{{  $ausencia->status }}</span>
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
    </div>
    @if($ausencia->user->role_id == 1)
    <a href="{{ route('documents.show') }}" class="globalBtn_with_border right_side">Voltar</a>
    @else
    <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar em Ausências</a>
    @endif
   
    

    
</div>
<div class="main_container doc_container content_ausencia visible" id="content-justificada">
        
                <div class="form_ausencias">
                    @if($ausencia->arquivo_comprovativo)
                        <div class="form-group hidden_injustificado_item">
                            <!-- Área de Drop e Seleção de Arquivo -->
                            <div class="drop-area_docs" data-toggle="modal" data-target="#modalJustificativo"  id="drop-area_docs">
                                <div class="drop-icon">
                                    <img src="{{asset('logo/img/icon/view_file.svg')}}" alt="Upload Icon">
                                </div>
                                <p>Visualizar ficheiro</p>
                                <!-- <input type="file" id="file-upload" name="arquivo_comprovativo"  /> -->
                            </div>
                            <!-- Cartão de Upload com a Barra de Progresso -->
                            <!-- <div class="upload-card"  id="upload-card" style="display: none;">
                                <div class="upload-icon">
                                <img src="logo/img/icon/upload_file.svg" alt="Upload Icon">
                                    <div style="overflow: hidden; text-overflow: ellipsis; font-size: 11px;">
                                        <strong id="file-name">untitled</strong>
                                    </div>
                                </div> 
                                <span class="close-btn" ><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#555555"/>
                                </svg>
                                </span>
                                <div class="progress-container">
                                    <div class="progress-bar" id="progress-bar"></div>
                                </div>
                            </div> -->
                        </div>
                        <div class="document-inputs">
                        <div class="">
                            <div class="form-group">
                                <label for="recipient">Tipo de falta</label>
                                <div class="destinatário">
                                    <span>{{ $ausencia->tipo_falta}}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient">Motivo</label>
                                <div class="destinatário">
                                    <span>{{ $ausencia->motivo }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient">Tipo de registo</label>
                            <div class="destinatário">
                                <span>{{ $ausencia->tipo_registo }}</span>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias select_in_view">
                            <div>
                                <label for="document_type">Data que faltou</label>
                                <div class="destinatário" style="width: 208px;  padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->data_inicio->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            @if($ausencia->horas)
                            <div class="">
                                <label for="description" class="description_label">Faltou apenas</label>
                                <div class="">
                                <div class="destinatário" style="width: 110px;  padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->horas}} horas</span>
                                </div>
                                </div>
                            </div>
                            @else
                            @endif
                            

                            
                            
                        </div>
                        <div class="aprovacao_container_justificativos aprovacao_container_injustificada">
                            <form  action="{{ route('ausencias.aprovarRejeitar', $ausencia->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Usar o PUT, já que estamos atualizando o status -->
                            
                                <!-- Campo de Observação -->

                                
                                    @if(($ausencia->status === 'Pendente'))
                                    @can('app.dashboard')
                                    <div class="form-group mySelectAusencias">
                                        <label for="document_type">Adicionar observação</label>
                                        <input type="text" name="observacao" class="form-injustificada-input">
                                    </div>
                                    @endcan
                                    @elseif(!empty($ausencia->observacao))
                                        <div class="container_obs_desc">
                                            <span>A tua observação</span>
                                            <span>{{ $ausencia->observacao}}</span>
                                        </div>
                                    @else
                                    <div class="container_obs"><span class="text_sem_obs">Sem observação adicionada!</span></div>
                                    @endif
                                   
                                <!-- Botões de Aprovar e Rejeitar -->
                                
                                @if($ausencia->status === 'Pendente')
                                @can('app.dashboard')
                                <div class="ausencias_container_btn">
                                    <!-- Botão Rejeitar -->
                                    <button type="button" id="btnRejeitar" class="btnRejeitar">Rejeitar</button>
                                    <!-- Botão Aprovar -->
                                    <button type="submit" id="btnAprovar" class="btnAprovar">Aprovar</button>
                                </div>
                                @endcan
                                @else
                          
                                @endif
                                
                            </form>
                        </div>

                        <!-- <div class="form-group mySelectAusencias">
                            <label for="document_type">Adicionar observação</label>
                            <input type="text" name="observacao" class="form-injustificada-input">
                        </div>
                        
                     
                        <div class="ausencias_container_btn">
                            <button type="button">Rejeitar</button>
                            <button type="submit" id="justificar-injustificada">Aprovar</button>
                        </div> -->
                    </div>
                    @else
                    <div class="document-inputs">
                        <div class="inputs_no_dropUpload">
                            <div class="form-group">
                                <label for="recipient">Tipo de falta</label>
                                <div class="destinatário">
                                    <span>{{ $ausencia->tipo_falta}}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient">Motivo</label>
                                <div class="destinatário">
                                    <span>{{ $ausencia->motivo }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="inputs_no_dropUpload">
                            <div class="form-group">
                                <label for="recipient">Tipo de registo</label>
                                <div class="destinatário">
                                    <span>{{ $ausencia->tipo_registo }}</span>
                                </div>
                            </div>
                            <div class="form-group mySelectAusencias inputs_no_dropUpload select_in_view ">
                            @if($ausencia->descontar_nas_ferias || $ausencia->horas)
                                <div>
                                    <label for="document_type">Data que faltou</label>
                                    <div class="destinatário" style="width: 145.94px;  padding:0;">
                                    <span style="width: 145.94px; text-align: center; padding:0;">{{ $ausencia->data_inicio->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @else
                            <div>
                                    <label for="document_type">Data que faltou</label>
                                    <div class="destinatário" style="width: 208px;  padding:0;">
                                    <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->data_inicio->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if( $ausencia->horas)
                                <div class="">
                                    <label for="description" class="description_label">Faltou apenas</label>
                                    <div class="">
                                    <div class="destinatário" style="width: 90px;  padding:0;">
                                    <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->horas}} horas</span>
                                    </div>
                                    </div>
                                </div>
                                    @if($ausencia->descontar_nas_ferias)
                                        <div class="">
                                            <label for="description" class="description_label">Subtrair nas férias anuais</label>
                                            <div class="">
                                            <div class="destinatário" style="width: 110px;  padding:0;">
                                            <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->descontar_nas_ferias}}</span>
                                            </div>
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                @else
                                @if($ausencia->descontar_nas_ferias)
                                        <div class="">
                                            <label for="description" class="description_label">Subtrair nas férias anuais</label>
                                            <div class="">
                                            <div class="destinatário" style="width: 100%;  padding:0;">
                                            <span style="width: 208px; text-align: center; padding:0;">{{ $ausencia->descontar_nas_ferias}}</span>
                                            </div>
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                @endif
                                
                            
                            </div>
                        </div>
                        
                        <div class="aprovacao_container_justificativos">
                            <div class="|">
                                <form action="{{ route('ausencias.aprovarRejeitar', $ausencia->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Usar o PUT, já que estamos atualizando o status -->
                            
                                    <!-- Campo de Observação -->
                                    
                                    @if(($ausencia->status === 'Pendente'))
                                    @can('app.dashboard')
                                    <div class="form-group mySelectAusencias">
                                        <label for="document_type">Adicionar observação</label>
                                        <input type="text" name="observacao" class="form-injustificada-input">
                                    </div>
                                    @endcan
                                    @elseif(!empty($ausencia->observacao))
                                        <div class="container_obs_desc">
                                            <span>A tua observação</span>
                                            <span>{{ $ausencia->observacao}}</span>
                                        </div>
                                    @else
                                    <div class="container_obs"><span class="text_sem_obs">Sem observação adicionada!</span></div>
                                    @endif
                                    
                                    <!-- Botões de Aprovar e Rejeitar -->
                                    @if($ausencia->status === 'Pendente')
                                    @can('app.dashboard')
                                    <div class="ausencias_container_btn">
                                        <!-- Botão Rejeitar -->
                                        <button type="button" id="btnRejeitar" class="btnRejeitar">Rejeitar</button>
                                        <!-- Botão Aprovar -->
                                        <button type="submit" id="btnAprovar" class="btnAprovar">Aprovar</button>
                                    </div>
                                    @endcan
                                    @else
                                    @endif
                                </form>
                            </div>
                        </div>

                        <!-- <div class="form-group mySelectAusencias">
                            <label for="document_type">Adicionar observação</label>
                            <input type="text" name="observacao" class="form-injustificada-input">
                        </div>
                        
                     
                        <div class="ausencias_container_btn">
                            <button type="button">Rejeitar</button>
                            <button type="submit" id="justificar-injustificada">Aprovar</button>
                        </div> -->
                    </div>
                    @endif
                    
                </div>
                
        </div>

        <div class="modal escurecer fade modalJustificativo" id="modalJustificativo" tabindex="-1" aria-labelledby="modalJustificativoLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                    <div class="container_popUp_Justificativo">
                    <div class="testando">
                        <div class="modal-header modal_header_justificativos">
                        <div class="modal_header_justificativos_content">
                            <a href="{{ route('downloadFile', $ausencia->id) }}">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 6.45833C0 2.89149 2.89149 0 6.45833 0H24.5417C28.1085 0 31 2.89149 31 6.45833V24.5417C31 28.1085 28.1085 31 24.5417 31H6.45833C2.89149 31 0 28.1085 0 24.5417V6.45833Z" fill="white"/>
                                <path d="M23.2498 19.3748V23.2498H7.74984V19.3748H5.1665V23.2498C5.1665 24.6707 6.329 25.8332 7.74984 25.8332H23.2498C24.6707 25.8332 25.8332 24.6707 25.8332 23.2498V19.3748H23.2498ZM21.9582 14.2082L20.1369 12.3869L16.7915 15.7194V5.1665H14.2082V15.7194L10.8628 12.3869L9.0415 14.2082L15.4998 20.6665L21.9582 14.2082Z" fill="#009AC1"/>
                                </svg>
                            </a>
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
                            @if($ausencia->arquivo_comprovativo)
                                <div id="pdfViewer" class="zoom-image"
                                onclick="toggleZoom(this)"></div>
                        
                            @else
                                <p>Nenhum arquivo comprovativo enviado.</p>
                            @endif
                            </div>
                    </div>
                        
                </div>
            </div>
        </div>
        <div>
                           
                            </div>
                        </div>
      
        
  
        <!-- Adicionando PDF.js --> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js"></script>


<script>
    $('.modalJustificativo').on('show.bs.modal', function () {
        $('body').addClass('modal-open-no-backdrop');
    });

    $('.modalJustificativo').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open-no-backdrop');
    });

    $(document).on('click', function (event) {
        const $modal = $('.modalJustificativo');
        if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
            $modal.modal('hide');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        @if($ausencia->arquivo_comprovativo)
            const url = "{{ asset('storage/' . $ausencia->arquivo_comprovativo) }}";
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
            });
        @endif
    });


//     let isDragging = false; // Rastreamento do arrasto
// let startX, startY; // Posição inicial do mouse
// let offsetX = 0, offsetY = 0; // Offset da imagem

// // Função para alternar o zoom
// function toggleZoom(image) {
//   if (!image.classList.contains('zoom-active')) {
//     image.classList.add('zoom-active');
//     image.style.transform = 'scale(3) translate(0, 0)'; // Garante o zoom inicial centralizado
//   } else {
//     image.classList.remove('zoom-active');
//     resetPosition(image); // Reseta a posição ao desativar o zoom
//   }
// }

// // Reseta a posição da imagem ao desativar o zoom
// function resetPosition(image) {
//   image.style.transform = 'scale(1) translate(0, 0)';
//   offsetX = 0;
//   offsetY = 0;
// }

// // Adiciona eventos para arrastar a imagem
// const image = document.querySelector('.zoom-image');

// image.addEventListener('mousedown', (e) => {
//   if (image.classList.contains('zoom-active')) {
//     isDragging = true;
//     startX = e.clientX - offsetX;
//     startY = e.clientY - offsetY;
//     image.style.cursor = 'grabbing';
//   }
// });

// image.addEventListener('mousemove', (e) => {
//   if (isDragging) {
//     e.preventDefault(); // Evita seleção de texto
//     offsetX = e.clientX - startX;
//     offsetY = e.clientY - startY;
//     image.style.transform = `scale(3) translate(${offsetX}px, ${offsetY}px)`;
//   }
// });

// image.addEventListener('mouseup', () => {
//   isDragging = false;
//   image.style.cursor = 'grab';
// });

// image.addEventListener('mouseleave', () => {
//   if (isDragging) {
//     isDragging = false;
//     image.style.cursor = 'grab';
//   }
// });

document.getElementById('btnRejeitar').addEventListener('click', function() {
    // Adiciona o valor 'rejeitada' ao campo de status
    var form = this.closest('form');
    var statusInput = document.createElement('input');
    statusInput.setAttribute('type', 'hidden');
    statusInput.setAttribute('name', 'status');
    statusInput.setAttribute('value', 'Rejeitado');
    form.appendChild(statusInput);

    // Enviar o formulário
    form.submit();
});


document.getElementById('btnAprovar').addEventListener('click', function() {
    // Adiciona o valor 'aprovada' ao campo de status
    var form = this.closest('form');
    var statusInput = document.createElement('input');
    statusInput.setAttribute('type', 'hidden');
    statusInput.setAttribute('name', 'status');
    statusInput.setAttribute('value', 'Aprovado');
    form.appendChild(statusInput);

    // Enviar o formulário
    form.submit();
});


</script>
@endsection
