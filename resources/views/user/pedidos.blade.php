@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')


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
            
            <tbody  data-toggle="modal" data-target="#modalFeriasResumo-{{ $feria->id }}">
            
                <tr>
                    
                    <td class="">
                        <span class="{{ $feria->status }}">{{ $feria->status }}</span>
                    </td>
                    <td class=""> 
                        @if ($feria->user)
                            {{ $feria->user->name }}
                        @else
                            Usuário não encontrado
                        @endif</td>
                    <td class="">{{ $feria->data_fim }}</td>
                    <td class="">
                        @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                            {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                        @else
                        dias
                        @endif
                    </td>
                    <td class="">{{ $feria->data_retorno_prevista }}</td>
                    <td class="OptDocs">            
                    <div class="containerOpt containerOptFerias">
                    <!-- class .btnOpt removida -->
            <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-{{ $feria->id }}" style="margin: 0 !important; padding: 0 !important;">
                <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
            </button>
            <div class="modal modalHidden fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body modal-bodyOpt">
                            <div class="containerBtnOpt_justificativos">
                                @if($feria->status === 'Pendente')
                                @can('app.dashboard')
                                <form action="" method="POST" class="">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Aprovado">
                                    <button style="border-bottom: none;border-top-right-radius: 5px;    border-top-left-radius: 5px;" type="submit" class="btnPosts">
                                    <a href="{{ route('ferias.aprovar', $feria->id) }}">Aceitar</a>
                                    </button>
                                </form>
                            
                            
                                <form action="" method="POST" class="">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Rejeitado">
                                    <button style="border-bottom: none;" type="submit" class="btnPosts">
                                    <a  href="{{ route('ferias.rejeitar', $feria->id) }}">Rejeitar</a>
                                    </button>
                                </form>
                                @endcan
                                <button style="border-bottom-right-radius: 5px;    border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{ $feria->id }}">
                                    <a href="{{ route('ferias.show', $feria->user_id) }}">
                                        Consultar férias
                                    </a>
                                </button>
                            
                                @else
                                <button style="border-radius: 5px;" type="button" class="btnPosts btnOptFerias btnPostsDelete "  ">
                                    <a href="{{ route('ferias.show', $feria->user_id) }}">
                                        Consultar férias
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

        
    </div>
    <div style="margin-bottom: 20px;"></div>
    @endforeach
</section>


@foreach($ferias as $feria) 
<div class="modal fade modalFeriasResumo" id="modalFeriasResumo-{{ $feria->id}}" tabindex="-1" aria-labelledby="modalTesteLabel" aria-hidden="true">
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
                    @if(isset($feria))
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
                    <p>Dias utéis a gozar: @if($feria->diasSolicitados($feria->data_inicio, $feria->data_fim) == 1)
                                    {{ $feria->diasSolicitados($feria->data_inicio, $feria->data_fim) }} dia
                                @else
                                dias
                                @endif</p>
                    <p>Data de retorno prevista: {{ $feria->data_retorno_prevista }}</p>
                    @if($feria->status == 'Pendente')
                        <p>
                            Status do pedido: <strong>Pendente de aprovação!</strong>
                        </p>
                        @if($user->role_id == 1)
                        
                        @else
                        
                        <p class="corNota">Nota: O seu pedido será analisado pelo departamento de Recursos Humanos. Assim que for aprovado, receberá uma notificação.</p>
                        @endif
                    @elseif($feria->data_fim < date('Y-m-d'))
                        <p> Status do pedido: <strong>{{$feria->status}}</strong></p>
                        <p class="corNota">Nota: Férias gozadas</p>
                    @endif
                   
               </div>
            </div>
            
            <div class="modal-footer">
                <div class="btnResumeFerias">
                @if($user->role_id == 1)
                    <a href="#">Consultar férias</a>
                    <a href="#">Rejeitar</a>
                    <a href="#">Aprovar</a>
                @else
                <a href="#" data-dismiss="modal" aria-label="Fechar">Fechar</a>
                @endif
                @else
                @endif
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
</script>
@endsection
