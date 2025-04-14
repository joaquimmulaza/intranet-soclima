@extends('master.layout')
@section('content')
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
    <div class="main_container doc_container content_ausencia visible" id="content-justificada">
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
                    <div class="aprovacao_container_justificativos aprovacao_container_injustificada">
                        @if(!empty($documentRequest->observacoes_admin))
                            <div class="container_obs_desc">
                                <span>Observações</span>
                                <span style="background: #fff;">{{ $documentRequest->observacoes_admin }}</span>
                            </div>
                        @endif
                        @if($documentRequest->status === 'pendente')
                            @can('app.dashboard')
                                <div class="form-group mySelectAusencias">
                                    <label for="observacoes_admin">Adicionar observação</label>
                                    <input type="text" name="observacoes_admin" class="form-injustificada-input">
                                </div>
                                <div class="ausencias_container_btn">
                                    <!-- Botão para gerar o documento -->
                                    <button type="submit" id="btnAprovar" class="btnAprovar">Gerar Documento</button>
                                </div>
                            @endcan
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection