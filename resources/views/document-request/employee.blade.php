@extends('master.layout')
@section('content')

<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Suas Solicitações</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
        
<div class="main_container docs_container">
<hr class="custom_hr_justificativos">
@forelse ($requests as $request)
<a class="view_justificativos">
    
    <table class="docs_table">
        <thead>
            <tr>
                <th style="position: relative; left: 14px;">Status</th>
                <th class="th_justificativos">Tipo de documento</th>
                <th style="padding-left: 36px;">Forma de entrega</th>
                <th style="padding-left: 20px;">Prazo de entrega</th>
                <th class="th_tipo_registo_justificativos">Observações</th>
                <th ></th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                
                <td class="iconDocsTableSolicitados" style="width: 100px !important; padding-left: 13px;">
                    
                <span class="{{ $request->status }}" style="width: 69px !important; display: flex; align-items: center; justify-content: center;"> 
                    @if($request->status == 'concluído')
                    Pronto
                    @else
                    Pendente
                    @endif
                </span>
                
                </td>

                <td class="" style="width: 310px !important;">
                    <div>
                        {{ $request->tipo_documento }}<br>
                        <span style="font-weight: 400; font-size: 13px;">{{ $request->finalidade }}</span>
                    </div>
                </td>
                <td class="data_documents" style=" padding-left: 36px; font-weight: 700 !important;">{{ ucfirst($request->forma_entrega) }}</td>
                <td class="data_documents" style="padding-left: 20px;">{{$request->prazo_entrega}}</td>
                <td class="data_documents td_tipo_registo_justificativos">  
                    @if($request->observacoes_admin)
                        <!-- Exibindo o ícone com fundo piscando se houver observação -->
                        <div class="observacao-icon-container">
                            <img src="{{ asset('logo/img/icon/OBS_Icon_true.svg') }}" alt="Ícone Observação" class="observacao-icon blinking">
                            <div class="tooltip">
                                    <!-- Exibindo informações do usuário que fez a observação -->
                                    <div class="tooltip-header">
                                    @if($request->admin && $request->admin->avatar)
                                        <!-- Foto do admin que enviou o documento -->
                                        <img src="{{ URL::to('/') }}/public/avatar_users/{{ $request->admin->avatar }}" alt="Foto de perfil" class="tooltip-user-photo">
                                    @else
                                        <img src="{{ asset('logo/img/icon/default-avatar.jpg') }}" alt="Foto de perfil" class="tooltip-user-photo">
                                    @endif
                                        
                                        <div class="tooltip-user-info">
                                            
                                        <strong>{{ $request->admin->name }}</strong>
                                            <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="1.7998" cy="2" r="1.5" fill="#D9D9D9"/>
                                            </svg>

                                            <span class="tooltip-time">{{ $request->updated_at->diffForHumans()}}</span>
                                        </div>
                                      <!-- Exibindo a observação -->
                                    </div>
                                    <p>{{ ucfirst($request->observacoes_admin) }}</p>
                            </div>
                    @else
                        <!-- Exibindo o ícone fixo sem fundo piscando se não houver observação -->
                        <img src="{{ asset('logo/img/icon/OBS_Icon_false.svg') }}" alt="Ícone Sem Observação" class="observacao-icon observacao-icon-false">
                    @endif
                </td>
                <td class="OptDocs">
                    
                    <div class="containerOpt">
                        <button class="more_opt btn-popup" data-toggle="modal" data-target="#modalOptPhone-{{$request->id}}" style="margin: 0 !important; padding: 0 !important;">
                            <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                        </button>
                        <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{$request->id}}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt_justificativos">
                                
                                        @if($request->status == 'concluído' && $request->documento_path)
                                        @if($request->forma_entrega == 'email')
                                        @else
                                            <button class="btnPosts">
                                            <a href="{{ route('document-request.download', $request->id) }}" style="border-bottom: none;border-top-right-radius: 5px; border-top-left-radius: 5px;" class="btnPosts">
                                                Download
                                            </a>
                                            </button>
                                       
                                        @endif
                                        @else
                                        <button style="border-bottom: none;border-top-right-radius: 5px; border-top-left-radius: 5px; opacity: 0.5; cursor: not-allowed !important;" disabled class="btnPosts btnDisabled">
                                            Download
                                        </button>
                                        @endif
                                  
                                        @if($request->status == 'concluído')
                                        <button style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsAnular" data-id="{{$request->id}}">
                                            Eliminar
                                        </button>
                                        @else
                                        
                                        <button style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsAnular" data-id="{{$request->id}}">
                                            Anular pedido
                                        </button>
                                        @endif
                                        <form id="anular-form-{{$request->id}}"
                                                action="{{route('document-request.anular', $request->id)}}" method="POST" style="display: none;" class="btn-popup">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
        <img src="{{asset('logo/img/icon/standard_solicitation.svg')}}" alt="">
        <h1 class="titleEmptyPage">Sem solicitações feitas</h1>
        <p class="sentenceEmptyPage">Aqui podera consultar os status das solicitações feitas por ti.</p>
    </div>
@endforelse

</div>

@if($requests->isNotEmpty())
    <p class="info-time-doc">Os ficheiros com status “Pronto” após download serão eliminados automaticamente.</p>
@endif

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

    document.querySelectorAll('.view_justificativos .btn-popup').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Selecionar todos os botões de anulação
        const anularButtons = document.querySelectorAll('.btnPostsAnular');

        anularButtons.forEach(button => {
            button.addEventListener('click', function () {
                const documentId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Anular pedido',
                    text: "Tem certeza que deseja anular este pedido?",
                    showCancelButton: true,
                    confirmButtonColor: '#fff',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    customClass: {
                    confirmButton: 'deleteButton_alert',
                    cancelButton: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                    },	
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar formulário de anulação
                        document.getElementById(`anular-form-${documentId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection