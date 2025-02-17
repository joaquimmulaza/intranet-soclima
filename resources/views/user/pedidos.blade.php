@extends('master.layout')
@section('title', 'Listagem de pedidos de férias')

@section('content')


{{-- CABEÇALHO BREADCRUMB--}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    
                    <li class="breadcrumb-item active">Gerenciar pedidos de férias</li>
                    
                    <li class="breadcrumb-item active">Suas solicitações de férias</li>
               
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

    <div class="container-fluid hidden">
        <div>
            <div>
                <div>
                    <div>
                      
                           
                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                            
                   




<section class="containerPrincipal">
    <div class="containerPrincipal">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                <div class="">
                    
                <div class="main_container docs_container">
<hr class="custom_hr_justificativos">
@if($ferias->count() > 0)
    @if($user->id == $responsavelId)
        @foreach($ferias as $feria)
        <a class="view_justificativos" href="#">
            
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
                
                <tbody>
                
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
                            
                        <div class="containerOpt">
                                <!-- class .btnOpt removida -->
                                <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-{{ $feria->id }}" style="margin: 0 !important; padding: 0 !important;">
                                    <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                                </button>
                                <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body modal-bodyOpt">
                                                <div class="containerBtnOpt_justificativos">
                                                @if($feria->status === 'Pendente')
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
                                                <button style="border-bottom-right-radius: 5px;    border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{ $feria->id }}">
                                                    <a href="{{ route('ferias.show', $feria->user_id) }}">
                                                        Consultar férias
                                                        </a>
                                                    </button>
                                                
                                                @else
                                                <button style="border-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{ $ausencia->id }}">
                                                        Consultar férias
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
        </a>
            <div style="margin-bottom: 20px;"></div> <!-- Espaçamento explícito entre tabelas -->
        @endforeach
    @else
        @foreach($ferias  as $feria)
            <a class="view_justificativos" href="#">
                
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
                    
                    <tbody>
                    
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
                                
                            <div class="containerOpt">
                                    <!-- class .btnOpt removida -->
                                    <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-{{ $feria->id }}" style="margin: 0 !important; padding: 0 !important;">
                                        <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                                    </button>
                                    <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{ $feria->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body modal-bodyOpt">
                                                    <div class="containerBtnOpt_justificativos">
                                                    @if($feria->status === 'Pendente')
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
                                                
                                                    
                                                    
                                                    <button style="border-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  >
                                                    <a href="{{ route('ferias.show', $feria->user_id) }}">
                                                            Consultar férias
                                                            </a>
                                                        </button>
                                                    @else
                                                    <button style="border-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  >
                                                    <a href="{{ route('ferias.show', $feria->user_id) }}">
                                                            Cancelar pedido
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
            </a>
            <div style="margin-bottom: 20px;"></div> <!-- Espaçamento explícito entre tabelas -->
        @endforeach
        @endif
@else
    <div style="text-align: center; width: 1080px; margin: 0 auto;">
        <div class="imgEmptyPage">
            <img src="{{asset('logo/img/icon/holiday_icon.svg')}}" alt="">
        </div>
        <div class="textEmptyPage">
            <h3>De momento não há solicitações de férias</h3>
            <p>As solicitações de férias do departamento que você lidera serão exibidas aqui assim que forem enviadas.</p>
        </div>
    </div>
@endif

</div>
            </div>
        </div>
    </div>
</section>



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
</script>
@endsection
