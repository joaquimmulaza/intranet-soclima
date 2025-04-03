@extends('master.layout')
@section('content')

<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências > Faltas > Justificativos</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container manager_doc justify-content-end">
            <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar</a>
        </div>
        
<div class="main_container docs_container">
<hr class="custom_hr_justificativos">
@forelse ($requests as $request)
<a class="view_justificativos" href="">
    
    <table class="docs_table">
        <thead>
            <tr>
                <th style="position: relative; left: 14px;">Status</th>
                <th class="th_justificativos">Tipo de documento</th>
                <th>Solicitado por</th>
                <th>Prazo de entrega</th>
                <th class="th_tipo_registo_justificativos">Forma de entrega</th>
                <th ></th>
            </tr>
            
        </thead>
        
        <tbody>
        
            <tr>
                
                <td class="iconDocsTable">
                    
                
       
                <span class="show_when_hover globla_status_style {{ $request->status }}">{{  $request->status }}</span>
                
                </td>

                <td class="td_user_name_justificativos">

                    <div>
                    {{ $request->tipo_documento }} <br>
                        <span style="font-weight: 400; font-size: 13px;">{{ $request->finalidade }}</span>
                    </div>
                </td>
                <td class="data_documents">{{ $request->user->name }}</td>
                <td class="data_documents">{{$request->prazo_entrega}}</td>
                <td class="data_documents td_tipo_registo_justificativos">{{ ucfirst($request->forma_entrega) }}</td>
                <td class="OptDocs">
                    
                    <div class="containerOpt">
                        <!-- class .btnOpt removida -->
                        <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-" style="margin: 0 !important; padding: 0 !important;">
                            <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                        </button>
                        <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt_justificativos">
                                
                                        <form action="" method="POST" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Aprovado">
                                            <button style="border-bottom: none;border-top-right-radius: 5px;    border-top-left-radius: 5px;" type="submit" class="btnPosts ">
                                                Aprovar
                                            </button>
                                        </form>
                                        
                                        <form action="" method="POST" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Rejeitado">
                                            <button style="border-bottom: none;" type="submit" class="btnPosts">
                                                Rejeitar
                                            </button>
                                        </form>
                                        <button style="border-bottom-right-radius: 5px;    border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="">
                                                Apagar da lista
                                            </button>
                                            <form id="delete-form-"
                                                    action="" method="POST" style="display: none;" class="btn-popup">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @else
                                        <button style="border-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="">
                                                Apagar da lista
                                            </button>
                                            <form id="delete-form-"
                                                    action="" method="POST" style="display: none;" class="btn-popup">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @endif   
                                            
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</a>
    <div style="margin-bottom: 20px;"></div> <!-- Espaçamento explícito entre tabelas -->
@endforeach


</div>
<p class="info-time-doc">Faltas sem qualquer comunicação prévia serão consideradas injustificadas, caso não seja apresentado o devido justificativo</p>

<script>
    $('.modalOpt').on('show.bs.modal', function () {
        $('body').addClass('modal-open-no-backdrop');
    });

    $('.modalOpt').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open-no-backdrop');
    });

    $(document).on('click', function (event) {
        const $modal = $('.modalOpt');
        if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
            $modal.modal('hide');
        }
    });

    function deleteData(id) {
    const form = document.getElementById(`delete-form-${id}`);
    if (form) {
        form.submit();
    } else {
        console.error(`Formulário com ID delete-form-${id} não encontrado.`);
    }
}

document.querySelectorAll('.view_justificativos .btn-popup').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
    });

    function deleteData(event, id) {
    event.stopPropagation(); // Impede que o clique no botão acione o evento no <a>
    event.preventDefault(); // Opcional, caso queira evitar comportamentos padrões de envio ou navegação

    // Lógica para deletar o dado
    console.log(`Deletando dado com ID: ${id}`);
    alert(`Confirma exclusão do item ${id}?`);
    // Faça a requisição de exclusão ou qualquer outra ação aqui
}
});

document.querySelectorAll('.btnPostsDelete').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.stopPropagation(); // Impede que o clique se propague para o link pai
        event.preventDefault();   // Impede o comportamento padrão de navegação

        var id = button.getAttribute('data-id'); // Obtém o ID do atributo data-id
    
    });
});

function deleteData(id) {
    console.log('Deletando item com ID:', id); // Log para ver o ID no console
    
    // Aqui, você pode fazer a chamada AJAX ou redirecionar, dependendo de como você quer excluir o item
    // Exemplo de chamada AJAX usando fetch:
    fetch(`/ausencias/${id}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
.then(response => {
    if (response.ok) {
        return response.json(); // A resposta agora será um JSON
    } else {
        return Promise.reject('Falha ao excluir o item.'); // Caso o status não seja 2xx
    }
})
.then(data => {
    console.log('Item deletado com sucesso:', data.message);
    location.reload();
    // Aqui você pode realizar ações como remover o item da lista na UI
})
.catch(error => {
    console.error('Erro:', error);
    alert('Erro ao tentar excluir o item.');
});

}


document.addEventListener('DOMContentLoaded', function () {
        // Selecionar todos os botões de exclusão
        const deleteButtons = document.querySelectorAll('.btnPostsDelete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const documentId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apagar da lista',
                    text: "Tem certeza que deseja apagar este item da lista?",
                    showCancelButton: true,
                    confirmButtonColor: '#fff',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    customClass: {
                    confirmButtonColor: 'deleteButton_alert',
                    cancelButtonColor: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                    },	
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Fazer a requisição de exclusão via AJAX
                        deleteDocument(documentId);
                    }
                });
            });
        });

        function deleteDocument(documentId) {
            fetch(`/ausencias/${documentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: data.message,
                    timer: 6000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos',
                        
                    }
                });

                // Atualizar a página ou remover o elemento da lista
                setTimeout(() => {
                    location.reload();
                }, 1500);
            })
            .catch(error => {
                Swal.fire(
                    'Erro!',
                    'Houve um problema ao excluir o documento.',
                    'error'
                );
            });
        }
    });
</script>
@endsection
@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Documentos solicitados</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div> 
<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Tipo de Documento</th>
                <th>Forma de Entrega</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->tipo_documento }}</td>
                    <td>{{ ucfirst($request->forma_entrega) }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>
                        @if ($request->status === 'pendente')
                            <form action="{{ route('admin.document-request.upload', ['id' => $request->id])}}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="documento" class="form-control mb-2" required>
                                <button type="submit" class="btn btn-primary btn-sm">Upload Documento</button>
                            </form>
                        @endif
                        @if ($request->forma_entrega === 'fisicamente' && $request->status !== 'concluído')
                            <form action="{{ route('admin.document-request.complete', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Marcar como Concluído</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma solicitação encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $requests->links() }}
</div>
@endsection

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
            <span class="globla_status_style {{ $request->status }}">{{  $request->status }}</span>
            <div>
                <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt="">
            </div>
            <div class="content_detail_user_justificativo">
                <span class="content_detail_user_name">{{  $request->user->name  }} </span>
                <div class="content_detail_user_work">
                    <span>{{  $request->user->unidade->titulo  }} </span>|<span> {{$request->user->cargo->titulo  }}</span>
                </div>
            </div>
        </div>
    </div>
    @if($request->user->role_id == 1)
    <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar</a>
    @else
    <a href="" class="globalBtn_with_border right_side">Voltar</a>
    @endif
   
    

    
</div>
<div class="main_container doc_container content_ausencia visible" id="content-justificada">
        
                <div class="form_ausencias">
                        <div class="form-group hidden_injustificado_item">
                            <!-- Área de Drop e Seleção de Arquivo -->
                            <div class="drop-area_docs" data-toggle="modal" data-target="#modalJustificativo"  id="drop-area_docs">
                                <div class="drop-icon">
                                    <img src="{{asset('logo/img/icon/view_file.svg')}}" alt="Upload Icon">
                                </div>
                                <p>Visualizar ficheiro</p>
                                <!-- <input type="file" id="file-upload" name="arquivo_comprovativo"  /> -->
                            </div>

                        </div>
                        <div class="document-inputs">
                        <div class="">
                            <div class="form-group">
                                <label for="recipient">Tipo de documento</label>
                                <div class="destinatário">
                                    <span>{{ $request->tipo_documento}}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient">Finalidade do documento</label>
                                <div class="destinatário">
                                    <span>{{$documentRequest->finalidade ?? 'Não especificado'}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient">Prazo de entrega</label>
                            <div class="destinatário">
                                <span>{{ $request->tipo_registo }}</span>
                            </div>
                        </div>
                        <div class="form-group mySelectAusencias select_in_view">
                            <div>
                                <label for="document_type">Forma de entrega</label>
                                <div class="destinatário" style="width: 208px;  padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $documentRequest->forma_entrega }}</span>
                                </div>
                            </div>
                            <div class="">
                                <label for="description" class="description_label">Forma de entrega</label>
                                <div class="">
                                <div class="destinatário" style="width: 110px;  padding:0;">
                                <span style="width: 208px; text-align: center; padding:0;">{{ $documentRequest->forma_entrega }}</span>
                                </div>
                                </div>
                            </div>
                            

                            
                            
                        </div>
                        <div class="aprovacao_container_justificativos aprovacao_container_injustificada">
                            <form  action="" method="POST">
                                @csrf
                                @method('PUT') <!-- Usar o PUT, já que estamos atualizando o status -->
                            
                                <!-- Campo de Observação -->

                                
                                    @if(($request->status === 'pendente'))
                                    @can('app.dashboard')
                                  
                                    <div class="form-group mySelectAusencias">
                                        <label for="document_type">Adicionar observação</label>
                                        <input type="text" name="observacao" class="form-injustificada-input">
                                    </div>
                                    @endcan
                                    @elseif(!empty($request->observacoes))
                                        <div class="container_obs_desc">
                                            <span>A tua observação</span>
                                            <span>{{ $request->observacoes}}</span>
                                        </div>
                                    @else
                                    <div class="container_obs"><span class="text_sem_obs">Sem observação adicionada!</span></div>
                                    @endif
                                   
                                <!-- Botões de Aprovar e Rejeitar -->
                                
                                @if($request->status === 'pendente')
                                @can('app.dashboard')
                                <div class="ausencias_container_btn">
                                    <!-- Botão Rejeitar -->
                                    <button type="submit" id="btnAprovar" class="btnAprovar">Enviar</button>
                                </div>
                                @endcan
                                @else
                          
                                @endif
                                
                            </form>
                        </div>

                    </div>
                    @else
                    <div class="document-inputs">
                        <div class="inputs_no_dropUpload">
                            <div class="form-group">
                                <label for="recipient">Tipo de documento</label>
                                <div class="destinatário">
                                    <span>{{ $request->tipo_documento}}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient">Finalidade do documento</label>
                                <div class="destinatário">
                                    <span> {{ $documentRequest->finalidade ?? 'Não especificado' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="inputs_no_dropUpload">
                            <div class="form-group">
                                <label for="recipient">Forma de Entrega</label>
                                <div class="destinatário">
                                    <span> {{ $documentRequest->forma_entrega }}</span>
                                </div>
                            </div>
                            <div class="form-group mySelectAusencias inputs_no_dropUpload select_in_view ">
                                <div>
                                    <label for="document_type">Forma de Entrega</label>
                                    <div class="destinatário" style="width: 145.94px;  padding:0;">
                                    <span style="width: 145.94px; text-align: center; padding:0;"> {{ $documentRequest->forma_entrega }}</span>
                                    </div>
                                </div>

                          
                                
                            
                            </div>
                        </div>
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
                            <a href="{{ route('downloadFile', $request->id) }}">
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
                           
                                <div id="pdfViewer" class="zoom-image"
                                onclick="toggleZoom(this)"></div>
            
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

@extends('master.layout')
@section('content')
<div class="container">
    <h1>Detalhes do Pedido de Documento</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Informações do Pedido</h5>
            
            <p><strong>Tipo de Documento:</strong> {{ $documentRequest->tipo_documento }}</p>
            <p><strong>Finalidade:</strong> {{ $documentRequest->finalidade ?? 'Não especificado' }}</p>
            <p><strong>Forma de Entrega:</strong> {{ $documentRequest->forma_entrega }}</p>
            <p><strong>Prazo de Entrega:</strong> {{ \Carbon\Carbon::parse($documentRequest->prazo_entrega)->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ $documentRequest->status }}</p>
            <p><strong>Observações:</strong> {{ $documentRequest->observacoes ?? 'Sem observações' }}</p>
            
      
        </div>
    </div>
</div>
@endsection

<form method="POST" class="formDocs" action="" enctype="multipart/form-data">
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