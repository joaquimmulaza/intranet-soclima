@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')

<style>
.modalMain .modal{
   height: 495px !important;
   overflow: hidden !important;
}
</style>


{{-- CABEÇALHO BREADCRUMB--}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 justify-content-between">
                <ol class="breadcrumb float-sm-right" style="display: flex; align-items: center;">
                    <li class="breadcrumb-item active">Suas solicitações de férias</li>
                </ol>

                <a href="{{ route('ferias.marcar') }}" class="btnGlobalBlue" style="margin: 0 !important;">Nova Solicitação</a>
            </div>
        </div>
    </div>
    <hr>
</div>

  
    <div class="main_container docs_container">
        <hr class="custom_hr_justificativos">
        @foreach($feriasUsuario as $feria) 
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
                        <td class="">{{ $feria->data_fim }}</td>
                        <td class="">
                            @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                            @else
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dias
                            @endif
                        </td>
                        <td class="">{{ $feria->data_retorno_prevista }}</td>
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
                                    @if($feria->status === 'Pendente')
                                    <form id="delete-form-{{$feria->id}}" action="{{route('ferias.destroy', $feria->id)}}" method="POST" style="display: none;" class="btn-popup hidden">
                                    @csrf()
                                    @method('DELETE')
                                    </form>
                                        <button class="btnPosts btnOptFerias btnPostsDelete" type="submit" data-id="{{$feria->id}}">Cancelar pedido</button>
                                    @else
                                    
                                        <button style="border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;" type="button" class="btnPosts btn-popup" data-id="{{ $feria->id }}">
                                            <a href="{{ route('ferias.show', $feria->user_id) }}">
                                                Remover
                                            </a>
                                        </button>
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


@foreach($feriasUsuario as $feria) 
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
                       </div>
                    </div>
                </div>
            </div>
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
                    title: 'Cancelar pedido?',
                    text: "Podes cancelar este pedido e fazer um novo antes que seja aprovado pelo DRH e o chefe de departamento?",
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
</script>
@endsection
