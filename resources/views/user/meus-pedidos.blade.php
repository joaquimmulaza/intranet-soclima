@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')

<style>
/* Overlay Manual */
.custom-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    display: none;
}

/* Ajustes para o Modal */
.modalFeriasResumo {
    height: 100% !important;
    overflow: hidden !important;
    z-index: 1500 !important;
}

.modal-dialog {
    z-index: 1600 !important;
}

.modal-content {
    z-index: 1700 !important;
}

/* Desativa o bac kdrop padrão do Bootstrap */
.modal-backdrop {
    display: none !important;
}
</style>

{{-- CABEÇALHO BREADCRUMB --}}
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

<div class="main_container docs_container" style="">
    <hr class="custom_hr_justificativos">
    @forelse($feriasUsuario as $feria) 
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
                    <td class="td_font">{{ $feria->data_inicio }} a {{$feria->data_fim}}</td>
                    <td class="td_font">
                        @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                            {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                        @else
                            {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dias
                        @endif
                    </td>
                    <td class="td_font">{{ $feria->data_retorno_prevista }}</td>
                    <td class="data_documents td_tipo_registo_justificativos" style="padding: 0; margin-left: 0;">
                        @if($feria->observacao)
                        <div class="observacao-icon-container" style="bottom: 6px;">
                            <img src="{{ asset('logo/img/icon/OBS_Icon_true.svg') }}" alt="Ícone Observação" class="observacao-icon blinking">
                            <div class="tooltip">
                                <div class="tooltip-header">
                                    @if($feria->responsavel && $feria->responsavel->avatar)
                                        <img src="{{ URL::to('/') }}/public/avatar_users/{{ $feria->responsavel->avatar }}" alt="Foto de perfil" class="tooltip-user-photo">
                                    @else
                                        <img src="{{ asset('logo/img/icon/default-avatar.jpg') }}" alt="Foto de perfil" class="tooltip-user-photo">
                                    @endif
                                    <div class="tooltip-user-info">
                                        <strong>{{ $feria->responsavel->name }}</strong>
                                        <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="1.7998" cy="2" r="1.5" fill="#D9D9D9"/>
                                        </svg>
                                        <span class="tooltip-time">{{ $feria->updated_at->diffForHumans()}}</span>
                                    </div>
                                </div>
                                <p>{{ ucfirst($feria->observacao) }}</p>
                            </div>
                        </div>
                        @endif
                    </td>
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
                                    <form id="delete-form-{{$feria->id}}" action="{{ route('ferias.destroy', $feria->id) }}"  method="POST" style="display: none;" class="btn-popup hidden">
                                    @csrf()
                                    @method('DELETE')
                                    </form>
                                        <button class="btnPosts btnOptFerias btnPostsDelete" type="button" data-id="{{$feria->id}}"  data-action="cancelar">Cancelar pedido</button>
                                    @else
                                    <form id="delete-form-{{$feria->id}}" action="{{ route('ferias.destroy', $feria->id) }}"  method="POST" style="display: none;" class="btn-popup hidden">
                                    @csrf()
                                    @method('DELETE')
                                    </form>
                                        <button class="btnPosts btnOptFerias btnPostsDelete" type="button" data-id="{{$feria->id}}" data-action="eliminar">Eliminar</button>
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
    </div>
    @empty
    <style>
        .main_container{
            background: none !important;
        }
        .custom_hr_justificativos{
            display: none !important;
        }
    </style>
    <div class="text-center containerEmptyPage">
        <img src="{{asset('logo/img/icon/holiday_icon.svg')}}" alt="">
        <h1 class="titleEmptyPage">De momento não há solicitações de férias</h1>
        <p class="sentenceEmptyPage">As solicitações de férias que você solicitou serão exibidas aqui assim que forem aprovadas.</p>
    </div>
    @endforelse
</div>

<!-- Modais movidos para fora do main_container -->
@foreach($feriasUsuario as $feria)
    <!-- Modal Resumo -->
    <div class="modal fade modalFeriasResumo" id="modalFeriasResumo-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalTesteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTesteLabel">Resumo da solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">
                            <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <p>Dias úteis a gozar:
                            @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                            @else
                                {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dias
                            @endif
                        </p>
                        <p>Data de retorno prevista: {{ $feria->data_retorno_prevista }}</p>
                        @if($feria->status == 'Pendente')
                            <p>Status do pedido: <strong>Pendente de aprovação!</strong></p>
                            <p class="corNota">Nota: O seu pedido será analisado pelo departamento de Recursos Humanos. Assim que for aprovado, receberá uma notificação.</p>
                        @elseif($feria->data_fim < date('Y-m-d'))
                            <p>Status do pedido: <strong>{{$feria->status}}</strong></p>
                            <p class="corNota">Nota: Férias gozadas</p>
                        @elseif($feria->status == 'Rejeitado')
                            <p>Status do pedido: <strong>{{$feria->status}}</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endforeach

<!-- Overlay Manual -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Função para mostrar/esconder o overlay
function toggleOverlay(show) {
    const overlay = $('#customOverlay');
    if (show) {
        overlay.fadeIn(200);
    } else {
        overlay.fadeOut(200);
    }
}

// Controle dos modais
$('.modalFeriasResumo').on('show.bs.modal', function () {
    toggleOverlay(true);
    $('body').addClass('modal-open');
});

$('.modalFeriasResumo').on('hidden.bs.modal', function () {
    toggleOverlay(false);
    $('body').removeClass('modal-open');
});

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

// Fechar modal ao clicar fora
$(document).on('click', function (event) {
    const $modal = $('.modal');
    if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length && !$(event.target).hasClass('more_opt')) {
        $modal.modal('hide');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btnPostsDelete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();

            const documentId = this.getAttribute('data-id');
            const actionType = this.getAttribute('data-action');

            // Textos dinâmicos
            const mensagens = {
                cancelar: {
                    titulo: 'Cancelar pedido',
                    texto: 'Podes cancelar este pedido e fazer um novo antes que seja aprovado pelo DRH e o chefe de departamento.',
                    confirm: 'Sim',
                },
                eliminar: {
                    titulo: 'Eliminar',
                    texto: 'Tem certeza que queres eliminar este registo da lista?',
                    confirm: 'Sim',
                }
            };

            const msg = mensagens[actionType] || mensagens['eliminar'];

            Swal.fire({
                title: msg.titulo,
                text: msg.texto,
                showCancelButton: true,
                confirmButtonColor: '#fff',
                cancelButtonColor: '#fff',
                confirmButtonText: msg.confirm,
                cancelButtonText: 'Não',
                customClass: {
                    confirmButtonColor: 'deleteButton_alert',
                    cancelButtonColor: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                }
            }).then((result) => {
                if (result.isConfirmed) {
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
            if (!response.ok) throw new Error('Erro na requisição');
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: data.message,
                timer: 6000,
                position: "bottom-start",
                imageUrl: "{{ asset('logo/img/icon/verified.gif') }}",
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
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            Swal.fire('Erro!', 'Houve um problema ao excluir o documento.', 'error');
        });
    }
});
</script>

@endsection