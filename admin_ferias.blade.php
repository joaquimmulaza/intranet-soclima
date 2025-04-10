@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')
<style>
.modalMain .modalFeriasResumo{
   height: 595px !important;
   overflow: hidden !important;
}

.modalMain .modalRejeitar{
   height: 995px !important;

   overflow: hidden !important;
}


.modalRejeitar .modal-content{
    padding: 24px;
    width: 549px;
    margin: 0 auto;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
}

.modalRejeitar .modal-header{
    padding: 0;
    padding-bottom: 13px;
}

.modalRejeitar .modal-body{
    padding: 0;
    padding-top: 20px;
}

.modalRejeitar .modal-body label{
    font-size: 14px;
    color: #555;
    font-weight: 400 !important;
}

.modalRejeitar .modal-body textarea{
    width: 100%;
    border-radius: 5px !important;
    margin-top: 12px;
}

.modalRejeitar .modal-footer{
    padding: 0;
    padding-top: 20px;
    border-top: none;
}

.modalRejeitar .modal-footer button{
    padding: 8px 20px;
    background: #009AC1;
    color: #fff;
    border-radius: 5px;
    border: none;
    outline: none;
    margin: 0 !important;
    opacity: 0.2;
}

.modalRejeitar .modal-title{
    color: #555;
    font-size: 20px;
    font-weight: bold;
}

.td_font{
    font-size: 11px;
}
</style>

{{-- CABEÇALHO BREADCRUMB--}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                @if($user->role_id == 2)
                    <li class="breadcrumb-item active">Suas solicitações de férias</li>
                @else
                    <li class="breadcrumb-item active">Gerenciar pedidos de férias</li>
                @endif
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="containerPrincipal">

        
        
                <div class="main_container docs_container">
                <hr class="custom_hr_justificativos">
                @foreach($ferias as $feria) 
        <div class="view_justificativos view_ferias">
    
            <table class="docs_table table_ferias">
                <thead>
                    <tr>
                    <th class="">Status</th>
                    <th class="">Nome do trabalhador</th>
                    <th class="">Período solicitado</th>
                    <th class="">Dias úteis a gozar</th>
                    <th class="">Data Retorno Prevista</th>
                    </tr>
                </thead>
                
                <tbody data-toggle="modal" data-target="#modalFeriasResumo-{{ $feria->id }}">
                    <tr>
                        <td class="">
                            <span class="{{ $feria->status }}">{{ $feria->status }}</span>
                        </td>
                        <td class=""> 
                            @if ($feria->user)
                                {{ $feria->user->name }}
                            @else
                                Usuário não encontrado
                            @endif
                        </td>
                        <td class="td_font">{{ $feria->data_inicio }} a {{ $feria->data_fim }}</td>
                        <td class="td_font">
                            @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                            @else
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dias
                            @endif
                        </td>
                        <td class="td_font">{{ $feria->data_retorno_prevista }}</td>
                        <td class="OptDocs">
                        <div class="containerOpt containerOptFerias">
                <button class="more_opt btn-popup" data-toggle="modal" data-target="#modalOptPhone-{{ $feria->id }}" style="margin: 0 !important; padding: 0 !important;">
                    <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                </button>
                <div class="modal modalHidden fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body modal-bodyOpt">
                                <div class="containerBtnOpt_justificativos">
                                @if($feria->status == 'Pendente' && $user->id == $feria->user_id)
                                
                                    @else
                                    
                                    <form id="delete-form-{{$feria->id}}" action="{{ route('ferias.destroy', $feria->id) }}"  method="POST" style="display: none;" class="btn-popup hidden">
                                    @csrf()
                                    @method('DELETE')
                                    </form>
                                        <button class="btnPosts btnOptFerias btnPostsDelete" type="submit" data-id="{{$feria->id}}">Eliminar</button>
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

    <div style="margin-bottom: 20px;"></div>

    @endforeach
</div>


@foreach($ferias as $feria) 
<div class="modalMain">
    
    <!-- Modal para cada item dentro do loop -->
    <div class="modal fade modalFeriasResumo" id="modalFeriasResumo-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalTesteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTesteLabel">Resumo da solicitação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true"><svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.3667 6.41L18.9226 5L13.197 10.59L7.47153 5L6.02734 6.41L11.7529 12L6.02734 17.59L7.47153 19L13.197 13.41L18.9226 19L20.3667 17.59L14.6412 12L20.3667 6.41Z" fill="#555555"/>
                            </svg>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="container_body_resumo_ferias">
                            <div class="content_header_resumo_ferias">
                                <img src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}" alt="">
                                <div class="cargo_resumo_ferias">
                                    <h3>{{$feria->user->name ?? null}}</h3>
                                    <span>{{$feria->user->unidade->titulo ?? null}}</span>
                                    <span>{{$feria->user->cargo->titulo ?? null}}</span>
                                </div>
                            </div>
                            <p>Período solicitado:</p>
    
                            <div class="datas_resumo_ferias">
                                <span>{{$feria->data_inicio ?? null}}</span>
                                a
                                <span>{{$feria->data_fim ?? null}}</span>
                            </div>
                            <p>Dias utéis a gozar:
                                @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                                    {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                                @else
                                    {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dias
                                @endif
                            </p>
                            <p>Data de retorno prevista: {{ $feria->data_retorno_prevista }}</p>
                            @if($feria->status == 'Pendente')
                                <p>
                                    Status do pedido: <strong>Pendente de aprovação!</strong>
                                </p>
                                <p class="corNota">Nota: O seu pedido será analisado pelo departamento de Recursos Humanos. Assim que for aprovado, receberá uma notificação.</p>
                            @elseif($feria->data_fim < date('Y-m-d'))
                                <p> Status do pedido: <strong>{{$feria->status}}</strong></p>
                                <p class="corNota">Nota: Férias gozadas</p>
                            @endif
                            @if($feria->status == 'Rejeitado')
                                <p>
                                    Status do pedido: <strong>{{$feria->status}}</strong>
                                </p>
                            @else
                            @endif
                       </div>
                    </div>
                    <div class="modal-footer">
                        @if($feria->status == 'Pendente')
                        <div class="btnResumeFerias">
                    
                            <a href="#">Consultar férias</a>
                            <button type="button"
                                onclick="fecharAbrirModal('{{ $feria->id }}')">
                                Rejeitar
                            </button>
                            <a href="{{ route('ferias.aprovar', $feria->id) }}">Aprovar</a>
                    
                        </div>
                        @else
                        @endif
                    </div>
               
            </div>
            </div>
           
        </div>
</div>

<!-- Modal para observação da rejeição -->
<div class="modal fade modalRejeitar" id="modalRejeitar-{{ $feria->id }}" tabindex="-1" role="dialog" aria-labelledby="modalRejeitarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" action="{{ route('ferias.rejeitar', $feria->id) }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Rejeitar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true"><svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.3668 6.41L18.9226 5L13.1971 10.59L7.47153 5L6.02734 6.41L11.7529 12L6.02734 17.59L7.47153 19L13.1971 13.41L18.9226 19L20.3668 17.59L14.6412 12L20.3668 6.41Z" fill="#555555"/>
</svg>
</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="observacao">Poderia esclarecer por que está a rejeitar?</label><br>
          <textarea name="observacao" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btnGlobal">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endforeach
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
      $('.modalOpt').on('show.bs.modal', function () {
        $('body').addClass('modal-open-no-backdrop');
    });

    $('.modalOpt').on('hidden.bs.modalHidden', function () {
        $('body').addClass('modal-open-no-backdrop');
    });

    $(document).on('click', function (event) {
        const $modal = $('.modalOpt');
        if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
            $modal.modal('hide');
        }
    });

        // Impede a propagação do evento de click no botão "Cancelar pedido" ou "Remover", mas mantém o modal de opções funcional
        document.querySelectorAll('.btnPostsDelete, .btn-popup').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });

    // Assegura que o modal `modalOpt` seja aberto
    document.querySelectorAll('.more_opt').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();  // Aqui não queremos que o clique se propague
            const targetModal = document.querySelector(button.getAttribute('data-target'));
            if (targetModal) {
                $(targetModal).modal('show');  // Usando jQuery para abrir o modal
            }
        });
    });

    
document.addEventListener('DOMContentLoaded', function () {
        // Selecionar todos os botões de exclusão
        const deleteButtons = document.querySelectorAll('.btnPostsDelete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const documentId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Eliminar',
                    text: "Tem certeza que queres eliminar este registo da lista?",
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
            fetch(`/ferias/${documentId}`, {
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

    function fecharAbrirModal(id) {
    // Fecha o modal principal
    $('#modalFeriasResumo-' + id).modal('hide');

    // Aguarda a animação do fechamento e depois abre o modal de rejeição

        $('#modalRejeitar-' + id).modal('show');

        // Quando o modal de rejeição for fechado, limpamos o estado do modal principal
        $('#modalRejeitar-' + id).on('hidden.bs.modal', function () {
            $('#modalFeriasResumo-' + id).removeClass('hide').removeData('bs.modal');
        });
}

</script>
@endsection
